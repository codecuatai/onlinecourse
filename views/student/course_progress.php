<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng khóa học đã đăng ký cùng tiến độ
$courses = [
    [
        "id" => 1,
        "title" => "Python cho Người Mới Bắt Đầu",
        "category" => "Lập trình",
        "instructor" => "Nguyễn Văn A",
        "created_at" => "2024-06-01",
        "total_lessons" => 5,
        "completed_lessons" => 2
    ],
    [
        "id" => 2,
        "title" => "UI/UX Design Masterclass",
        "category" => "Thiết kế",
        "instructor" => "Trần Thị B",
        "created_at" => "2024-05-20",
        "total_lessons" => 6,
        "completed_lessons" => 4
    ],
    [
        "id" => 3,
        "title" => "JavaScript Full Stack",
        "category" => "Lập trình",
        "instructor" => "Phạm Văn D",
        "created_at" => "2024-07-10",
        "total_lessons" => 8,
        "completed_lessons" => 3
    ]
];
?>

<main class="main-content p-4">

    <h4 class="mb-4">Danh sách khóa học đã đăng ký</h4>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên khóa học</th>
                            <th>Giảng viên</th>
                            <th>Danh mục</th>
                            <th>Ngày tạo</th>
                            <th>Tiến độ</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $index => $course):
                            $progress = round(($course['completed_lessons'] / $course['total_lessons']) * 100);
                        ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $course['title'] ?></td>
                                <td><?= $course['instructor'] ?></td>
                                <td><?= $course['category'] ?></td>
                                <td><?= $course['created_at'] ?></td>
                                <td style="width:200px;">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= $progress ?>%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="course_of_lession.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-primary">Xem chi tiết</a>
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