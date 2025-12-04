<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>


<div class="container-fluid mt-4">
    <h4 class="mb-4">Khóa học đã đăng ký</h4>

    <!-- Courses Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
        <!-- Course 1 -->
        <div class="col">
            <div class="card course-card h-100">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400" class="course-img" alt="Course">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary badge-custom">Lập trình</span>
                        <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-star"></i> 4.8
                        </span>
                    </div>
                    <h5 class="card-title mb-2">Python cho Người Mới Bắt Đầu</h5>
                    <p class="card-text text-muted small mb-3">Học Python từ cơ bản đến nâng cao với các dự án thực tế</p>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fas fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock me-1"></i>12 giờ
                        </div>
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm">Vào khóa học</button>
                            <button class="btn btn-info btn-sm">Xem tiến độ</button>
                            <button class="btn btn-secondary btn-sm">Tải tài liệu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course 2 -->
        <div class="col">
            <div class="card course-card h-100">
                <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400" class="course-img" alt="Course">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-warning badge-custom">Thiết kế</span>
                        <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-star"></i> 4.9
                        </span>
                    </div>
                    <h5 class="card-title mb-2">UI/UX Design Masterclass</h5>
                    <p class="card-text text-muted small mb-3">Thiết kế giao diện đẹp và trải nghiệm người dùng tuyệt vời</p>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fas fa-user me-1"></i>189 học viên
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock me-1"></i>18 giờ
                        </div>
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=2" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                            <span>Trần Thị B</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm">Vào khóa học</button>
                            <button class="btn btn-info btn-sm">Xem tiến độ</button>
                            <button class="btn btn-secondary btn-sm">Tải tài liệu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course 3 -->
        <div class="col">
            <div class="card course-card h-100">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400" class="course-img" alt="Course">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary badge-custom">Lập trình</span>
                        <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-star"></i> 4.6
                        </span>
                    </div>
                    <h5 class="card-title mb-2">JavaScript Full Stack</h5>
                    <p class="card-text text-muted small mb-3">Xây dựng ứng dụng web với Node.js, React và MongoDB</p>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fas fa-user me-1"></i>412 học viên
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock me-1"></i>24 giờ
                        </div>
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=4" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                            <span>Phạm Văn D</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm">Vào khóa học</button>
                            <button class="btn btn-info btn-sm">Xem tiến độ</button>
                            <button class="btn btn-secondary btn-sm">Tải tài liệu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Khi không có khóa học -->
        <!--
        <div class="col">
            <p class="text-center text-muted">Bạn chưa đăng ký khóa học nào.</p>
        </div>
        -->
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
