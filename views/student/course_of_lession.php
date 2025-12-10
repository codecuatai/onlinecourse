<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng khóa học và tiến trình
$course = [
    "id" => 1,
    "title" => "Python cho Người Mới Bắt Đầu",
    "category" => "Lập trình",
    "instructor" => "Nguyễn Văn A",
    "created_at" => "2024-06-01",
    "description" => "Học Python từ cơ bản đến nâng cao với các dự án thực tế",
    "lessons" => [
        ["id" => 1, "title" => "Giới thiệu Python", "duration" => "15 phút", "status" => "Hoàn thành"],
        ["id" => 2, "title" => "Cấu trúc dữ liệu cơ bản", "duration" => "30 phút", "status" => "Đang học"],
        ["id" => 3, "title" => "Hàm và Module", "duration" => "25 phút", "status" => "Chưa bắt đầu"],
        ["id" => 4, "title" => "Làm việc với file", "duration" => "20 phút", "status" => "Chưa bắt đầu"],
        ["id" => 5, "title" => "Dự án thực tế", "duration" => "60 phút", "status" => "Chưa bắt đầu"]
    ]
];

// Tính % hoàn thành
$totalLessons = count($course['lessons']);
$completedLessons = count(array_filter($course['lessons'], fn($l) => $l['status'] == 'Hoàn thành'));
$progressPercent = round(($completedLessons / $totalLessons) * 100);
?>

<main class="main-content p-4">

    <!-- Nút quay lại -->
    <div class="mb-3 text-end">
        <a href="?views=student&action=my_courses" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Thông tin khóa học -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= $course['title'] ?></h4>
            <span class="badge bg-warning text-dark"><?= $course['category'] ?></span>
        </div>
        <div class="card-body">
            <p><strong>Giảng viên:</strong> <?= $course['instructor'] ?></p>
            <p><strong>Ngày tạo:</strong> <?= $course['created_at'] ?></p>
            <p><?= $course['description'] ?></p>

            <!-- Progress Bar -->
            <div class="mt-3">
                <h6>Tiến độ khóa học: <?= $progressPercent ?>%</h6>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progressPercent ?>%;" aria-valuenow="<?= $progressPercent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách lesson -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Danh sách lesson</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề lesson</th>
                            <th>Thời lượng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($course['lessons'] as $index => $lesson): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $lesson['title'] ?></td>
                                <td><?= $lesson['duration'] ?></td>
                                <td>
                                    <?php if ($lesson['status'] == 'Hoàn thành'): ?>
                                        <span class="badge bg-success"><?= $lesson['status'] ?></span>
                                    <?php elseif ($lesson['status'] == 'Đang học'): ?>
                                        <span class="badge bg-warning text-dark"><?= $lesson['status'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= $lesson['status'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Xem video</button>
                                    <button class="btn btn-sm btn-success">Hoàn thành</button>
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