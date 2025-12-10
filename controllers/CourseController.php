<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../config/Database.php';

class CourseController
{

    private $courseModel;
    private $categoryModel;

    public function __construct()
    {
        if (!session_id()) session_start();

        $this->courseModel = new Course();
        $this->categoryModel = new Category();
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
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để đăng ký!";
            header("Location: views=auth&action=login");
            exit();
        }
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Nếu không có id, chuyển về trang home
            header('Location: ?views=home&action=index');
            exit;
        }

        $id = (int) $_GET['id']; // đảm bảo id là số nguyên
        $course_detail = $this->courseModel->getCourseById($id);


        if (!$course_detail) {
            // Nếu không tìm thấy khóa học, chuyển về trang home hoặc hiển thị thông báo
            header('Location: ?views=home&action=index');
            exit;
        }

        $_SESSION['course_detail'] = $course_detail;

        header("Location: ?views=courses&action=detail");
        exit;
    }


    public function viewCoursesOfInstructor()
    {
        // Giả sử bạn lưu id giảng viên trong session sau khi login
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: ?views=home&action=index");
            exit;
        }


        $instructor_id = $_SESSION['user_id'];

        // Lấy danh sách khóa học của giảng viên
        $courses = $this->courseModel->getCoursesByInstructor($instructor_id);

        // Lưu vào session hoặc truyền trực tiếp cho view
        $_SESSION['instructor_courses'] = $courses->fetchAll(PDO::FETCH_ASSOC);


        // Load view hiển thị
        header("Location: ?views=instructor&act&instructor=course&action=manage");
        exit;
    }



    public function viewCreate()
    {
        // Lấy tất cả category trực tiếp
        $_SESSION['categories'] = $this->categoryModel->getAllCategories();
        header("Location: ?views=instructor&act&instructor=course&action=create");
        exit;
    }

    // Lưu khóa học mới
    public function storeCoures()
    {
        $instructor_id = $_SESSION['user_id'];
        // Validate dữ liệu
        if (empty($_POST['title']) || empty($_POST['category_id'])) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header("Location: ?controllers=CourseController&action=viewCreate");
            exit;
        }
        /* ===================== XỬ LÝ ẢNH ===================== */
        $image = null;

        if (!empty($_FILES['image']['name'])) {

            $uploadDir = "assets/uploads/courses/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // tạo thư mục nếu chưa có
            }

            $fileName = time() . "_" . basename($_FILES['image']['name']);
            $target = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image = $target;
            } else {
                $_SESSION['error'] = "Lỗi upload ảnh!";
                header("Location: ?controllers=CourseController&action=viewCreate");
                exit;
            }
        }

        /* ===================== TẠO MẢNG DỮ LIỆU ===================== */
        $data = [
            ":title"          => $_POST['title'],
            ":description"    => $_POST['description'] ?? '',
            ":instructor_id"  => $instructor_id,
            ":category_id"    => $_POST['category_id'],
            ":price"          => $_POST['price'] ?? 0,
            ":duration_weeks" => $_POST['duration_weeks'] ?? 0,
            ":level"          => $_POST['level'] ?? 'Beginner',
            ":image"          => $image
        ];

        /* ===================== LƯU VÀO DATABASE ===================== */
        $result = $this->courseModel->create($data);

        if ($result) {
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
        } else {
            header("Location: ?controllers=CourseController&action=viewCreate");
        }

        exit;
    }


    // Xóa khóa học
    public function deleteCourseOfInstructor()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            return;
        }
        $id = $_GET['id'];
        $instructor_id = $_SESSION['user_id'];

        if ($this->courseModel->delete($id, $instructor_id)) {
            $_SESSION['success'] = "Xóa khóa học thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa!";
        }

        header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
        exit;
    }




    public function viewEdit()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            exit;
        }

        $course_id = $_GET['id'];
        $instructor_id = $_SESSION['user_id'];

        // Lấy dữ liệu khóa học
        $course = $this->courseModel->getCourseByInstructor($course_id, $instructor_id);

        if (!$course) {
            $_SESSION['error'] = "Bạn không có quyền sửa khóa học này!";
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            exit;
        }

        // Lấy danh sách categories
        $categories = $this->categoryModel->getAllCategories();

        // Gửi sang view
        $_SESSION['edit_course'] = $course;
        $_SESSION['edit_categories'] = $categories;

        header("Location: ?views=instructor&act&instructor=course&action=edit");
        exit;
    }


    public function updateCourse()
    {
        if (!isset($_POST['id'])) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            exit;
        }

        $course_id = $_POST['id'];
        $instructor_id = $_SESSION['user_id'];

        // ======================
        // Validate dữ liệu
        // ======================
        if (empty($_POST['title']) || empty($_POST['category_id'])) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header("Location: ?views=instructor&instructor=course&action=edit&id=" . $course_id);
            exit;
        }

        // ======================
        // Lấy ảnh cũ
        // ======================
        $old_image = $_POST['old_image'] ?? null;
        $image = $old_image;

        // ======================
        // Xử lý ảnh mới
        // ======================
        if (!empty($_FILES['image']['name'])) {
            $target = "assets/uploads/courses/" . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image = $target; // Ghi đè
            }
        }

        // ======================
        // Chuẩn bị dữ liệu update
        // ======================
        $data = [
            ":id"              => $course_id,
            ":instructor_id"  => $instructor_id,
            ":title"          => $_POST['title'],
            ":description"    => $_POST['description'] ?? '',
            ":category_id"    => $_POST['category_id'],
            ":price"          => $_POST['price'] ?? 0,
            ":duration_weeks" => $_POST['duration_weeks'] ?? 0,
            ":level"          => $_POST['level'] ?? 'Beginner',
            ":image"          => $image
        ];

        // ======================
        // Thực thi update
        // ======================
        if ($this->courseModel->update($data)) {
            $_SESSION['success'] = "Cập nhật khóa học thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }

        header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
        exit;
    }






    // Hiển thị form tạo khóa học
    public function create()
    {
        include "views/instructor/course/create.php";
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
