<?php
$role = $_SESSION['role'] ?? -1; // 0 = học viên, 1 = giảng viên, 2 = admin
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="?views=home&action=index" class="d-flex align-items-center" style="color:aliceblue; text-decoration: none;">📚 OnlineCourse</a>
    </div>
    <ul class="sidebar-menu list-unstyled">

        <li>
            <a href="?controllers=CourseController&action=viewAllCourses" class="d-flex align-items-center">
                <span class="icon me-2">📊</span>
                <span>Khóa học</span>
            </a>
        </li>

        <!-- Học viên -->
        <?php if ($role == 0): ?>
            <li><a href="?views=student&action=my_courses" class="d-flex align-items-center"><span class="icon me-2">🎓</span> Khóa học đã đăng ký</a></li>
            <li><a href="?views=student&action=course_progress" class="d-flex align-items-center"><span class="icon me-2">✅</span> Tiến triển của khóa học</a></li>
        <?php endif; ?>

        <!-- Giảng viên -->
        <?php if ($role == 1): ?>
            <li><a href="?views=instructor&instructor=course&action=manage" class="d-flex align-items-center"><span class="icon me-2">📝</span> Khóa học của bạn</a></li>

        <?php endif; ?>

        <!-- Quản trị viên -->
        <?php if ($role == 2): ?>
            <li><a href="?views=users&action=manage" class="d-flex align-items-center"><span class="icon me-2">👥</span> Quản lý người dùng</a></li>
            <li><a href="?views=categories&action=list" class="d-flex align-items-center"><span class="icon me-2">📁</span> Quản lý danh mục</a></li>
            <li><a href="?views=reports&action=index" class="d-flex align-items-center"><span class="icon me-2">📊</span> Thống kê hệ thống</a></li>
            <li><a href="?views=admin&action=browseCourses" class="d-flex align-items-center"><span class="icon me-2">✅</span> Duyệt khóa học</a></li>
        <?php endif; ?>
        <?php if ($role === -1): // Mặc định: Chưa đăng nhập 
        ?>
            <li>
                <a href="?views=auth&action=login" class="d-flex align-items-center">
                    <span class="icon me-2">➡️</span>
                    <span>Đăng Nhập</span>
                </a>
            </li>
            <li>
                <a href="?views=auth&action=register" class="d-flex align-items-center">
                    <span class="icon me-2">✍️</span>
                    <span>Đăng Ký</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>

<!-- Bootstrap JS (để collapse hoạt động) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>