<?php
$role = 2;
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

</head>

<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1><?php echo $title; ?></h1>
            </div>
            <div class="header-right">
                <!-- Search box -->
                <div class="search-box">
                    <input type="text" placeholder="Tìm kiếm...">
                </div>

                <!-- Notification -->
                <div class="notification-icon" title="Thông báo">🔔</div>

                <!-- Profile -->
                <div class="profile-icon" title="Tài khoản">?</div>
            </div>
        </header>