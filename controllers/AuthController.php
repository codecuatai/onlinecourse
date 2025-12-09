<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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
            header('Location: ?views=auth&action=login');
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
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['role'] = $user['role']; // 0: học viên, 1: giảng viên, 2: quản trị viên

                // 4. Điều hướng dựa trên vai trò
                header('Location: ?views=home&action=index'); // ĐÃ SỬA: Chuyển hướng chung về trang chủ
                exit;
            } else {
                $errors[] = "Tên đăng nhập/Mật khẩu không chính xác.";
            }
        }

        // Nếu có lỗi, lưu lỗi vào session và chuyển hướng lại trang đăng nhập
        $_SESSION['login_errors'] = $errors;
        $_SESSION['old_input'] = ['username' => $username];
        header('Location: ?views=auth&action=login');
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
            header('Location: ?views=auth&action=register');
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
            $errors[] = "Tên tài khoản hoặc Email đã tồn tại.";
        }

        if (empty($errors)) {
            // 3. Nếu không có lỗi, tạo người dùng
            if ($this->userModel->createUser($data)) {
                // Đăng ký thành công
                $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: ?views=auth&action=login');
                exit;
            } else {
                // Lỗi CSDL (Hiếm khi xảy ra nếu validation tốt)
                $errors[] = "Đăng ký thất bại. Vui lòng thử lại sau.";
            }
        }

        // Nếu có lỗi, lưu lỗi vào session và quay lại trang đăng ký
        $_SESSION['register_errors'] = $errors;
        $_SESSION['old_input'] = $data;
        header('Location: ?views=auth&action=register');
        exit;
    }
    // Trong AuthController.php
    public function forgotPassword()
    {
        // Logic hiển thị form quên mật khẩu
        include_once ROOT . '/views/auth/forgot.php';
    }

    public function sendMailForgotPassword($emailTo, $content)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'mynicktai1@gmail.com';                     //SMTP username
            $mail->Password   = 'rydyaaqnbuvhlhxq';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mynicktai1@gmail.com', 'Online Courses Group 3');
            $mail->addAddress($emailTo);     //Add a recipient

            //Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Quên Mật Khẩu Tài Khoản Online Courses Group 3";
            $mail->Body    = $content;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout()
    {
        // Hủy bỏ tất cả các biến session
        $_SESSION = [];
        // Hủy session
        session_destroy();
        // Điều hướng về trang chủ hoặc trang đăng nhập
        header('Location: ?views=home&action=index');
        exit;
    }
}

$auth = new AuthController();