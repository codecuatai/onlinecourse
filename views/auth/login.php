<?php
// views/auth/login.php
// $error được truyền từ Controller nếu đăng nhập thất bại

// Chúng ta giả sử layout header/footer chưa được tích hợp
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
</head>
<body>
    <h2>Đăng Nhập Hệ Thống</h2>

    <?php if (isset($error)): ?>
        <p style="color: red; padding: 10px; border: 1px solid red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['registered']) && $_GET['registered'] == 'success'): ?>
        <p style="color: green;">Đăng ký thành công! Vui lòng đăng nhập.</p>
    <?php endif; ?>
    
    <form action="/auth/handleLogin" method="POST">
        <div>
            <label for="username">Tên đăng nhập hoặc Email:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Đăng Nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="/auth/register">Đăng ký ngay</a></p>
</body>
</html>