<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';


$enrollment = $_SESSION['enrollment'];
$lessons = $_SESSION['lessons'];
$course = $_SESSION['course'];
$instructor = $_SESSION['instructor'];

// Tính % hoàn thành
$totalLessons = count($lessons);
$progressPercent = $enrollment['progress'];

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
        </div>
        <div class="card-body">
            <p><strong>Giảng viên:</strong> <?= $instructor['fullname'] ?></p>
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
                            <th>Xem Video</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lessons as $index => $lesson): ?>

                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $lesson['title'] ?></td>
                                <td class="text-center">
                                    <a href="<?= $lesson['video_url'] ?>>" class="btn btn-sm btn-primary">Xem video</a>
                                </td>
                                <td class="text-center">
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