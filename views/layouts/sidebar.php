<?php
$role = 0; // 0 = học viên, 1 = giảng viên, 2 = admin
?>

<aside class="sidebar">
    <div class="sidebar-logo">
        📚 OnlineCourse
    </div>
    <ul class="sidebar-menu list-unstyled">

        <!-- Dashboard chung -->
        <li>
            <a href="<?php echo _HOST_URL . '/views/dashboard.php'; ?>" class="d-flex align-items-center">
                <span class="icon me-2">📊</span>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Học viên -->
        <?php if ($role == 0): ?>
            <li><a href="<?php echo _HOST_URL . '/views/student/my_courses.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">🎓</span> Khóa học đã đăng ký</a></li>
        <?php endif; ?>

        <!-- Giảng viên -->
        <?php if ($role == 1): ?>
            <li><a href="<?php echo _HOST_URL . '/views/instructor/course/manage.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">📝</span> Các khóa học của bạn</a></li>

        <?php endif; ?>

        <!-- Quản trị viên -->
        <?php if ($role == 2): ?>
            <li><a href="<?php echo _HOST_URL . '/views/users/manage.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">👥</span> Quản lý người dùng</a></li>
            <li><a href="<?php echo _HOST_URL . '/views/categories/list.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">📁</span> Quản lý danh mục</a></li>
            <li><a href="<?php echo _HOST_URL . '/views/reports/index.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">📊</span> Thống kê hệ thống</a></li>
            <li><a href="<?php echo _HOST_URL . '/views/admin/browseCourses.php'; ?>" class="d-flex align-items-center"><span class="icon me-2">✅</span> Duyệt khóa học</a></li>
        <?php endif; ?>
    </ul>
</aside>

<!-- Bootstrap JS (để collapse hoạt động) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>