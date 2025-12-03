<?php
// views/auth/register.php
// $error được truyền từ Controller nếu đăng ký thất bại
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Tài Khoản</title>
</head>
<body>
    <h2>Đăng Ký Tài Khoản Mới</h2>

    <?php if (isset($error)): ?>
        <p style="color: red; padding: 10px; border: 1px solid red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="/auth/handleRegister" method="POST">
        <div>
            <label for="fullname">Họ và Tên:</label>
            <input type="text" id="fullname" name="fullname" required>
        </div>
        <div>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Đăng Ký</button>
    </form>
    <p>Đã có tài khoản? <a href="/auth/login">Đăng nhập ngay</a></p>
</body>
</html>