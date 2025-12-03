<?php
// 1. Khởi động Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. ĐỊNH NGHĨA HẰNG SỐ ROOT (Đường dẫn File tuyệt đối)
define('ROOT', __DIR__);

// 3. ĐỊNH NGHĨA BASE_URL (Đường dẫn HTTP tuyệt đối cho Assets)
// Mục tiêu: http://localhost:8080/onlinecourse
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
// CẦN THAY ĐỔI: Đảm bảo tên thư mục dự án KHỚP VỚI THỰC TẾ
$project_folder = '/onlinecourse'; 

define('BASE_URL', $protocol . '://' . $host . $project_folder); 

// 4. Khai báo các Controller (sử dụng ROOT)
require_once ROOT . '/config/Database.php';
require_once ROOT . '/controllers/AuthController.php';
require_once ROOT . '/controllers/HomeController.php'; // 👈 FIX LỖI: Đã tải file Controller
require_once ROOT . '/controllers/CourseController.php';

// 5. Lấy Controller và Action từ URL
// Khi truy cập http://localhost:8080/onlinecourse/ mà không có tham số GET
// thì $controller_name sẽ là 'home'
$controller_name = $_GET['controller'] ?? 'home'; 
$action_name = $_GET['action'] ?? 'index'; 

// Chuẩn hóa tên Controller (e.g., 'home' -> 'HomeController')
$controller_class = ucfirst(strtolower($controller_name)) . 'Controller';

// 6. Kiểm tra và Gọi Controller/Action
if (class_exists($controller_class)) {
    
    $controller = new $controller_class();
    
    // Xử lý các action liên quan đến POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action_name = 'process' . ucfirst($action_name);
    }
    
    if (method_exists($controller, $action_name)) {
        $controller->$action_name();
    } else {
        // Xử lý lỗi: Action không tồn tại
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "<p>Action '{$action_name}' không tồn tại trong Controller '{$controller_class}'.</p>";
    }
} else {
    // Xử lý lỗi: Controller không tồn tại (Lỗi này đã được khắc phục)
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1></h1>";
    echo "<p>Controller '{$controller_class}' không tồn tại. Đảm bảo file đã được include.</p>";
}