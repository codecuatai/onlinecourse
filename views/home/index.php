<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

$courses = $_SESSION['courses'];
// Mảng chứa thông tin 3 khóa học
?>

<div class="container py-5">

    <!-- Introduction -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Hệ thống đào tạo trực tuyến</h2>
        <p class="text-muted mb-0">
            Nơi cung cấp các khóa học chất lượng, giúp bạn phát triển kỹ năng và sự nghiệp.
        </p>
    </div>


    <!-- Stats -->
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 h-100">
                <h1 class="fw-bold text-primary">24+</h1>
                <p class="text-muted mb-0">Khóa học chất lượng</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 h-100">
                <h1 class="fw-bold text-primary">350+</h1>
                <p class="text-muted mb-0">Học viên tích cực</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 h-100">
                <h1 class="fw-bold text-primary">12+</h1>
                <p class="text-muted mb-0">Giảng viên giàu kinh nghiệm</p>
            </div>
        </div>

    </div>


    <!-- Highlight Courses -->
    <h4 class="fw-bold mb-4">Khóa học nổi bật</h4>

    <div class="row g-4">

        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="<?= $course['image'] ?>" class="card-img-top" alt="Course">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= $course['title'] ?></h5>
                            <p class="text-muted small mb-4"><?= $course['description'] ?></p>
                            <a href="<?php echo "?controllers=CourseController&action=viewDetail&id=" . $course['id']; ?>" class="btn btn-primary w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/header.php';
?>