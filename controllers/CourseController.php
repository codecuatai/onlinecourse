<!-- // Trong controllers/CourseController.php

class CourseController {
    private $courseModel;

    public function __construct($db) {
        // Khởi tạo đối tượng Model
        $this->courseModel = new Course($db);
    }

    public function create() {
        // Kiểm tra quyền: Chỉ Giảng viên (role = 1) hoặc Admin (role = 2) được phép [cite: 28, 100]
        // if ($_SESSION['user_role'] < 1) { header('Location: /login'); exit; } 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy dữ liệu từ POST
            $data = $_POST;
            $data['instructor_id'] = $_SESSION['user_id']; // Lấy từ session người dùng đang đăng nhập

            // 2. Validate dữ liệu đầu vào (cần thực hiện chi tiết hơn)
            if (empty($data['title']) || empty($data['description'])) {
                $error = "Vui lòng điền đầy đủ tiêu đề và mô tả.";
                // Tải lại View với thông báo lỗi
                include 'views/instructor/course/create.php';
                return;
            }

            // 3. Xử lý Upload file ảnh bìa (cần code logic upload file vào assets/uploads/courses) [cite: 39, 71]
            $data['image'] = $this->handleImageUpload($_FILES['course_image']);

            // 4. Gọi Model để lưu vào CSDL
            if ($this->courseModel->createCourse($data)) {
                // Thành công: Chuyển hướng đến trang quản lý khóa học
                header('Location: /instructor/courses/manage');
                exit;
            } else {
                $error = "Lỗi tạo khóa học. Vui lòng thử lại.";
            }
        }
        
        // Tải View form tạo khóa học
        include 'views/instructor/course/create.php';
    }

    private function handleImageUpload($file) {
        // Logic xử lý upload file ảnh vào assets/uploads/courses/ [cite: 71, 98]
        // Ví dụ: kiểm tra kích thước, loại tệp, đổi tên file và trả về đường dẫn
        return 'default.jpg'; 
    }
}


// Trong controllers/CourseController.php

public function edit($course_id) {
    // 1. Kiểm tra quyền và Giảng viên sở hữu khóa học [cite: 100]
    // ...

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý CẬP NHẬT dữ liệu (logic tương tự như create, nhưng gọi updateCourse)
        $data = $_POST;
        $data['instructor_id'] = $_SESSION['user_id'];
        
        // Xử lý ảnh (giữ ảnh cũ nếu không có ảnh mới)
        if (!empty($_FILES['course_image']['name'])) {
             $data['image'] = $this->handleImageUpload($_FILES['course_image']);
        } else {
             $data['image'] = $data['current_image']; // Giữ ảnh hiện tại
        }

        if ($this->courseModel->updateCourse($course_id, $data)) {
            header('Location: /instructor/courses/manage');
            exit;
        } else {
            $error = "Lỗi cập nhật khóa học. Hoặc bạn không có quyền chỉnh sửa.";
        }
    }

    // Lấy dữ liệu khóa học hiện tại để hiển thị trên form
    $course = $this->courseModel->getCourseById($course_id);
    
    if (!$course) {
        // Xử lý lỗi không tìm thấy
        header('Location: /404');
        exit;
    }
    
    // Tải View form chỉnh sửa khóa học với dữ liệu $course
    include 'views/instructor/course/edit.php';
} -->




<?php
class CourseController {

    private $db;
    private $courseModel;

    public function __construct($db) {
        // Kiểm tra quyền: chỉ Giảng viên (role = 1) mới dùng chức năng này
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $this->db = $db;
        $this->courseModel = new Course($db);
    }

    // Danh sách khóa học của giảng viên
    public function manage() {
        $instructor_id = $_SESSION['user']['id'];
        $stmt = $this->courseModel->getCoursesByInstructor($instructor_id);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include "views/instructor/course/manage.php";
    }

    // Hiển thị form tạo khóa học
    public function create() {
        include "views/instructor/course/create.php";
    }

    // Lưu khóa học mới
    public function store() {
        $instructor_id = $_SESSION['user']['id'];

        // Validate dữ liệu
        if (empty($_POST['title']) || empty($_POST['category_id'])) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header("Location: index.php?controller=course&action=create");
            exit;
        }

        // Xử lý ảnh 
        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $target = "assets/uploads/courses/" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $image = $target;
        }

        $data = [
            ":title" => $_POST['title'],
            ":description" => $_POST['description'] ?? '',
            ":instructor_id" => $instructor_id,
            ":category_id" => $_POST['category_id'],
            ":price" => $_POST['price'] ?? 0,
            ":duration_weeks" => $_POST['duration_weeks'] ?? 0,
            ":level" => $_POST['level'] ?? 'Beginner',
            ":image" => $image
        ];

        if ($this->courseModel->create($data)) {
            $_SESSION['success'] = "Tạo khóa học thành công!";
        } else {
            $_SESSION['error'] = "Không thể tạo khóa học!";
        }

        header("Location: index.php?controller=course&action=manage");
    }

    // Hiển thị form sửa khóa học
    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=course&action=manage");
            return;
        }

        $id = $_GET['id'];
        $course = $this->courseModel->getCourseById($id);
        include "views/instructor/course/edit.php";
    }

    // Lưu chỉnh sửa
    public function update() {
        $instructor_id = $_SESSION['user']['id'];

        if (!isset($_POST['id'])) {
            header("Location: index.php?controller=course&action=manage");
            return;
        }

        $id = $_POST['id'];

        // Xử lý ảnh nếu tải mới
        $image = $_POST['old_image'];
        if (!empty($_FILES['image']['name'])) {
            $target = "assets/uploads/courses/" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $image = $target;
        }

        $data = [
            ":id" => $id,
            ":title" => $_POST['title'],
            ":description" => $_POST['description'],
            ":category_id" => $_POST['category_id'],
            ":price" => $_POST['price'],
            ":duration_weeks" => $_POST['duration_weeks'],
            ":level" => $_POST['level'],
            ":image" => $image,
            ":instructor_id" => $instructor_id
        ];

        if ($this->courseModel->update($data)) {
            $_SESSION['success'] = "Cập nhật thành công!";
        } else {
            $_SESSION['error'] = "Không thể cập nhật!";
        }

        header("Location: index.php?controller=course&action=manage");
    }

    // Xóa khóa học
    public function delete() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=course&action=manage");
            return;
        }

        $id = $_GET['id'];
        $instructor_id = $_SESSION['user']['id'];

        if ($this->courseModel->delete($id, $instructor_id)) {
            $_SESSION['success'] = "Xóa khóa học thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa!";
        }

        header("Location: index.php?controller=course&action=manage");
    }
}
