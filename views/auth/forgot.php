<?php
require_once './views/layouts/header-auth.php';
?>

<body>
    <form action="?controllers=AuthController&action=forgot" method="POST">
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


            <div class="form-content">
                <!-- Step 1: Enter Email -->
                <div class="step-content active" id="content-1">

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="email">Email của bạn</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <path d="M22 6l-10 7L2 6" />
                                </svg>
                                <input type="email" id="email" name="email" placeholder="email@example.com">
                            </div>
                        </div>

                        <button class="submit-btn" type="submit">Gửi mã xác nhận</button>

                    </form>
                    <div class="login-link">
                        <a href="?views=auth&action=login">Quay lại trang đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>

<?php
require_once './views/layouts/footer-auth.php';
?>