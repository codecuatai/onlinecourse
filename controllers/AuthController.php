<?php
// controllers/AuthController.php

require_once '../config/Database.php';
require_once '../models/User.php'; 

class AuthController {
    private $user_model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection(); // Lấy đối tượng PDO connection
        $this->user_model = new User($db);
    }
    
    // ... (các phương thức register() và handleRegister() tương tự như trước, 
    //      nhưng chúng gọi các phương thức trong User.php đã dùng PDO)
    
    public function register() {
        // Tải View đăng ký
        include '../views/auth/register.php';
    }

    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $fullname = trim($_POST['fullname'] ?? '');
            $error = '';
            
            if (empty($username) || empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ các trường bắt buộc.";
            } elseif ($this->user_model->isExist($username, $email)) { // Gọi phương thức PDO
                $error = "Tên đăng nhập hoặc Email đã tồn tại.";
            }
            
            if (!empty($error)) {
                include '../views/auth/register.php';
                return;
            }

            if ($this->user_model->create($username, $email, $password, $fullname)) { // Gọi phương thức PDO
                header('Location: /login?registered=success');
                exit;
            } else {
                $error = "Đăng ký thất bại. Lỗi hệ thống.";
                include '../views/auth/register.php';
            }
        } else {
            $this->register();
        }
    }

    public function login() {
        include '../views/auth/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $error = '';
            
            $user_data = $this->user_model->findByUsername($username); // Gọi phương thức PDO

            if ($user_data && password_verify($password, $user_data['password'])) {
                
                // Đăng nhập thành công, lưu thông tin vào Session
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['fullname'] = $user_data['fullname'];
                $_SESSION['role'] = $user_data['role'];
                
                // Chuyển hướng đến dashboard phù hợp
                if ($_SESSION['role'] == 2) {
                    header('Location: /admin/dashboard');
                } elseif ($_SESSION['role'] == 1) {
                    header('Location: /instructor/dashboard');
                } else {
                    header('Location: /student/dashboard');
                }
                exit;

            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include '../views/auth/login.php';
            }
        } else {
            $this->login();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
?>