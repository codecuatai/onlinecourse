<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng danh sách tài liệu
$materials = [
    [
        "title" => "Bài học 1 - Giới thiệu Python",
        "type" => "PDF",
        "uploaded_at" => "01/12/2025",
        "download_link" => "#",
        "edit_link" => "./edit.php"
    ],
    [
        "title" => "Bài học 2 - Biến và kiểu dữ liệu",
        "type" => "DOCX",
        "uploaded_at" => "02/12/2025",
        "download_link" => "#",
        "edit_link" => "./edit.php"
    ],
    // Thêm tài liệu khác nếu cần
];
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Quản lý tài liệu - Khóa học: Python cho Người Mới</h4>
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút tải tài liệu mới -->
    <div class="mb-3">
        <a class="btn btn-success" href="./create.php">
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
                                    <td class="text-start"><?= $material['title'] ?></td>
                                    <td><?= $material['type'] ?></td>
                                    <td><?= $material['uploaded_at'] ?></td>
                                    <td>
                                        <a href="<?= $material['download_link'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> Tải về
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= $material['edit_link'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
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