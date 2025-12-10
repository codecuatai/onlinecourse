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
            <h1 id="page-title">Xác thực mật khẩu</h1>
            <p id="page-description">Hãy nhập mã OTP đã gửi cho bạn</p>
        </div>

        <div class="form-content">
            <!-- Step 1: Enter Email -->
            <div class="step-content active" id="content-1">
                <form action="?controllers=AuthController&action=verifyOtp" method="post">

                    <div class="form-group">
                        <label for="confirm-password">Nhập mã OTP <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>

                            <input type="text" id="otp" name="otp" placeholder="Nhập mã OTP">

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