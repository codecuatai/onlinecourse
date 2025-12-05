<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng dữ liệu khóa học
$course = [
    "id" => 1,
    "title" => "Python cho Người Mới Bắt Đầu",
    "category" => "Lập trình",
    "instructor" => "Nguyễn Văn A",
    "created_at" => "2024-06-01",
    "description" => "Học Python từ cơ bản đến nâng cao với các dự án thực tế"
];

// Mảng dữ liệu tài liệu của khóa học
$course_documents = [
    ["id" => 1, "title" => "Hướng dẫn cài đặt Python", "file_type" => "PDF", "size" => "2MB", "uploaded_at" => "2024-06-01"],
    ["id" => 2, "title" => "Bài tập cơ bản Python", "file_type" => "DOCX", "size" => "1.5MB", "uploaded_at" => "2024-06-02"],
    ["id" => 3, "title" => "Project mẫu", "file_type" => "ZIP", "size" => "5MB", "uploaded_at" => "2024-06-05"],
];
?>

<main class="main-content p-4">

    <!-- Nút Quay lại -->
    <div class="mb-3 text-end">
        <a href="my_courses.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= $course['title'] ?></h4>
            <span class="badge bg-warning text-dark"><?= $course['category'] ?></span>
        </div>
        <div class="card-body">
            <p><strong>Giảng viên:</strong> <?= $course['instructor'] ?></p>
            <p><strong>Ngày tạo:</strong> <?= $course['created_at'] ?></p>
            <p><?= $course['description'] ?></p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tài liệu khóa học</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề tài liệu</th>
                            <th>Loại file</th>
                            <th>Kích thước</th>
                            <th>Ngày tải lên</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($course_documents as $index => $doc): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $doc['title'] ?></td>
                                <td><?= $doc['file_type'] ?></td>
                                <td><?= $doc['size'] ?></td>
                                <td><?= $doc['uploaded_at'] ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>