<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng chứa khóa học của giảng viên
$courses = $_SESSION['instructor_courses'];
?>

<div class="container-fluid mt-4">
    <h4 class="mb-4">Quản lý khóa học của giảng viên</h4>

    <!-- Nút tạo khóa học mới -->
    <div class="mb-3">
        <a class="btn btn-success" href="?controllers=CourseController&action=viewCreate">
            <i class="fas fa-plus"></i> Tạo khóa học mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Tên khóa học</th>
                            <th>Ngày tạo</th>
                            <th>Mô tả</th>
                            <th>Level</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $index => $course): ?>
                            <tr class="text-center">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td class="text-start"><?= htmlspecialchars($course['title']) ?></td>
                                <td><?= $course['created_at'] ?></td>
                                <td><?= htmlspecialchars($course['description']) ?></td>
                                <td><?= htmlspecialchars($course['level']) ?></td>
                                <td><?= number_format($course['price'], 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <div class="d-flex justify-content-center flex-wrap gap-1">
                                        <a href="?controllers=CourseController&action=viewEdit&id=<?= $course['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="?controllers=CourseController&action=deleteCourseOfInstructor&id=<?= $course['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                        <a href="?controllers=CourseController&action=viewStudentByCourse&course_id=<?= $course['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-book"></i> Học Sinh
                                        </a>
                                        <a href="?controllers=LessonController&action=viewLessonsByCourse&id=<?= $course['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-book"></i> Bài học
                                        </a>
                                        <a href="?controllers=MaterialController&action=viewMaterials&course_id=<?= $course['id'] ?>" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file"></i> Tài liệu
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Chưa có khóa học nào</td>
                            </tr>
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