<?php
// ------------------------------------------------------------
// CẤU HÌNH LỖI (CHỈ DÙNG TRONG MÔI TRƯỜNG PHÁT TRIỂN)
date_default_timezone_set('Asia/Ho_Chi_Minh');
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ------------------------------------------------------------
// 3. NẠP TẤT CẢ CÁC FILE CẦN THIẾT (Sử dụng require_once thủ công)
// Nếu bạn sử dụng phương pháp này, bạn phải đảm bảo rằng TẤT CẢ Controllers 
// và Database/Config file đều được thêm vào đây.
require_once './config/config.php';
require_once './config/Database.php';
require_once './config/session.php';
require_once "./models/mailer/Exception.php";
require_once "./models/mailer/PHPMailer.php";
require_once "./models/mailer/SMTP.php";
require_once "./controllers/AuthController.php";
require_once "./controllers/AdminController.php";
// Lưu ý: Nếu có Models, bạn cũng cần require chúng ở đây.

// ------------------------------------------------------------
// 4. ROUTING (Xử lý URL Dựa trên Tham số GET) - Phương pháp cũ hơn
$view = _VIEW;
$action = _ACTION;
$instructor = _INSTRUCTOR;

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
