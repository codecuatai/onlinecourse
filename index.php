<?php
// ------------------------------------------------------------
// CẤU HÌNH LỖI (CHỈ DÙNG TRONG MÔI TRƯỜNG PHÁT TRIỂN)
date_default_timezone_set('Asia/Ho_Chi_Minh');
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. KHỞI ĐỘNG SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Định nghĩa ROOT (Quan trọng cho các đường dẫn require trong Controller)
define('ROOT', __DIR__);

// ------------------------------------------------------------
// 2. NẠP TẤT CẢ CÁC FILE CẦN THIẾT (Sử dụng require_once thủ công)
// *Bạn nên chuyển sang Autoloading nếu dự án lớn hơn*
require_once './config/config.php';
require_once './config/Database.php';
require_once './config/session.php'; // Giả sử file này chứa logic liên quan đến session
// Tệp PHPMailer nên được require TỪ TRONG Controller (hoặc dùng Composer Autoload)
// Nếu bạn muốn giữ chúng ở đây:
require_once "./models/mailer/Exception.php";
require_once "./models/mailer/PHPMailer.php";
require_once "./models/mailer/SMTP.php";

require_once "./controllers/AuthController.php";
require_once "./controllers/AdminController.php";
require_once "./controllers/HomeController.php";
require_once ROOT . "/controllers/StudentController.php";  // <-- Thêm dòng này
require_once ROOT . "/controllers/InstructorController.php"; // Thêm HomeController mặc định

// ------------------------------------------------------------
// 3. ROUTING (Xử lý URL Dựa trên Tham số GET) - MVC Controller/Action

// Lấy Controller và Action từ URL (Sử dụng $_GET)
$controller_segment = $_GET['controller'] ?? 'home'; 
$method_segment = $_GET['action'] ?? 'index'; 

// Chuẩn hóa tên Controller (e.g., 'auth' -> 'AuthController')
$controller_name = ucfirst(strtolower($controller_segment)) . 'Controller';

// KHÔNG CHUẨN HÓA SANG CHỮ THƯỜNG Ở ĐÂY. Giữ nguyên case để đảm bảo ucfirst hoạt động đúng.
$method_name = $method_segment; 

// Xử lý các action liên quan đến POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Chuẩn hóa tên phương thức: process + Tên_Action (Viết hoa chữ cái đầu)
    $method_name = 'process' . ucfirst($method_name);
}

// KHÔNG cần kiểm tra $controller_file vì chúng ta đã require_once ở trên
$controller_class = $controller_name;

// ------------------------------------------------------------
// 4. THỰC THI CONTROLLER/ACTION

// Kiểm tra xem Class (Controller) đã được nạp/tồn tại chưa
if (class_exists($controller_class)) {
    
    $controller = new $controller_class();
    
    // Kiểm tra xem phương thức (Action) có tồn tại trong Class đó không
    if (method_exists($controller, $method_name)) {
        // Gọi phương thức (Action)
        $controller->$method_name();
    } else {
        // Xử lý lỗi: Action không tồn tại
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "<p>Action '{$method_name}' không tồn tại trong Controller '{$controller_class}'.</p>";
    }
} else {
    // Xử lý lỗi: Controller không tồn tại 
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "<p>Controller '{$controller_class}' không tồn tại. Vui lòng kiểm tra lại URL.</p>";
}