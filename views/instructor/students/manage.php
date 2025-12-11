<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng danh sách sinh viên của khóa học

$students = $_SESSION['students'];
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
        <a href="?controllers=EnrollmentController&action=viewCreateEnrollment&course_id=<?= $_GET['course_id'] ?>" class="btn btn-success">
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
                                    <td class="text-start">
                                        <?= $student['student_name'] ?>
                                    </td>
                                    <td> <?= $student['student_email'] ?> </td>
                                    <td><?= $student['enrolled_date'] ?></td>
                                    <td>
                                        <?php if ($student['status'] === "active"): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><?= $student['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $student['progress'] ?>%</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="?controllers=EnrollmentController&action=viewEditEnrollment&course_id=<?= $_GET['course_id'] ?>&enrollment_id=<?= $student['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="?controllers=EnrollmentController&action=deleteEnrollment&enrollment_id=<?= $student['id'] ?>&course_id=<?= $_GET['course_id'] ?>" class="btn btn-sm btn-danger">
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