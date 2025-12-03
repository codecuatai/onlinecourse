<?php
require_once '../layouts/header-auth.php'
?>

<body>
    <div class="forgot-password-container">
        <!-- Decorative elements -->
        <div class="circle-decoration circle-1"></div>
        <div class="circle-decoration circle-2"></div>

        <div class="header">
            <div class="icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    <circle cx="12" cy="16" r="1" />
                </svg>
            </div>
            <h1 id="page-title">Quên mật khẩu?</h1>
            <p id="page-description">Đừng lo lắng, chúng tôi sẽ giúp bạn lấy lại mật khẩu</p>
        </div>

        <!-- Steps indicator -->
        <div class="steps">
            <div class="step active" id="step-1"></div>
            <div class="step" id="step-2"></div>
            <div class="step" id="step-3"></div>
        </div>

        <div class="form-content">
            <!-- Step 1: Enter Email -->
            <div class="step-content active" id="content-1">
                <div class="form-group">
                    <label for="email">Email của bạn</label>
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

                <button class="submit-btn" onclick="sendCode()">Gửi mã xác nhận</button>
                <button class="back-btn" onclick="goBack()">Quay lại đăng nhập</button>
            </div>

            <!-- Step 2: Enter OTP Code -->
            <div class="step-content" id="content-2">
                <div class="form-group">
                    <label style="text-align: center; display: block;">Nhập mã xác nhận</label>
                    <p style="text-align: center; color: #6b7280; font-size: 14px; margin-bottom: 24px;">
                        Mã đã được gửi đến <strong id="email-display"></strong>
                    </p>
                    <div class="code-inputs">
                        <input type="text" class="code-input" maxlength="1" id="code-1">
                        <input type="text" class="code-input" maxlength="1" id="code-2">
                        <input type="text" class="code-input" maxlength="1" id="code-3">
                        <input type="text" class="code-input" maxlength="1" id="code-4">
                        <input type="text" class="code-input" maxlength="1" id="code-5">
                        <input type="text" class="code-input" maxlength="1" id="code-6">
                    </div>
                    <div class="error-message" id="code-error" style="display: none; justify-content: center;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <path fill="white" d="M12 8v4m0 4h.01" />
                        </svg>
                        <span></span>
                    </div>
                </div>

                <div class="resend-code">
                    Không nhận được mã?
                    <button onclick="resendCode()" id="resend-btn">Gửi lại</button>
                    <span id="timer" style="display: none;">(30s)</span>
                </div>

                <button class="submit-btn" onclick="verifyCode()">Xác nhận</button>
                <button class="back-btn" onclick="goToStep(1)">Quay lại</button>
            </div>

            <!-- Step 3: Reset Password -->
            <div class="step-content" id="content-3">
                <div class="form-group">
                    <label for="new-password">Mật khẩu mới</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input type="password" id="new-password" placeholder="Ít nhất 6 ký tự">
                        <button type="button" class="toggle-password" onclick="togglePassword('new-password')">
                            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    <div class="error-message" id="new-password-error" style="display: none;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <path fill="white" d="M12 8v4m0 4h.01" />
                        </svg>
                        <span></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Xác nhận mật khẩu</label>
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

                <button class="submit-btn" onclick="resetPassword()">Đặt lại mật khẩu</button>
            </div>

            <!-- Success Message -->
            <div class="step-content" id="content-success">
                <div class="success-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="#10b981" stroke-width="2" />
                        <path class="checkmark" d="M8 12l3 3 5-6" stroke="#10b981" stroke-width="2" fill="none" />
                    </svg>
                </div>

                <div class="success-message-box">
                    <h3>Đặt lại mật khẩu thành công!</h3>
                    <p>Mật khẩu của bạn đã được thay đổi. Bạn có thể đăng nhập với mật khẩu mới.</p>
                </div>

                <button class="submit-btn" onclick="goToLogin()">Đăng nhập ngay</button>
            </div>
        </div>
    </div>

</body>