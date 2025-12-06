<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';


// Fake data (vì bạn chưa dùng DB)
$categories = [
    1 => ["name" => "Lập trình Web", "description" => "HTML, CSS, JavaScript", "created_at" => "2024-05-01"],
    2 => ["name" => "Phân tích dữ liệu", "description" => "Python, pandas, visualization", "created_at" => "2024-05-05"],
    3 => ["name" => "AI & Machine Learning", "description" => "Thuật toán, mô hình AI", "created_at" => "2024-06-01"]
];


// Lấy ID từ URL
$id = $_GET['id'] ?? null;

// Kiểm tra tồn tại
if (!$id || !isset($categories[$id])) {
    echo "<div class='alert alert-danger m-4'>Không tìm thấy danh mục!</div>";
    require_once _PATH_URL . '/../views/layouts/footer.php';
    exit;
}

$cate = $categories[$id];

// Xử lý POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'] ?? '';
    $new_desc = $_POST['description'] ?? '';

    // Tạm thời chỉ debug dữ liệu
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $cate['name'] = $new_name;
    $cate['description'] = $new_desc;
}

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

            <form action="" method="POST">

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