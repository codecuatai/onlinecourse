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


// Mảng chứa danh sách khóa học
$courses = [
    [
        "title" => "Python cho Người Mới Bắt Đầu",
        "category" => "Lập trình",
        "rating" => 4.8,
        "students" => 234,
        "duration" => "12 giờ",
        "description" => "Học Python từ cơ bản đến nâng cao với dự án thực tế",
        "instructor_name" => "Nguyễn Văn A",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=1",
        "price" => "499.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ],
    [
        "title" => "ReactJS Mastery",
        "category" => "Lập trình",
        "rating" => 4.8,
        "students" => 198,
        "duration" => "10 giờ",
        "description" => "Hiểu sâu và xây dựng dự án thực tế với ReactJS",
        "instructor_name" => "Trần Thị B",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=2",
        "price" => "599.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ],
    [
        "title" => "Web Fullstack",
        "category" => "Lập trình",
        "rating" => 4.7,
        "students" => 320,
        "duration" => "15 giờ",
        "description" => "Xây dựng website từ Frontend đến Backend.",
        "instructor_name" => "Nguyễn Văn C",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=3",
        "price" => "699.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ],
    [
        "title" => "Web Fullstack",
        "category" => "Lập trình",
        "rating" => 4.7,
        "students" => 320,
        "duration" => "15 giờ",
        "description" => "Xây dựng website từ Frontend đến Backend.",
        "instructor_name" => "Nguyễn Văn C",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=3",
        "price" => "699.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ],
    [
        "title" => "Web Fullstack",
        "category" => "Lập trình",
        "rating" => 4.7,
        "students" => 320,
        "duration" => "15 giờ",
        "description" => "Xây dựng website từ Frontend đến Backend.",
        "instructor_name" => "Nguyễn Văn C",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=3",
        "price" => "699.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ],
    [
        "title" => "Web Fullstack",
        "category" => "Lập trình",
        "rating" => 4.7,
        "students" => 320,
        "duration" => "15 giờ",
        "description" => "Xây dựng website từ Frontend đến Backend.",
        "instructor_name" => "Nguyễn Văn C",
        "instructor_avatar" => "https://i.pravatar.cc/30?img=3",
        "price" => "699.000₫",
        "image" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400",
        "link" => "./detail.php"
    ]
    // Bạn có thể thêm nhiều khóa học khác vào đây
];
?>


<div class="container my-4">

    <!-- Search + Filter -->
<form class="row g-2 mb-4" method="GET" action="index.php" id="searchForm">

    <input type="hidden" name="controller" value="course">
    <input type="hidden" name="action" value="search">

    <!-- Ô tìm kiếm -->
    <div class="col-12 col-md-6">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
            </span>
            <input 
                type="text" 
                name="keyword" 
                id="keyword"
                class="form-control border-start-0"
                placeholder="Tìm kiếm khóa học..."
                autocomplete="off"
            >
        </div>
    </div>

    <!-- Lọc danh mục -->
    <div class="col-6 col-md-3">
        <select class="form-select shadow-sm" name="category" id="category">
            <option value="">Tất cả lĩnh vực</option>
            <option value="1">Lập trình</option>
            <option value="2">Thiết kế</option>
            <option value="3">Kinh doanh</option>
            <option value="4">Video</option>
        </select>
    </div>

    <!-- Sắp xếp -->
    <div class="col-6 col-md-3">
        <select class="form-select shadow-sm" name="sort" id="sort">
            <option value="">Sắp xếp</option>
            <option value="popular">Phổ biến nhất</option>
            <option value="new">Mới nhất</option>
            <option value="price_asc">Giá thấp → cao</option>
            <option value="price_desc">Giá cao → thấp</option>
        </select>
    </div>

</form>


    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($courses as $course): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="<?= $course['image'] ?>" class="card-img-top" alt="Course">

                    <div class="card-body d-flex flex-column">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-primary"><?= $course['category'] ?></span>
                            <span class="badge bg-warning text-dark">
                                <i class="fa fa-star"></i> <?= $course['rating'] ?>
                            </span>
                        </div>

                        <h6 class="card-title fw-semibold mb-2"><?= $course['title'] ?></h6>

                        <p class="card-text text-muted small mb-3"><?= $course['description'] ?></p>

                        <div class="mt-auto">
                            <div class="d-flex align-items-center mb-2 small text-muted">
                                <i class="fa fa-user me-1"></i><?= $course['students'] ?> học viên
                                <span class="mx-2">•</span>
                                <i class="fa fa-clock me-1"></i><?= $course['duration'] ?>
                            </div>

                            <div class="d-flex align-items-center text-muted small mb-3">
                                <img src="<?= $course['instructor_avatar'] ?>" class="rounded-circle me-2" width="24" height="24">
                                <span><?= $course['instructor_name'] ?></span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary"><?= $course['price'] ?></span>
                                <a class="btn btn-primary btn-sm" href="?views=courses&action=detail">Xem chi tiết</a>
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
?>