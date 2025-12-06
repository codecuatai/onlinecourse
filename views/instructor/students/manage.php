<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng danh sách sinh viên của khóa học
$students = [
    [
        "name" => "Nguyễn Văn A",
        "email" => "nguyenvana@example.com",
        "registered_at" => "01/12/2025",
        "status" => "Active",
        "progress" => 75,
        "edit_link" => "./edit.php"
    ],
    [
        "name" => "Trần Thị B",
        "email" => "tranthib@example.com",
        "registered_at" => "02/12/2025",
        "status" => "Dropped",
        "progress" => 40,
        "edit_link" => "./edit.php"
    ],
    // Thêm sinh viên khác nếu cần
];
?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Danh sách sinh viên - Khóa học: Python cho Người Mới</h4>

        <!-- Nút quay lại -->
        <a href="?views=instructor&instructor=course&action=manage" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút thêm sinh viên mới -->
    <div class="mb-3">
        <a href="?views=instructor&instructor=students&action=create" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm sinh viên mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên sinh viên</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th>Trạng thái</th>
                            <th>Tiến độ (%)</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Chưa có sinh viên nào.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $index => $student): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td class="text-start"><?= $student['name'] ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= $student['registered_at'] ?></td>
                                    <td>
                                        <?php if ($student['status'] === "Active"): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><?= $student['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $student['progress'] ?>%</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="?views=instructor&instructor=students&action=edit" class="btn btn-sm btn-warning">
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