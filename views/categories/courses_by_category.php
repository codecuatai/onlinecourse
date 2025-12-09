<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

$courses = $_SESSION['category_courses'];
$category = $_SESSION['category_info'];
?>

<main class="main-content p-4">

    <div class="mb-4">
        <h3 class="fw-bold">Khóa học trong danh mục: <?= $category['name'] ?></h3>
        <p class="text-muted"><?= $category['description'] ?></p>
        <a href="?controllers=CategoryController&action=viewCategories" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách danh mục
        </a>
    </div>

    <?php if (empty($courses)): ?>
        <div class="alert alert-warning">Hiện chưa có khóa học nào trong danh mục này.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="<?= $course['image'] ?>" class="card-img-top" alt="Course">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= $course['title'] ?></h5>
                            <p class="text-muted small mb-2"><?= $course['description'] ?></p>
                            <p class="text-secondary mb-2">Giảng viên: <?= $course['instructor_name'] ?></p>
                            <a href="?controllers=CourseController&action=viewDetail&id=<?= $course['id'] ?>" class="btn btn-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>