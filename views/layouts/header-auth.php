<?php
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}
if ($action == 'register') {
    $title = 'Đăng Ký';
} elseif ($action == 'login') {
    $title = 'Đăng Nhập';
} elseif ($action == 'forgot') {
    $title = 'Quên mật khẩu';
} elseif ($action == 'resetPassword') {
    $title = 'Xác nhận mật khẩu';
} elseif ($action == 'changepassword') {
    $title = 'Đổi mật khấu';
} elseif ($action == 'verifyOtp') {
    $title = 'Xác Thực';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="./assets/css/auth.css">
</head>