<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<main class="main-content p-4">

    <div class="card shadow-sm border-0" style="max-width: 700px; margin: auto;">

        <!-- Header -->
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm danh mục khóa học</h5>

            <a href="?views=categories&action=list" class="btn btn-light btn-sm">
                Quay lại
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">

            <form action="" method="POST">

                <!-- Tên danh mục -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục...">
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả..."></textarea>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        Lưu
                    </button>
                </div>

            </form>

        </div>
    </div>

</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
