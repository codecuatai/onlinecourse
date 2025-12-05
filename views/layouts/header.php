<?php
$role = 0;
// Tiêu đề header theo role
switch ($role) {
    case 0:
        $title = "Dashboard Học Viên";
        break;
    case 1:
        $title = "Dashboard Giảng Viên";
        break;
    case 2:
        $title = "Dashboard Quản Trị";
        break;
    default:
        $title = "Dashboard";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Online Course</title>
    <link rel="stylesheet" href="<?php echo _HOST_URL . '/assets/css/main.css'; ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .header {
            position: relative;
        }

        .profile-dropdown a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header class="header d-flex justify-content-between align-items-center p-3 bg-light shadow-sm">
            <div class="header-left">
                <h1><?php echo $title; ?></h1>
            </div>

            <div class="header-right position-relative">

                <!-- Notification -->
                <div class="notification-icon me-3" title="Thông báo" style="cursor:pointer;">🔔</div>

                <!-- Profile -->
                <div class="profile-icon" title="Tài khoản" style="cursor:pointer;">
                    👤
                </div>

                <!-- Dropdown menu -->
                <div class="profile-dropdown position-absolute bg-white shadow rounded" style="top:100%; right:0; display:none; min-width:150px; z-index:100;">
                    <a href="<?php echo _HOST_URL . '/views/users/profile.php' ?>" class="dropdown-item d-block px-3 py-2 text-decoration-none text-dark">Profile</a>
                    <a href="<?php echo _HOST_URL . '/views/users/changepassword.php' ?>" class="dropdown-item d-block px-3 py-2 text-decoration-none text-dark">Đổi mật khẩu</a>
                    <a href="logout.php" class="dropdown-item d-block px-3 py-2 text-decoration-none text-dark">Đăng xuất</a>
                </div>

            </div>
        </header>
        <script>
            // Toggle dropdown khi click vào profile-icon
            document.addEventListener('DOMContentLoaded', function() {
                const profileIcon = document.querySelector('.profile-icon');
                const dropdown = document.querySelector('.profile-dropdown');

                profileIcon.addEventListener('click', function(e) {
                    e.stopPropagation(); // Ngăn không cho click đóng dropdown ngay lập tức
                    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
                });

                // Đóng dropdown khi click ra ngoài
                document.addEventListener('click', function() {
                    dropdown.style.display = 'none';
                });
            });
        </script>