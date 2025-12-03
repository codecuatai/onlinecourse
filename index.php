<?php
// Bật chế độ báo cáo lỗi trong quá trình phát triển
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bắt đầu Session (cần thiết cho Đăng nhập/Đăng ký của Nhóm 1)
session_start();

// ------------------------------------------------------------
// 1. AUTOLOAD (Tự động nạp các lớp/class)
// Hàm spl_autoload_register() là cách hiện đại và được khuyến nghị để tự động nạp class
spl_autoload_register(function ($class_name) {
    // 1. Kiểm tra Controllers
    $controller_path = 'controllers/' . $class_name . '.php';
    if (file_exists($controller_path)) {
        require_once $controller_path;
        return;
    }

    // 2. Kiểm tra Models
    $model_path = 'models/' . $class_name . '.php';
    if (file_exists($model_path)) {
        require_once $model_path;
        return;
    }
    
    // 3. (TÙY CHỌN) Cho các file config/ (nếu cần)
    if ($class_name === 'Database' && file_exists('config/Database.php')) {
        require_once 'config/Database.php';
        return;
    }
});

// ------------------------------------------------------------
// 2. ROUTING (Xử lý URL)

// Định nghĩa thư mục gốc của dự án (BASE_URL)
// Ví dụ: Nếu bạn truy cập http://localhost/onlinecourse/ => BASE_URL là '/onlinecourse'
// Nếu bạn truy cập http://localhost/ => BASE_URL là ''
$base_url = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

// Lấy toàn bộ URL yêu cầu
$full_uri = $_SERVER['REQUEST_URI'];

// Loại bỏ base URL và loại bỏ các tham số query (nếu có)
$request_uri = str_replace($base_url, '', $full_uri);
$request_uri = strtok($request_uri, '?');
$request_uri = trim($request_uri, '/');

$segments = explode('/', $request_uri);

// Router cơ bản: Controller là segment đầu tiên, Method là segment thứ hai
$controller_name = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
$method_name = !empty($segments[1]) ? $segments[1] : 'index';

// Trường hợp đặc biệt: Nếu segments[0] rỗng (tức là trang chủ)
if (empty($segments[0])) {
    $controller_name = 'HomeController';
    $method_name = 'index';
}


// ------------------------------------------------------------
// 3. THỰC THI (Dispatching)

$controller_file = 'controllers/' . $controller_name . '.php';

if (file_exists($controller_file)) {
    // Nạp Controller file
    require_once $controller_file;
    
    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        
        // Cần đảm bảo rằng segments có đủ phần tử để slice
        $params = array_slice($segments, 2);

        if (method_exists($controller, $method_name)) {
            // Gọi phương thức (ví dụ: $authController->register())
            call_user_func_array([$controller, $method_name], $params);
            
        } else {
            // Lỗi 404: Phương thức không tìm thấy
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found: Phương thức **" . $method_name . "** không tồn tại trong Controller **" . $controller_name . "**";
        }
    } else {
        // Lỗi: Lớp Controller không tìm thấy (hiếm gặp)
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found: Lớp Controller **" . $controller_name . "** không tồn tại.";
    }
} else {
    // Lỗi 404: Controller file không tìm thấy
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found: Controller **" . $controller_name . "** không tồn tại.";
}
// KHÔNG CÓ DẤU PHẨY (,) Ở ĐÂY
?>