<?php
require_once './views/layouts/header-auth.php';
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
            <h1 id="page-title">Tạo mới mật khẩu</h1>
            <p id="page-description">Hãy nhập mật khẩu mới của bạn</p>
        </div>

        <div class="form-content">
            <!-- Step 1: Enter Email -->
            <div class="step-content active" id="content-1">
                <form action="" method="post">

                    <div class="form-group">
                        <label for="password">Mật khẩu Cũ <span class="required">*</span></label>
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

                    <button class="submit-btn" type="submit">Xác nhận</button>
                </form>
            </div>
        </div>

</body>



<?php
require_once './views/layouts/footer-auth.php';
?>