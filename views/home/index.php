<?php
// views/home/index.php 
// File này sẽ được gọi bởi HomeController->index()
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ | Khóa Học Online</title>
    </head>
<body>
    <header>
        <nav>
            <a href="/">Trang Chủ</a>
            <a href="/auth/login">Đăng Nhập</a>
            <a href="/auth/register">Đăng Ký</a>
        </nav>
    </header>
    <main>
        <h1>Chào mừng đến với Hệ thống Quản lý Khóa học Online!</h1>
        <p>Đây là dự án thực hành của K65.</p>
        <p>Vui lòng <a href="/auth/register">Đăng ký</a> hoặc <a href="/auth/login">Đăng nhập</a> để tiếp tục.</p>
    </main>
    <footer>
        <p>&copy; 2025 Khoa CNTT - Đại học Thủy Lợi</p>
    </footer>
</body>
</html>