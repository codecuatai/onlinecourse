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
// 3. ROUTING (Xử lý URL Dựa trên Tham số GET) - Logic Controller/Action

// 3.1. Lấy tham số Controller và Action
$controllerName = $_GET['views'] ?? 'home'; // Mặc định là 'home'
$actionName = $_GET['action'] ?? 'index'; // Mặc định là 'index'

// Chuẩn hóa tên Controller (ví dụ: 'auth' -> 'AuthController')
$className = ucfirst($controllerName) . 'Controller';


if (class_exists($className)) {
    // Controller tồn tại: Khởi tạo và gọi Action
    $controller = new $className();
    
    // 3.2. Kiểm tra và gọi Action
    if (method_exists($controller, $actionName)) {
        // GỌI PHƯƠNG THỨC XỬ LÝ (ví dụ: AuthController->processLogin())
        $controller->$actionName();
    } else {
        // Nếu Action không tồn tại trong Controller
        http_response_code(404);
        echo "Lỗi 404: Action **{$actionName}** không tìm thấy trong Controller **{$className}**.";
    }
} else {
    // 3.3. Trường hợp không phải Controller (Tải View tĩnh/Trang lỗi)
    
    // Cố gắng tải View trực tiếp (ví dụ: /views/home/about.php)
    $path = 'views/' . $controllerName . '/' . $actionName . '.php'; 
    
    if (file_exists($path)) {
        require_once $path;
    } else {
        // Không tìm thấy cả Controller và View
        http_response_code(404);
        echo "Lỗi 404: Không tìm thấy Controller/View cho đường dẫn **?views={$controllerName}&action={$actionName}**";
    }
}

// ------------------------------------------------------------
// KẾT THÚC CHƯƠNG TRÌNH
ob_end_flush(); // Đảm bảo bộ đệm đầu ra được đẩy ra trình duyệt