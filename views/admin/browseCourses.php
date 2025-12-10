<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
$courses = $courses ?? [];
?>

<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Duyệt khóa học</h4>

    </div>


    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Tên khóa học</th>
                            <th>Giảng viên</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($courses as $index => $course): ?>
                            <tr class="text-center">
                                <td><?= $index + 1 ?></td>
                                
                                <td class="text-start"><?= htmlspecialchars($course['title'] ?? 'N/A') ?></td>
                                
                                <td><?= htmlspecialchars($course['instructor_name'] ?? 'Không rõ') ?></td>
                                
                                <td><?= htmlspecialchars($course['created_at'] ?? 'N/A') ?></td>
                                
                                <td>
                                    <span class="badge bg-warning text-dark"><?= htmlspecialchars($course['status'] ?? 'N/A') ?></span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="?views=admin&action=approveCourse&id=<?= $course['id'] ?>"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Duyệt
                                        </a>

                                        <a href="?views=admin&action=rejectCourse&id=<?= $course['id'] ?>"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Từ chối
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Không có khóa học nào cần duyệt.
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>