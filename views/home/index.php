<?php
// Load Database và Course Model
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Course.php';

try {
    // Kết nối database
    $database = new Database();
    $db = $database->getConnection();

    // Tạo object Course
    $courseModel = new Course($db);

    // Lấy khóa học
    $result = $courseModel->getCoursesByInstructor(1);
    $courses = $result->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</div>";
    $courses = [];
}
?>


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
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">499.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">699.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">699.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course 4 -->
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
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">899.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course 5 -->
    <div class="col">
        <div class="card course-card h-100">
            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400" class="course-img" alt="Course">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-success badge-custom">Kinh doanh</span>
                    <span class="badge bg-warning text-dark badge-custom">
                        <i class="fas fa-star"></i> 4.9
                    </span>
                </div>
                <h5 class="card-title mb-2">Quản Trị Dự Án PMP</h5>
                <p class="card-text text-muted small mb-3">Kỹ năng quản lý dự án theo chuẩn quốc tế PMP</p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center mb-2 small text-muted">
                        <i class="fas fa-user me-1"></i>156 học viên
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock me-1"></i>16 giờ
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <img src="https://i.pravatar.cc/30?img=5" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                        <span>Hoàng Thị E</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">1.200.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course 6 -->
    <div class="col">
        <div class="card course-card h-100">
            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=400" class="course-img" alt="Course">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-danger badge-custom">Video</span>
                    <span class="badge bg-warning text-dark badge-custom">
                        <i class="fas fa-star"></i> 4.8
                    </span>
                </div>
                <h5 class="card-title mb-2">Dựng Video Premiere Pro</h5>
                <p class="card-text text-muted small mb-3">Làm chủ Adobe Premiere Pro để tạo video chuyên nghiệp</p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center mb-2 small text-muted">
                        <i class="fas fa-user me-1"></i>278 học viên
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock me-1"></i>14 giờ
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <img src="https://i.pravatar.cc/30?img=6" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                        <span>Đỗ Văn F</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">599.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course 7 -->
    <div class="col">
        <div class="card course-card h-100">
            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400" class="course-img" alt="Course">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-primary badge-custom">Lập trình</span>
                    <span class="badge bg-warning text-dark badge-custom">
                        <i class="fas fa-star"></i> 4.7
                    </span>
                </div>
                <h5 class="card-title mb-2">React Native Mobile App</h5>
                <p class="card-text text-muted small mb-3">Xây dựng ứng dụng di động đa nền tảng với React Native</p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center mb-2 small text-muted">
                        <i class="fas fa-user me-1"></i>324 học viên
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock me-1"></i>20 giờ
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <img src="https://i.pravatar.cc/30?img=7" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                        <span>Vũ Thị G</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">799.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course 8 -->
    <!-- <div class="col">
        <div class="card course-card h-100">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400" class="course-img" alt="Course">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-success badge-custom">Kinh doanh</span>
                    <span class="badge bg-warning text-dark badge-custom">
                        <i class="fas fa-star"></i> 4.8
                    </span>
                </div>
                <h5 class="card-title mb-2">Excel cho Dân Văn Phòng</h5>
                <p class="card-text text-muted small mb-3">Làm chủ Excel từ cơ bản đến nâng cao cho công việc</p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center mb-2 small text-muted">
                        <i class="fas fa-user me-1"></i>892 học viên
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock me-1"></i>10 giờ
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <img src="https://i.pravatar.cc/30?img=8" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                        <span>Bùi Văn H</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">399.000₫</span>
                        <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

 <!-- DATABASE COURSES (Dữ liệu từ database) -->
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $c): 
            $img = !empty($c['image']) ? htmlspecialchars($c['image']) : 'https://via.placeholder.com/400x240?text=No+Image';
            $title = htmlspecialchars($c['title'] ?? 'Không có tên');
            $desc = htmlspecialchars($c['description'] ?? 'Mô tả khóa học');
            $price = number_format((float)($c['price'] ?? 0), 0, ',', '.');
            $level = htmlspecialchars($c['level'] ?? 'Beginner');
            $duration = (int)($c['duration_weeks'] ?? 0);
            $id = (int)($c['id'] ?? 0);
            $instructor_id = (int)($c['instructor_id'] ?? 1);
            $rating = 4.8;
            $students = 234;
            $instructor_name = 'Giảng viên';
        ?>
        <!-- Course from Database -->
        <div class="col">
            <div class="card course-card h-100">
                <img src="<?php echo $img; ?>" class="card-img-top" alt="<?php echo $title; ?>" style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary"><?php echo $level; ?></span>
                        <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> <?php echo $rating; ?></span>
                    </div>
                    <h5 class="card-title mb-2"><?php echo $title; ?></h5>
                    <p class="card-text text-muted small mb-3"><?php echo $desc; ?></p>
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-muted">
                            <i class="fas fa-user me-1"></i><?php echo $students; ?> học viên
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock me-1"></i><?php echo $duration; ?> tuần
                        </div>
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <img src="https://i.pravatar.cc/30?img=<?php echo $instructor_id; ?>" class="rounded-circle me-2" width="24" height="24" alt="Instructor">
                            <span><?php echo $instructor_name; ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-danger" style="font-size: 18px;"><?php echo $price; ?>₫</span>
                            <button class="btn btn-primary btn-sm">Xem chi tiết</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
