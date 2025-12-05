<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng chứa khóa học của giảng viên
$courses = [
    [
        "title" => "Python cho Người Mới",
        "created_at" => "01/12/2025",
        "category" => "Lập trình",
        "level" => "Beginner",
        "price" => "499.000₫",
        "status" => "Chờ duyệt",
        "students_link" => "../students/manage.php",
        "lessons_link" => "../lessons/manage.php",
        "materials_link" => "../materials/manage.php",
        "edit_link" => "./edit.php"
    ],
    [
        "title" => "ReactJS Mastery",
        "created_at" => "15/11/2025",
        "category" => "Lập trình",
        "level" => "Intermediate",
        "price" => "599.000₫",
        "status" => "Đang duyệt",
        "students_link" => "../students/manage.php",
        "lessons_link" => "../lessons/manage.php",
        "materials_link" => "../materials/manage.php",
        "edit_link" => "./edit.php"
    ],
    // Bạn có thể thêm nhiều khóa học khác vào đây
];
?>

<div class="container-fluid mt-4">
    <h4 class="mb-4">Quản lý khóa học của giảng viên</h4>

    <!-- Nút tạo khóa học mới -->
    <div class="mb-3">
        <a class="btn btn-success" href="./create.php">
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
                            <th>Thể loại</th>
                            <th>Level</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $index => $course): ?>
                            <tr class="text-center">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td class="text-start"><?= $course['title'] ?></td>
                                <td><?= $course['created_at'] ?></td>
                                <td><?= $course['category'] ?></td>
                                <td><?= $course['level'] ?></td>
                                <td><?= $course['price'] ?></td>
                                <td>
                                    <span class="badge <?= $course['status'] == 'Chờ duyệt' ? 'bg-warning text-dark' : 'bg-success' ?>">
                                        <?= $course['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center flex-wrap gap-1">
                                        <a href="<?= $course['edit_link'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="<?= $course['students_link'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-book"></i> Sinh viên
                                        </a>
                                        <a href="<?= $course['lessons_link'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-book"></i> Bài học
                                        </a>
                                        <a href="<?= $course['materials_link'] ?>" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-book"></i> Tài liệu
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>