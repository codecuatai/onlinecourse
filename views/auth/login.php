<?php
require_once './views/layouts/header-auth.php';
?>

<body>
    <div class="container">
        <!-- Left Side - Branding -->
        <div class="branding">
            <div>
                <div class="logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                    </svg>
                    <h1>Quản lý khóa học nhóm 3</h1>
                </div>
                <h2>Quản lý khóa học<br>chuyên nghiệp</h2>
                <p>Nền tảng quản lý khóa học toàn diện, giúp bạn dễ dàng tổ chức, theo dõi và phát triển các khóa học trực tuyến.</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    <div>
                        <h3>Quản lý khóa học dễ dàng</h3>
                        <p>Tạo và quản lý khóa học với giao diện trực quan</p>
                    </div>
                </div>
                <div class="feature-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <div>
                        <h3>Theo dõi học viên</h3>
                        <p>Giám sát tiến độ và kết quả học tập</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-container">
            <div class="form-wrapper">
                <!-- Mobile Logo -->
                <div class="mobile-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                    </svg>
                    <h1>EduManage</h1>
                </div>

                <!-- Form Header -->
                <div class="form-header">
                    <h2 id="form-title">Đăng nhập</h2>
                    <p id="form-subtitle">Chào mừng bạn trở lại!</p>
                </div>

                <form action="?controllers=AuthController&action=processLogin" method="post">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <path d="M22 6l-10 7L2 6" />
                            </svg>
                            <input type="email" id="email" name="username" placeholder="email@example.com" value="<?= htmlspecialchars($old_input['username'] ?? '') ?>">
                            <?php if (isset($errors['username'])): ?>
                                <div class="error-message" style="display: block; color: red; margin-top: 5px;">
                                    <span><?= htmlspecialchars($errors['username']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="password" name="password" placeholder="••••••••">
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <div class="error-message" style="display: block; color: red; margin-top: 5px;">
                                <span><?= htmlspecialchars($errors['password']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Remember & Forgot - Only for Login -->
                    <div class="remember-forgot" id="remember-forgot">
                        <label>
                            <input type="checkbox">
                            <span>Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="?views=auth&action=forgot">Quên mật khẩu?</a>
                    </div>

                    <!-- Submit Button -->
                    <button class="submit-btn" type="submit">Đăng nhập</button>
                </form>

                <!-- Switch Mode -->
                <div class=" login-link">
                    Đã chưa có tài khoản? <a href="?views=auth&action=register">Đăng kí ngay</a>
                </div>

                <!-- Divider -->
                <div class="divider">
                    <span>hoặc</span>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <button class="social-btn">
                        <svg viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Google</span>
                    </button>
                    <button class="social-btn">
                        <svg viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span>Facebook</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
require_once './views/layouts/footer-auth.php';
?>