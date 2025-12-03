<?php
require_once '../layouts/header-auth.php'
?>

<body>
    <div class="register-container">
        <div class="header">
            <div class="logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                    <path d="M6 12v5c3 3 9 3 12 0v-5" />
                </svg>
            </div>
            <h1>Tạo tài khoản</h1>
            <p>Bắt đầu hành trình học tập của bạn</p>
        </div>

        <div class="social-login">
            <button class="social-btn" onclick="socialLogin('google')">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Google
            </button>
            <button class="social-btn" onclick="socialLogin('facebook')">
                <svg viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                Facebook
            </button>
        </div>

        <div class="divider">
            <span>hoặc đăng ký bằng email</span>
        </div>

        <div class="form-group">
            <label for="fullname">Họ và tên <span class="required">*</span></label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input type="text" id="fullname" placeholder="Nguyễn Văn A">
            </div>
            <div class="error-message" id="fullname-error" style="display: none;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path fill="white" d="M12 8v4m0 4h.01" />
                </svg>
                <span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <path d="M22 6l-10 7L2 6" />
                </svg>
                <input type="email" id="email" placeholder="email@example.com">
            </div>
            <div class="error-message" id="email-error" style="display: none;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path fill="white" d="M12 8v4m0 4h.01" />
                </svg>
                <span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                <input type="tel" id="phone" placeholder="0912345678">
            </div>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu <span class="required">*</span></label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" id="password" placeholder="Ít nhất 6 ký tự">
                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
            <div class="password-strength" id="password-strength" style="display: none;">
                <div class="strength-bar">
                    <div class="strength-bar-fill" id="strength-bar"></div>
                </div>
                <div class="strength-text" id="strength-text"></div>
            </div>
            <div class="error-message" id="password-error" style="display: none;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path fill="white" d="M12 8v4m0 4h.01" />
                </svg>
                <span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="confirm-password">Xác nhận mật khẩu <span class="required">*</span></label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" id="confirm-password" placeholder="Nhập lại mật khẩu">
                <button type="button" class="toggle-password" onclick="togglePassword('confirm-password')">
                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
            <div class="error-message" id="confirm-password-error" style="display: none;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path fill="white" d="M12 8v4m0 4h.01" />
                </svg>
                <span></span>
            </div>
        </div>

        <div class="terms-group">
            <div class="checkbox-wrapper">
                <input type="checkbox" id="terms">
                <label for="terms">
                    Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a>
                </label>
            </div>
            <div class="error-message" id="terms-error" style="display: none; margin-top: 6px;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path fill="white" d="M12 8v4m0 4h.01" />
                </svg>
                <span></span>
            </div>
        </div>

        <button class="submit-btn" onclick="handleSubmit()">Đăng ký</button>

        <div class="login-link">
            Đã có tài khoản? <a href="#">Đăng nhập ngay</a>
        </div>
    </div>

    <div class="success-message" id="success-message">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
        <span>Đăng ký thành công!</span>
    </div>
</body>


<?php
require_once '../layouts/footer-auth.php'
?>