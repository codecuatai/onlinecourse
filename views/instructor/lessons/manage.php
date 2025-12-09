<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Dữ liệu từ session
$lessons = $_SESSION['lessons'] ?? [];
$course = $_SESSION['course'] ?? null;
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            Quản lý bài học -
            <?= isset($course['title']) ? htmlspecialchars($course['title']) : 'Không xác định' ?>
        </h4>

        <a href="?views=instructor&instructor=course&action=manage" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút tạo bài học mới -->
    <div class="mb-3">
        <a class="btn btn-success"
            href="?views=instructor&instructor=lessons&action=create&course&id=<?= $course['id'] ?>">
            <i class="fas fa-plus"></i> Tạo bài học mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">

                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Tên bài học</th>
                            <th>Video</th>
                            <th>Tài liệu</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($lessons)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Chưa có bài học nào.
                                </td>
                            </tr>

                        <?php else: ?>
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <tr class="text-center">

                                    <th><?= $index + 1 ?></th>

                                    <td class="text-start"><?= htmlspecialchars($lesson['title']) ?></td>

                                    <!-- VIDEO -->
                                    <td>
                                        <?php if (!empty($lesson['video'])): ?>
                                            <a href="<?= htmlspecialchars($lesson['video']) ?>"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-video"></i> Xem video
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Không có</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- DOCUMENT -->
                                    <td>
                                        <?php if (!empty($lesson['document'])): ?>
                                            <a href="<?= htmlspecialchars($lesson['document']) ?>"
                                                target="_blank" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-file-pdf"></i> Tài liệu
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Không có</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= $lesson['created_at'] ?></td>

                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap gap-1">

                                            <!-- EDIT -->
                                            <a href="?views=instructor&instructor=lessons&action=edit&id=<?= $lesson['id'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>

                                            <!-- DELETE -->
                                            <a href="?views=instructor&instructor=lessons&action=delete&id=<?= $lesson['id'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc muốn xóa bài học này?');">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>