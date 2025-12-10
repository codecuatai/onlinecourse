<?php

require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private $userModel;

    public function __construct()
    {
        // Khởi tạo User Model để tương tác với CSDL
        $this->userModel = new User();
    }

    public function viewUser()
    {
        $users = $this->userModel->getAllUsers();
        $_SESSION['list_user'] = $users;
        // Gọi view và truyền dữ liệu
        header("Location: ?views=users&action=manage");
    }
// Xử lý POST để tạo người dùng
    public function createUser()
    {
        // Kiểm tra xem form đã submit chưa
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'role' => $_POST['role'] ?? 0
            ];

            // Gọi model để tạo user
            $result = $this->userModel->createUser($data);

            if ($result) {
                // Thành công, redirect về danh sách người dùng
                header('Location: ?controllers=AdminController&action=viewUser');
                exit;
            } else {
                // Thất bại
                $error = "Không thể tạo người dùng mới.";
                header('Location: ?views=users&action=create');
            }
        }
    }
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $this->userModel->deleteUser($id);
        }
        header('Location: ?controllers=AdminController&action=viewUser');
        exit;
    }


    public function editUserForm()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        }

        $id = (int) $_GET['id'];
        $user = $this->userModel->getUserById($id); // bạn nên thêm getUserById trong model
        $_SESSION['user'] = $user;
        header('Location: ?views=users&action=edit');
    }

    // Xử lý POST để cập nhật người dùng
    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'role' => $_POST['role'] ?? 0,
                'password' => $_POST['password'] ?? '' // nếu bỏ trống, password không thay đổi
            ];

            $result = $this->userModel->updateUser($id, $data);

            // Chuyển về danh sách user sau khi cập nhật
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        } else {
            // Nếu truy cập trực tiếp, chuyển về danh sách
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        }
    }


/**
     * Duyệt khóa học – Lấy danh sách khóa học chờ duyệt
     */
    public function browseCourses()
    {
        require_once __DIR__ . '/../config/Database.php';
        require_once __DIR__ . '/../models/Course.php';

        $database = new Database();
        $db = $database->getConnection();
        $courseModel = new Course($db);

        // Gọi hàm vừa thêm
        $courses = $courseModel->getPendingCourses();

        include_once __DIR__ . '/../views/admin/browseCourses.php';
    }

/**
     * Xử lý duyệt khóa học (Chuyển status sang 'published')
     */
    public function approveCourse()
    {
        // 1. Nhúng Model và Database
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../config/Database.php'; 

        // 2. Lấy ID và thiết lập trạng thái
        $id = $_GET['id'] ?? 0;
        $status = 'published'; // Trạng thái: Đã duyệt

        if ($id > 0) {
            $database = new Database();
            $db = $database->getConnection();
            $courseModel = new Course($db);

            // 3. Gọi Model để cập nhật trạng thái
            if ($courseModel->updateStatus($id, $status)) {
                $_SESSION['success_message'] = "Khóa học đã được duyệt thành công!";
            } else {
                $_SESSION['error_message'] = "Lỗi CSDL khi duyệt khóa học.";
            }
        }
        
        // 4. Chuyển hướng về trang duyệt khóa học
        header('Location: ?views=admin&action=browseCourses');
        exit;
    }

    /**
     * Xử lý từ chối khóa học (Chuyển status sang 'rejected')
     */
    public function rejectCourse()
    {
        // 1. Nhúng Model và Database
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../config/Database.php';

        // 2. Lấy ID và thiết lập trạng thái
        $id = $_GET['id'] ?? 0;
        $status = 'rejected'; // Trạng thái: Bị từ chối

        if ($id > 0) {
            $database = new Database();
            $db = $database->getConnection();
            $courseModel = new Course($db);

            // 3. Gọi Model để cập nhật trạng thái
            if ($courseModel->updateStatus($id, $status)) {
                $_SESSION['success_message'] = "Khóa học đã bị từ chối.";
            } else {
                $_SESSION['error_message'] = "Lỗi CSDL khi từ chối khóa học.";
            }
        }
        
        // 4. Chuyển hướng về trang duyệt khóa học
        header('Location: ?views=admin&action=browseCourses');
        exit;
    }

    public function manageCourses()
    {
        // Yêu cầu Model và Database (như đã làm trong browseCourses)
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../config/Database.php'; 

        $database = new Database();
        $db = $database->getConnection();
        $courseModel = new Course($db);

        // Lấy TẤT CẢ khóa học (hoặc tất cả trừ pending)
        // Tùy thuộc vào hàm bạn có, ví dụ: getAll()
        $courses = $courseModel->getAll(); 
        
        $courses = $courses ?? [];

        // ✅ SỬA ĐƯỜNG DẪN VIEW VÀO THƯ MỤC USER/GIẢNG VIÊN
        // Giả định file manage.php nằm ở views/user/manage.php
        include_once __DIR__ . '/../views/user/manage.php'; 
    }

}

$admin = new AdminController();
