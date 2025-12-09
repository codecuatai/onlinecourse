<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Nếu bạn dùng session
$course_detail = $_SESSION['course_detail'];
?>

<main class="container py-5">

    <div class="row g-5">

        <!-- LEFT CONTENT -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="fw-bold display-6 mb-2">
                <?= htmlspecialchars($course_detail['title']) ?>
            </h1>

            <div class="d-flex align-items-center text-muted mb-4 small">
                <span class="me-3"><i class="bi bi-star-fill text-warning"></i> 4.9 (532 đánh giá)</span>
                <span class="me-3"><i class="bi bi-people"></i> 1.243 học viên</span>
                <span><i class="bi bi-play-circle"></i> <?= htmlspecialchars($course_detail['duration_weeks']) ?> bài học</span>
            </div>

            <!-- Featured Image -->
            <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden mb-4">
                <img src="<?= htmlspecialchars($course_detail['image']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($course_detail['title']) ?>">
            </div>

            <!-- Description -->
            <h4 class="fw-bold mb-3">Mô tả khóa học</h4>
            <p class="text-secondary fs-5">
                <?= nl2br(htmlspecialchars($course_detail['description'])) ?>
            </p>

            <!-- What you will learn -->
            <h4 class="fw-bold mt-5 mb-3">Bạn sẽ học được</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Hiểu rõ cú pháp, hàm, class trong Python
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Làm việc với file, dữ liệu, API
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Xây dựng web với Flask/Django
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Thực chiến qua dự án thực tế
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="col-lg-4">
            <div class="d-flex justify-content-end mb-4">
                <a href="javascript:history.back()" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>

            <div class="border-0 shadow rounded-4 overflow-hidden position-sticky" style="top: 100px;">

                <!-- Thumbnail -->
                <img src="<?= htmlspecialchars($course_detail['image']) ?>" class="w-100 object-fit-cover" style="height: 200px;" alt="<?= htmlspecialchars($course_detail['title']) ?>">

                <div class="p-4">

                    <!-- Price -->
                    <p class="fw-bold display-6 mb-0"><?= number_format($course_detail['price'], 0, ',', '.') ?>₫</p>
                    <p class="text-muted small mb-4">Truy cập trọn đời</p>

                    <!-- CTA -->
                    
                    <form method="POST" action="index.php?controller=EnrollmentController&action=enroll">
                    <input type="hidden" name="course_id" value="<?= $course_detail['id'] ?>">


                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold mb-3 rounded-4">
                            Đăng ký khóa học
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Instructor -->
                    <div class="d-flex align-items-center">
                        <img src="https://i.pravatar.cc/60?u=<?= $course_detail['instructor_id'] ?>" class="rounded-circle me-3" width="60" height="60">
                        <div>
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($course_detail['instructor_name']) ?></h6>
                            <small class="text-muted">Giảng viên chuyên nghiệp</small>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>