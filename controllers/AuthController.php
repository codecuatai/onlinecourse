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
        if (empty($username)) {
            $errors['username'] = "Vui lòng điền Tên đăng nhập/Email.";
        }

        if (empty($password)) {
            $errors['password'] = "Vui lòng điền Mật khẩu.";
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
                header('Location: ?controllers=CourseController&action=viewCourseHome'); // ĐÃ SỬA: Chuyển hướng chung về trang chủ
                exit;
            } else {
                // THÊM LỖI VÀO ĐÂY: Tài khoản không tồn tại HOẶC Mật khẩu không đúng
                $errors['general'] = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }

        // Nếu có lỗi (bao gồm lỗi general vừa gán), lưu lỗi vào session và chuyển hướng lại trang đăng nhập
        if (!empty($errors)) { // <== Đảm bảo khối này chỉ chạy khi có lỗi
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['login_errors'] = $errors;
            $_SESSION['old_input'] = ['username' => $username];
            header('Location: ?views=auth&action=login');
            exit;
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
        if (strlen($data['password']) < 6) $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
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
                $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: ?views=auth&action=login');
                exit;
            } else {
                // Lỗi CSDL (Hiếm khi xảy ra nếu validation tốt)
                $errors['db_error'] = "Đăng ký thất bại. Vui lòng thử lại sau.";
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
        header('Location: ?controllers=CourseController&action=viewCourseHome');
        exit;
    }

    //forgot
    public function forgot()
    {
        // Nếu chưa submit form → chỉ hiển thị form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?views=auth&action=forgot');
            return;
        }

        // Lấy email từ form
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['error'] = "Vui lòng nhập email!";
            header("Location: ?views=auth&action=forgot");
            exit();
        }

        // Kiểm tra email có tồn tại trong DB
        $user = $this->userModel->getUserByEmail($email);


        if (!$user) {
            $_SESSION['error'] = "Email không tồn tại trong hệ thống!";
            header("Location: ?views=auth&action=forgot");
            exit();
        }

        // Tạo mã OTP
        $otp = rand(100000, 999999);

        // Lưu OTP vào session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 300; // hết hạn sau 5 phút

        // Nội dung email
        $content = "
            <h3>Mã khôi phục mật khẩu của bạn là:</h3>
            <h2 style='color:red; font-size:28px;'>$otp</h2>
            <p>Mã này chỉ có hiệu lực trong 5 phút.</p>
        ";

        // Gửi mail
        $this->sendMailForgotPassword($email, $content);

        $_SESSION['success'] = "Mã xác nhận đã được gửi đến email của bạn!";
        header("Location: ?views=auth&action=verifyOtp");
        exit();
    }


    // ================================
    // 2️⃣ HÀM GỬI MAIL
    // ================================
    public function sendMailForgotPassword($emailTo, $content)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mynicktai1@gmail.com';
            $mail->Password   = 'rydyaaqnbuvhlhxq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('mynicktai1@gmail.com', 'Online Courses Group 3');
            $mail->addAddress($emailTo);

            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = "Quên Mật Khẩu - Online Courses Group 3";
            $mail->Body    = $content;

            $mail->send();
        } catch (Exception $e) {
            echo "Lỗi gửi Email: {$mail->ErrorInfo}";
        }
    }

    public function verifyOtp()
    {
        // Lấy OTP từ URL
        $otpFromUrl = $_POST['otp'] ?? '';

        if (
            empty($otpFromUrl)
            || !isset($_SESSION['otp'])
            || !isset($_SESSION['otp_email'])
            || $_SESSION['otp_expire'] < time()
        ) {
            echo "OTP đã hết hạn hoặc không hợp lệ!";
            exit();
        }

        // So sánh OTP
        if ($otpFromUrl != $_SESSION['otp']) {
            echo "OTP không chính xác!";
            exit();
        }

        // Nếu đúng → chuyển đến trang đặt mật khẩu mới
        header("Location: ?views=auth&action=resetPassword");
        exit();
    }

    public function resetPassword()
    {
        // Lấy dữ liệu từ form
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        // Validate
        if (empty($password) || empty($confirm)) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
            header("Location: ?views=auth&action=resetPassword");
            exit();
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Mật khẩu phải có ít nhất 6 ký tự!";
            header("Location: ?views=auth&action=resetPassword");
            exit();
        }

        if ($password !== $confirm) {
            $_SESSION['error'] = "Mật khẩu xác nhận không trùng khớp!";
            header("Location: ?views=auth&action=resetPassword");
            exit();
        }

        // Hash mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Lấy email từ session
        $email = $_SESSION['otp_email'];


        // Update mật khẩu trong model
        $this->userModel->updatePasswordByEmail($email, $hashedPassword);

        // Xóa session OTP
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
        unset($_SESSION['otp_expire']);

        $_SESSION['success'] = "Cập nhật mật khẩu thành công! Hãy đăng nhập lại.";

        header("Location: ?views=auth&action=login");
        exit();
    }

    public function changePassword()
    {
        // Lấy ID user từ GET
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            echo "<script>alert('Thiếu ID người dùng'); window.history.back();</script>";
            exit;
        }

        $userId = intval($_SESSION['user_id']);

        // Lấy dữ liệu từ form
        $oldPassword     = $_POST['old_password'] ?? '';
        $newPassword     = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validate input rỗng
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.history.back();</script>";
            exit;
        }

        // Validate trùng confirm
        if ($newPassword !== $confirmPassword) {
            echo "<script>alert('Mật khẩu xác nhận không trùng khớp'); window.history.back();</script>";
            exit;
        }

        // Lấy thông tin người dùng
        require_once './models/User.php';
        $userModel = new User();
        $user = $userModel->getUserById($userId);

        if (!$user) {
            echo "<script>alert('Không tìm thấy người dùng'); window.history.back();</script>";
            exit;
        }

        // Kiểm tra mật khẩu cũ đúng hay không
        if (!password_verify($oldPassword, $user['password'])) {
            echo "<script>alert('Mật khẩu cũ không chính xác'); window.history.back();</script>";
            exit;
        }

        // Không cho phép dùng lại mật khẩu cũ
        if (password_verify($newPassword, $user['password'])) {
            echo "<script>alert('Mật khẩu mới không được trùng mật khẩu cũ'); window.history.back();</script>";
            exit;
        }

        // Hash mật khẩu mới
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu
        $update = $userModel->updatePasswordById($userId, $hashedPassword);

        if ($update) {
            echo "<script>alert('Đổi mật khẩu thành công'); window.location.href='?controllers=AuthController&action=login';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại'); window.history.back();</script>";
        }
    }
    
}
