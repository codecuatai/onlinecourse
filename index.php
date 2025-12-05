<?php
// Bắt buộc phải có file config, nếu không có, ứng dụng sẽ không chạy đúng
require_once "./config/config.php";
require_once "./models/mailer/Exception.php";
require_once "./models/mailer/PHPMailer.php";
require_once "./models/mailer/SMTP.php";

// ------------------------------------------------------------
// CẤU HÌNH LỖI (CHỈ DÙNG TRONG MÔI TRƯỜNG PHÁT TRIỂN)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ------------------------------------------------------------
// 1. KHỞI ĐỘNG SESSION
// Session cần thiết cho việc duy trì trạng thái đăng nhập/giỏ hàng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ------------------------------------------------------------
// 2. ĐỊNH NGHĨA HẰNG SỐ ROOT VÀ BASE_URL
// Định nghĩa ROOT (Đường dẫn File tuyệt đối đến thư mục gốc)
define('ROOT', __DIR__);

// Định nghĩa BASE_URL (Đường dẫn HTTP tuyệt đối cho Assets)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
// CẦN THAY ĐỔI: Đảm bảo tên thư mục dự án KHỚP VỚI THỰC TẾ
$project_folder = '/onlinecourse';
define('BASE_URL', $protocol . '://' . $host . $project_folder);

// ------------------------------------------------------------
// 3. NẠP TẤT CẢ CÁC FILE CẦN THIẾT (Sử dụng require_once thủ công)
// Nếu bạn sử dụng phương pháp này, bạn phải đảm bảo rằng TẤT CẢ Controllers 
// và Database/Config file đều được thêm vào đây.
require_once ROOT . '/config/Database.php';
require_once ROOT . '/controllers/AuthController.php';
require_once ROOT . '/controllers/HomeController.php';
require_once ROOT . '/controllers/CourseController.php';
// Lưu ý: Nếu có Models, bạn cũng cần require chúng ở đây.

// ------------------------------------------------------------
// 4. ROUTING (Xử lý URL Dựa trên Tham số GET) - Phương pháp cũ hơn

// Lấy Controller và Action từ URL (Sử dụng $_GET)
// Ví dụ: http://localhost:8080/onlinecourse/index.php?controller=auth&action=login
$controller_segment = $_GET['controller'] ?? 'home';
$method_segment = $_GET['action'] ?? 'index';

// Chuẩn hóa tên Controller (e.g., 'auth' -> 'AuthController')
$controller_name = ucfirst(strtolower($controller_segment)) . 'Controller';
$method_name = strtolower($method_segment);

// Xử lý các action liên quan đến POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ví dụ: action=login (POST) -> processLogin
    $method_name = 'process' . ucfirst($method_name);
}

// KHÔNG cần kiểm tra $controller_file vì chúng ta đã require_once ở trên
$controller_class = $controller_name;

// ------------------------------------------------------------
// 5. THỰC THI CONTROLLER/ACTION

// Kiểm tra xem Class (Controller) đã được nạp hay chưa
if (class_exists($controller_class)) {

    $controller = new $controller_class();

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
    // Xử lý lỗi: Controller không tồn tại (Lỗi này hiếm xảy ra nếu đã require ở bước 3)
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "<p>Controller '{$controller_class}' không tồn tại. Đảm bảo tên Class đã đúng.</p>";
}
