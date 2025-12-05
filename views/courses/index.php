<?php
// Load Database và Course Model
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Course.php';

try {
    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();

    // Tạo object Course
    $courseModel = new Course($db);

    // Lấy khóa học
    $result = $courseModel->getCoursesByInstructor(2);
    $courses = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</div>";
    $courses = [];
}
?>

<div class="container my-4">

    <!-- Search + Filter -->
    <form class="row g-2 mb-4">

        <div class="col-12 col-md-6">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Tìm kiếm khóa học...">
            </div>
        </div>

        <div class="col-6 col-md-3">
            <select class="form-select shadow-sm">
                <option value="">Tất cả lĩnh vực</option>
                <option>Lập trình</option>
                <option>Thiết kế</option>
                <option>Kinh doanh</option>
                <option>Video</option>
            </select>
        </div>

        <div class="col-6 col-md-3">
            <select class="form-select shadow-sm">
                <option value="">Sắp xếp</option>
                <option>Phổ biến nhất</option>
                <option>Mới nhất</option>
                <option>Giá thấp → cao</option>
                <option>Giá cao → thấp</option>
            </select>
        </div>

    </form>


    <!-- Courses Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">

        <!-- Course Card -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Course2  -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Course Card -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Course Card -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Course Card -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Course Card -->
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400"
                    class="card-img-top" alt="Course">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary">Lập trình</span>
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-star"></i> 4.8
                        </span>
                    </div>

                    <h6 class="card-title fw-semibold mb-2">Python cho Người Mới Bắt Đầu</h6>

                    <p class="card-text text-muted small mb-3">
                        Học Python từ cơ bản đến nâng cao với dự án thực tế
                    </p>

                    <!-- Info -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fa fa-user me-1"></i>234 học viên
                            <span class="mx-2">•</span>
                            <i class="fa fa-clock me-1"></i>12 giờ
                        </div>

                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=1" class="rounded-circle me-2" width="24" height="24">
                            <span>Nguyễn Văn A</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">499.000₫</span>
                            <a class="btn btn-primary btn-sm" href="./detail.php">Xem chi tiết</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once _PATH_URL . '/../views/layouts/header.php';
?>