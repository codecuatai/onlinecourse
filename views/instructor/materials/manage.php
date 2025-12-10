<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Giả sử controller đã truyền $materials và $lessons
// Nếu chưa có, fallback về mảng rỗng
$materials = $_SESSION['materials'];
$lessons = $_SESSION['lessons'];
$course = $_SESSION['course'];
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Quản lý tài liệu - Khóa học: <?= htmlspecialchars($courses['title']) ?></h4>
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút tải tài liệu mới -->
    <div class="mb-3">
        <a class="btn btn-success" href="?controllers=MaterialController&action=viewCreateMaterial&course_id=<?= $course_id ?>">
            <i class="fas fa-plus"></i> Tải tài liệu mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên tài liệu</th>
                            <th>Loại</th>
                            <th>Ngày tải lên</th>
                            <th>Link tải</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($materials)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có tài liệu nào.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($materials as $index => $material): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td class="text-start"><?= htmlspecialchars($material['filename']) ?></td>
                                    <td><?= htmlspecialchars($material['file_type']) ?></td>
                                    <td><?= htmlspecialchars($material['uploaded_at']) ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($material['file_path']) ?>" class="btn btn-sm btn-primary" download>
                                            <i class="fas fa-download"></i> Tải về
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="?views=instructor&instructor=materials&action=edit&material_id=<?= $material['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="?views=instructor&instructor=materials&action=delete&material_id=<?= $material['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?')">
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