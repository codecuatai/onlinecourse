<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../config/Database.php';

class CourseController
{

    private $courseModel;

    public function __construct()
    {
        if (!session_id()) session_start();

        $this->courseModel = new Course();
    }

    // hiện thị danh sách khóa học ở trang khóa học
    public function viewAllCourses()
    {
        // Lấy tất cả khóa học từ model
        $stmt = $this->courseModel->getAll(); // hoặc phương thức phù hợp trong model
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['courses'] = $courses;
        header('Location: ?views=courses&action=index');
        exit;
    }

    public function viewCourseHome()
    {
        $stmt = $this->courseModel->getLimit3(); // hoặc phương thức phù hợp trong model
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['courses'] = $courses;
        header('Location: ?views=home&action=index');
        exit;
    }
    public function viewDetail()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Nếu không có id, chuyển về trang home
            header('Location: ?views=home&action=index');
            exit;
        }

        $id = (int) $_GET['id']; // đảm bảo id là số nguyên
        $course = $this->courseModel->getCourseById($id);

        if (!$course) {
            // Nếu không tìm thấy khóa học, chuyển về trang home hoặc hiển thị thông báo
            header('Location: ?views=home&action=index');
            exit;
        }

        // Gọi view và truyền dữ liệu
        require_once './views/courses/detail.php';
    }



    // Danh sách khóa học của giảng viên
    public function manage()
    {
        $instructor_id = $_SESSION['user']['id'];
        $stmt = $this->courseModel->getCoursesByInstructor($instructor_id);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include "views/instructor/course/manage.php";
    }

    // Hiển thị form tạo khóa học
    public function create()
    {
        include "views/instructor/course/create.php";
    }

    // Lưu khóa học mới
    public function store()
    {
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
    public function edit()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=course&action=manage");
            return;
        }

        $id = $_GET['id'];
        $course = $this->courseModel->getCourseById($id);
        include "views/instructor/course/edit.php";
    }

    // Lưu chỉnh sửa
    public function update()
    {
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
    public function delete()
    {
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




    // ✅ HIỂN THỊ DANH SÁCH KHÓA HỌC
    public function index()
    {
        $stmt = $this->courseModel->getAll();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../views/courses/index.php';
    }


    // ✅ TÌM KIẾM KHÓA HỌC
    public function search()
    {
        $keyword  = $_GET['keyword']  ?? '';
        $category = $_GET['category'] ?? '';
        $sort     = $_GET['sort'] ?? '';

        $stmt = $this->courseModel->search($keyword, $category, $sort);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/courses/index.php';
    }

    // ✅ XEM CHI TIẾT KHÓA HỌC
    public function detail()
    {
        $id = $_GET['id'];
        $course = $this->courseModel->getById($id);
        require_once __DIR__ . '/../views/courses/detail.php';
    }
}
