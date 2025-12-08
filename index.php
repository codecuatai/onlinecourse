<?php
// ------------------------------------------------------------
// CẤU HÌNH LỖI VÀ TIMEZONE
date_default_timezone_set('Asia/Ho_Chi_Minh');
ob_start(); // Bắt đầu bộ đệm đầu ra để ngăn lỗi header()
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ------------------------------------------------------------
// 1. QUẢN LÝ SESSION VÀ ĐỊNH NGHĨA HẰNG SỐ GỐC
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// KHẮC PHỤC LỖI: Định nghĩa hằng số ROOT (Đường dẫn tuyệt đối đến thư mục 'onlinecourse')
define('ROOT', __DIR__);


// ------------------------------------------------------------
// 2. NẠP TẤT CẢ CÁC FILE CẦN THIẾT (Sử dụng require_once thủ công)
// Tải Config, Database, Model, Controller
require_once './config/config.php';
require_once './config/Database.php';
require_once './config/session.php';
require_once "./models/mailer/Exception.php";
require_once "./models/mailer/PHPMailer.php";
require_once "./models/mailer/SMTP.php";
require_once "./controllers/AuthController.php";
require_once "./controllers/AdminController.php";
require_once "./controllers/StudentController.php";
require_once "./controllers/InstructorController.php";
// Ghi chú: Bạn cần require các file Model khác (như User.php) nếu chúng chưa được Controller yêu cầu.

// ------------------------------------------------------------
// 4. ROUTING (Xử lý URL Dựa trên Tham số GET) - Phương pháp cũ hơn
$view = _VIEW;
$action = _ACTION;
$instructor = _INSTRUCTOR;
$controller = _CONTROLLERS;

// Lấy giá trị từ URL nếu có
if (!empty($_GET['views'])) {
    $view = $_GET['views'];
}
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}
if (!empty($_GET['instructor'])) {
    $instructor = $_GET['instructor'];
}
if (!empty($_GET['controllers'])) {
    $controllers = $_GET['controllers'];
}



if (!empty($controllers)) {
    $path = 'controllers/' . $controllers;
} else {
    // Build path
    if (!empty($instructor)) {
        // Nếu là instructor
        $path = 'views/' . $view . '/' . $instructor . '/' . $action . '.php';
    } else {
        // Người dùng bình thường
        $path = 'views/' . $view . '/' . $action . '.php';
    }

    // Include file
    if (!empty($path)) {
        if (file_exists($path)) {
            require_once $path;
        } else {
            echo "Không tìm thấy trang!";
        }
    } else {
        echo "Truy cập lỗi";
    }
}

// ------------------------------------------------------------
// KẾT THÚC CHƯƠNG TRÌNH
ob_end_flush(); // Đảm bảo bộ đệm đầu ra được đẩy ra trình duyệt