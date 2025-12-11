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

// ------------------------------------------------------------
// 4. ROUTING (Xử lý URL Dựa trên Tham số GET) - Phương pháp cũ hơn
$controllers = $_GET['controllers'] ?? null;
$action = $_GET['action'] ?? null;
$view = $_GET['views'] ?? _VIEW;
$instructor = $_GET['instructor'] ?? null;

if (empty($controllers) && $view === 'admin') {
    // Nếu không có tham số 'controllers=...' NHƯNG có 'views=admin', 
    // ta gán tên Controller chính xác để khối IF dưới xử lý.
    $controllers = 'AdminController';
}

if (!empty($controllers)) {
    // ------------------------------------------------------------
    // XỬ LÝ CONTROLLER (E.g., AuthController)

    $controllerClassName = $controllers;
    $controllerPath = 'controllers/' . $controllerClassName . '.php';

    // 1. Kiểm tra và nạp Controller (NẾU CHƯA NẠP Ở ĐẦU FILE)
    if (!class_exists($controllerClassName)) {
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
        } else {
            die("Lỗi: Không tìm thấy file Controller '{$controllerPath}'.");
        }
    }

    // 2. Khởi tạo Controller và Gọi Action
    if (class_exists($controllerClassName)) {
        $controllerInstance = new $controllerClassName();

        // Mặc định action là index nếu không được cung cấp (ví dụ: ?controllers=Home)
        $actionMethod = $action ?? 'index';

        if (method_exists($controllerInstance, $actionMethod)) {
            // THỰC THI PHƯƠNG THỨC: Đây là nơi processLogin() được gọi
            $controllerInstance->$actionMethod();
            // Nếu lệnh header() và exit; trong processLogin() chạy, code sẽ dừng ở đây.

        } else {
            // Lỗi nếu action không tồn tại
            die("Lỗi: Phương thức action '{$actionMethod}' không tồn tại trong Controller.");
        }
    } else {
        die("Lỗi: Không tìm thấy Class '{$controllerClassName}'.");
    }
} elseif (!$action) {
    header('Location: ?controllers=CourseController&action=viewCourseHome');
} else {
    // ------------------------------------------------------------
    // XỬ LÝ VIEW (Logic cũ cho View tĩnh)

    // Đặt lại action mặc định cho View nếu nó không phải Controller
    $action = $_GET['action'] ?? _ACTION;

    // Build path
    if (!empty($instructor)) {
        $path = 'views/' . $view . '/' . $instructor . '/' . $action . '.php';
    } else {
        $path = 'views/' . $view . '/' . $action . '.php';
    }

    // Include file
    if (file_exists($path)) {
        require_once $path;
    } else {
        echo "Không tìm thấy trang View!";
    }
}
// ------------------------------------------------------------
// KẾT THÚC CHƯƠNG TRÌNH
ob_end_flush(); // Đảm bảo bộ đệm đầu ra được đẩy ra trình duyệt