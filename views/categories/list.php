<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';


$categories = [
    [
        "id" => 1,
        "name" => "Lập trình Web",
        "description" => "Khóa học về HTML, CSS, JavaScript",
        "created_at" => "2024-05-01"
    ],
    [
        "id" => 2,
        "name" => "Phân tích dữ liệu",
        "description" => "Python, pandas, trực quan hóa dữ liệu",
        "created_at" => "2024-05-05"
    ],
    [
        "id" => 3,
        "name" => "AI & Machine Learning",
        "description" => "Thuật toán, mô hình, huấn luyện AI",
        "created_at" => "2024-06-01"
    ],
];
?>

<main class="main-content p-4">

    <div class="card shadow-sm border-0">
        <div style="margin-bottom:20px;" class="card-header d-flex justify-content-between align-items-center bg-success text-white">
            <h4 class="mb-0">Quản lý danh mục khóa học</h4>
            <a href="?views=categories&action=create" class="btn btn-light btn-sm">+ Thêm danh mục</a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Khóa học</th>
                            <th class="text-center">Sửa</th>
                            <th class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($categories as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['description'] ?></td>
                                <td><?= $item['created_at'] ?></td>

                                <!-- Nút danh sách khóa học -->
                                <td class="text-center">
                                    <a href="../courses/index.php?category_id=<?= $item['id'] ?>" class="btn btn-sm btn-info text-white">
                                        Danh sách
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a href="?views=categories&action=edit" class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-danger">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>