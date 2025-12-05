<?php

// Yêu cầu các Model cần thiết
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        // Khởi tạo User Model để tương tác với CSDL
        $this->userModel = new User();
    }

    /**
     * Hiển thị trang đăng nhập.
     */
    public function login()
    {
        // Hiển thị view đăng nhập
        // LƯU Ý: Nếu có thông báo lỗi từ session, cần truyền vào view
        include_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Xử lý logic đăng nhập (POST request).
     */
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Chỉ chấp nhận phương thức POST
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $errors = [];

        // 1. Validation cơ bản
        if (empty($username) || empty($password)) {
            $errors[] = "Vui lòng điền đầy đủ Tên đăng nhập/Email và Mật khẩu.";
        }

        if (empty($errors)) {
            // 2. Tìm người dùng trong CSDL
            $user = $this->userModel->findUserByIdentifier($username);

            if ($user && User::verifyPassword($password, $user['password'])) {
                // 3. Đăng nhập thành công: Thiết lập Session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role']; // 0: học viên, 1: giảng viên, 2: quản trị viên

                // 4. Điều hướng dựa trên vai trò
                if ($user['role'] == 2) {
                    // Quản trị viên
                    header('Location: index.php?controller=admin&action=dashboard');
                } elseif ($user['role'] == 1) {
                    // Giảng viên
                    header('Location: index.php?controller=instructor&action=dashboard');
                } else {
                    // Học viên (role = 0)
                    header('Location: index.php?controller=student&action=dashboard');
                }
                exit;
            } else {
                $errors[] = "Tên đăng nhập/Mật khẩu không chính xác.";
            }
        }

        // Nếu có lỗi, lưu lỗi vào session và chuyển hướng lại trang đăng nhập
        session_start();
        $_SESSION['login_errors'] = $errors;
        $_SESSION['old_input'] = ['username' => $username];
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    /**
     * Hiển thị trang đăng ký.
     */
    public function register()
    {
        // Hiển thị view đăng ký
        include_once __DIR__ . '/../views/auth/register.php';
    }

    /**
     * Xử lý logic đăng ký (POST request).
     */
    public function processRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        // Lấy dữ liệu từ form (View đã được sửa có thuộc tính name)
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'fullname' => trim($_POST['fullname'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'role' => (int)($_POST['role'] ?? 0), // Nhận giá trị 0 hoặc 1/2 từ form
        ];

        $errors = [];

        // 1. Validation chi tiết
        if (empty($data['username'])) $errors['username'] = "Tên tài khoản không được để trống.";
        if (empty($data['fullname'])) $errors['fullname'] = "Họ và tên không được để trống.";
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }
        if (strlen($data['password']) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
        if ($data['password'] !== $data['confirm_password']) $errors['confirm_password'] = "Xác nhận mật khẩu không khớp.";
        // Thêm kiểm tra terms_agreed nếu cần

        // 2. Kiểm tra trùng lặp trong CSDL
        if (empty($errors) && $this->userModel->isExist($data['username'], $data['email'])) {
            $errors['exist'] = "Tên tài khoản hoặc Email đã tồn tại.";
        }

        if (empty($errors)) {
            // 3. Nếu không có lỗi, tạo người dùng
            if ($this->userModel->createUser($data)) {
                // Đăng ký thành công
                session_start();
                $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: index.php?controller=auth&action=login');
                exit;
            } else {
                // Lỗi CSDL (Hiếm khi xảy ra nếu validation tốt)
                $errors['db_error'] = "Đăng ký thất bại. Vui lòng thử lại sau.";
            }
        }

        // Nếu có lỗi, lưu lỗi vào session và quay lại trang đăng ký
        session_start();
        $_SESSION['register_errors'] = $errors;
        $_SESSION['old_input'] = $data;
        header('Location: index.php?controller=auth&action=register');
        exit;
    }
    // Trong AuthController.php
    public function forgotPassword()
    {
        // Logic hiển thị form quên mật khẩu
        include_once ROOT . '/views/auth/forgot.php';
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout()
    {
        session_start();
        // Hủy bỏ tất cả các biến session
        $_SESSION = [];
        // Hủy session
        session_destroy();
        // Điều hướng về trang chủ hoặc trang đăng nhập
        header('Location: index.php');
        exit;
    }
}
