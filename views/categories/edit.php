<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

$cate = $_SESSION['category_edit'];
?>

<main class="main-content p-4">

    <div class="card shadow-sm border-0" style="max-width: 700px; margin: auto;">

        <!-- Header -->
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sửa danh mục</h5>

            <a href="?views=categories&action=list" class="btn btn-light btn-sm">
                Quay lại
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">

            <form action="?controllers=CategoryController&action=updateCategory" method="POST">
                <!-- Hidden ID -->
                <input type="hidden" name="id" value="<?= $cate['id'] ?>">

                <!-- Tên danh mục -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($cate['name']) ?>"
                        placeholder="Nhập tên danh mục...">
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="form-control"
                        placeholder="Nhập mô tả..."><?= htmlspecialchars($cate['description']) ?></textarea>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4 text-white fw-bold">
                        Lưu thay đổi
                    </button>
                </div>

            </form>

        </div>
    </div>

</main>

<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>