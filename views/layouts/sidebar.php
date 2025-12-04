<?php
$role = 2;
?>

<aside class="sidebar">
    <div class="sidebar-logo">
        📚 OnlineCourse
    </div>
    <ul class="sidebar-menu">
        <!-- Menu chung -->
        <li>
            <a href="<?php echo _HOST_URL . '/views/dashboard.php'; ?>" class="active">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Học viên -->
        <?php if ($role == 0): ?>
            <li>
                <a href="courses.php">
                    <span class="icon">📚</span>
                    <span>Danh sách khóa học</span>
                </a>
            </li>
            <li>
                <a href="my_courses.php">
                    <span class="icon">🎓</span>
                    <span>Khóa học đã đăng ký</span>
                </a>
            </li>
            <li>
                <a href="progress.php">
                    <span class="icon">📈</span>
                    <span>Tiến độ học tập</span>
                </a>
            </li>
            <li>
                <a href="lessons.php">
                    <span class="icon">📝</span>
                    <span>Bài học</span>
                </a>
            </li>
            <li>
                <a href="materials.php">
                    <span class="icon">📄</span>
                    <span>Tài liệu</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Giảng viên -->
        <?php if ($role == 1): ?>
            <li>
                <a href="courses_manage.php">
                    <span class="icon">📚</span>
                    <span>Quản lý khóa học</span>
                </a>
            </li>
            <li>
                <a href="lessons_manage.php">
                    <span class="icon">📝</span>
                    <span>Quản lý bài học</span>
                </a>
            </li>
            <li>
                <a href="materials_upload.php">
                    <span class="icon">📄</span>
                    <span>Đăng tải tài liệu</span>
                </a>
            </li>
            <li>
                <a href="students_list.php">
                    <span class="icon">👥</span>
                    <span>Học viên đăng ký</span>
                </a>
            </li>
            <li>
                <a href="progress_students.php">
                    <span class="icon">📈</span>
                    <span>Tiến độ học viên</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Quản trị viên -->
        <?php if ($role == 2): ?>
            <li>
                <a href="<?php echo _HOST_URL . '/views/users/manage.php'; ?>">
                    <span class="icon">👥</span>
                    <span>Quản lý người dùng</span>
                </a>
            </li>
            <li>
                <a href="categories.php">
                    <span class="icon">📁</span>
                    <span>Quản lý danh mục</span>
                </a>
            </li>
            <li>
                <a href="reports.php">
                    <span class="icon">📊</span>
                    <span>Thống kê hệ thống</span>
                </a>
            </li>
            <li>
                <a href="course_approval.php">
                    <span class="icon">✅</span>
                    <span>Duyệt khóa học</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>