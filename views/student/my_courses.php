<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng chứa thông tin các khóa học
$courses = [
    [
        "id" => 1,
        "title" => "Python cho Người Mới Bắt Đầu",
        "category" => "Lập trình",
        "rating" => 4.8,
        "students" => 234,
        "duration" => "12 giờ",
        "instructor" => "Nguyễn Văn A",
        "avatar" => "https://i.pravatar.cc/30?img=1",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "description" => "Học Python từ cơ bản đến nâng cao với các dự án thực tế"
    ],
    [
        "id" => 2,
        "title" => "UI/UX Design Masterclass",
        "category" => "Thiết kế",
        "rating" => 4.9,
        "students" => 189,
        "duration" => "18 giờ",
        "instructor" => "Trần Thị B",
        "avatar" => "https://i.pravatar.cc/30?img=2",
        "image" => "https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400",
        "description" => "Thiết kế giao diện đẹp và trải nghiệm người dùng tuyệt vời"
    ],
    [
        "id" => 3,
        "title" => "JavaScript Full Stack",
        "category" => "Lập trình",
        "rating" => 4.6,
        "students" => 412,
        "duration" => "24 giờ",
        "instructor" => "Phạm Văn D",
        "avatar" => "https://i.pravatar.cc/30?img=4",
        "image" => "https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400",
        "description" => "Xây dựng ứng dụng web với Node.js, React và MongoDB"
    ],
    [
        "id" => 4,
        "title" => "JavaScript Full Stack",
        "category" => "Lập trình",
        "rating" => 4.6,
        "students" => 412,
        "duration" => "24 giờ",
        "instructor" => "Phạm Văn D",
        "avatar" => "https://i.pravatar.cc/30?img=4",
        "image" => "https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400",
        "description" => "Xây dựng ứng dụng web với Node.js, React và MongoDB"
    ],
    [
        "id" => 5,
        "title" => "JavaScript Full Stack",
        "category" => "Lập trình",
        "rating" => 4.6,
        "students" => 412,
        "duration" => "24 giờ",
        "instructor" => "Phạm Văn D",
        "avatar" => "https://i.pravatar.cc/30?img=4",
        "image" => "https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400",
        "description" => "Xây dựng ứng dụng web với Node.js, React và MongoDB"
    ],
];
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
                            <span class="badge bg-primary"><?= $course['category'] ?></span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> <?= $course['rating'] ?>
                            </span>
                        </div>
                        <h5 class="card-title mb-2"><?= $course['title'] ?></h5>
                        <p class="card-text text-muted small mb-3"><?= $course['description'] ?></p>

                        <div class="mt-auto">
                            <div class="d-flex align-items-center mb-2 small text-muted">
                                <i class="fas fa-user me-1"></i><?= $course['students'] ?> học viên
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock me-1"></i><?= $course['duration'] ?>
                            </div>
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <img src="<?= $course['avatar'] ?>" class="rounded-circle me-2" width="24" height="24" alt="<?= $course['instructor'] ?>">
                                <span><?= $course['instructor'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="?views=student&action=course_of_lession" class="btn btn-primary btn-sm">Vào khóa học</a>
                                <a href="?views=student&action=course_of_material" class="btn btn-secondary btn-sm">Tải tài liệu</a>
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
