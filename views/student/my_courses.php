<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng chứa thông tin các khóa học
// $courses = [
//     [
//         "id" => 1,
//         "title" => "Python cho Người Mới Bắt Đầu",
//         "category" => "Lập trình",
//         "students" => 234,
//         "duration" => "12 giờ",
//         "instructor" => "Nguyễn Văn A",
//         "avatar" => "https://i.pravatar.cc/30?img=1",
//         "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
//         "description" => "Học Python từ cơ bản đến nâng cao với các dự án thực tế"
//     ]
// ];
$courses = $_SESSION['enroll_courses'];

?>



<div class="container-fluid mt-4">
    <h4 class="mb-4">Khóa học đã đăng ký</h4>

    <div class="row g-4">
        <?php foreach ($courses as $course): ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= $course['image'] ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-primary"> <?= $course['category_name'] ?> </span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> 5
                            </span>
                        </div>
                        <h5 class="card-title mb-2"><?= $course['title'] ?></h5>
                        <p class="card-text text-muted small mb-3"><?= $course['description'] ?></p>

                        <div class="mt-auto">
                            <div class="d-flex align-items-center mb-2 small text-muted">
                                <i class="fas fa-user me-1"></i>100 học viên
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock me-1"></i>Time: <?= $course['duration_weeks'] ?> Tuần
                            </div>
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <span><?= $course['instructor_name'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="<?php echo '?controllers=LessonController&action=viewLessonOfStudent&course_id=' . $course['id']; ?>" class="btn btn-primary btn-sm">Vào khóa học</a>
                                <a href="<?php echo '?controllers=MaterialController&action=viewMaterialOfStudent&course_id=' . $course['id']; ?>" class="btn btn-secondary btn-sm">Tải tài liệu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
