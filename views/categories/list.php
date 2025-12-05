<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<main class="main-content p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-success text-white" style="margin-bottom: 20px;">
            <h4 class="mb-0">Quản lý danh mục khóa học</h4>
            <a href="add_category.php" class="btn btn-light btn-sm">+ Thêm danh mục</a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Xóa</th>
                            <th scope="col">Sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="col">#</td>
                            <td scope="col">Tên</td>
                            <td scope="col">Mô tả</td>
                            <td scope="col">Ngày tạo</td>
                            <td>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning">Sửa</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>


<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
