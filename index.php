<?php
// ------------------------------------------------------------
// 1. Khởi động Session
// Bắt đầu Session nếu chưa có Session nào đang hoạt động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ------------------------------------------------------------
// 2. ĐỊNH NGHĨA HẰNG SỐ ROOT (Đường dẫn File tuyệt đối)
// ROOT sẽ là đường dẫn tuyệt đối đến thư mục chứa file index.php này
define('ROOT', __DIR__);

// ------------------------------------------------------------
// 3. ĐỊNH NGHĨA BASE_URL (Đường dẫn HTTP tuyệt đối cho Assets)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// CẦN THAY ĐỔI: Đảm bảo tên thư mục dự án KHỚP VỚI THỰC TẾ (ví dụ: /onlinecourse)
$project_folder = '/onlinecourse'; 

define('BASE_URL', $protocol . '://' . $host . $project_folder); 

// ------------------------------------------------------------
// 4. Khai báo các Controller và Database (Sử dụng ROOT)
// Đảm bảo rằng các file này tồn tại trong thư mục tương ứng
require_once ROOT . '/config/Database.php';
require_once ROOT . '/controllers/AuthController.php';
require_once ROOT . '/controllers/HomeController.php';
require_once ROOT . '/controllers/CourseController.php';

// ------------------------------------------------------------
// 5. Lấy Controller và Action từ URL (Sử dụng $_GET)

// Lấy tên Controller từ tham số 'controller', mặc định là 'home'
$controller_name = $_GET['controller'] ?? 'home'; 
// Lấy tên Action từ tham số 'action', mặc định là 'index'
$action_name = $_GET['action'] ?? 'index'; 

// Chuẩn hóa tên Controller (e.g., 'home' -> 'HomeController')
$controller_class = ucfirst(strtolower($controller_name)) . 'Controller';

// ------------------------------------------------------------
// 6. Kiểm tra và Gọi Controller/Action

// Kiểm tra xem class Controller đã được include có tồn tại hay không
if (class_exists($controller_class)) {
    
    $controller = new $controller_class();
    
    // Xử lý các action liên quan đến POST (ví dụ: 'login' -> 'processLogin')
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action_name = 'process' . ucfirst($action_name);
    }
    
    // Kiểm tra xem phương thức (Action) có tồn tại trong Controller hay không
    if (method_exists($controller, $action_name)) {
        $controller->$action_name(); // Thực thi Action
    } else {
        // Xử lý lỗi: Action không tồn tại
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "<p>Action '{$action_name}' không tồn tại trong Controller '{$controller_class}'.</p>";
    }
} else {
    // Xử lý lỗi: Controller không tồn tại (Dù đã require ở bước 4)
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "<p>Controller '{$controller_class}' không tồn tại. Đảm bảo file đã được include và tên class đã được định nghĩa đúng.</p>";
}