<?php
require_once './models/Category.php';
require_once './models/Course.php';

class CategoryController
{
    private $categoryModel;
    private $courseModel;

    public function __construct()
    {
        // Khởi tạo model Category với kết nối PDO
        $this->categoryModel = new Category();
        $this->courseModel = new Course();
    }

    // Hiển thị tất cả danh mục
    public function viewCategories()
    {
        // Lấy tất cả category từ model
        $categories = $this->categoryModel->getAllCategories();

        // Lưu vào session hoặc biến để view dùng
        $_SESSION['categories'] = $categories;

        // Chuyển hướng tới file view
        header('Location: ?views=categories&action=list');
    }

    // Thêm category (gọi form thêm)
    public function createCategoryForm()
    {
        require_once __DIR__ . '/../views/categories/create.php';
    }

    // Xử lý thêm category
    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            $this->categoryModel->createCategory($data);

            // Chuyển về danh sách category
            header("Location: ?controllers=CategoryController&action=viewCategories");
            exit;
        }
    }

    public function viewCoursesByCategory()
    {
        if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
            header("Location: ?controllers=CategoryController&action=viewCategories");
            exit;
        }

        $category_id = (int)$_GET['category_id'];

        // Lấy tất cả khóa học của category
        $courses = $this->courseModel->getCoursesByCategory($category_id);

        // Lấy thông tin category (tên) để hiển thị tiêu đề
        $category = $this->categoryModel->getCategoryById($category_id);

        $_SESSION['category_courses'] = $courses;
        $_SESSION['category_info'] = $category;

        header("Location: ?views=categories&action=courses_by_category");
    }

    public function viewEditCategory()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Nếu không có id, chuyển về danh sách
            header('Location: ?controllers=CategoryController&action=viewCategories');
            exit;
        }
        $id = (int)$_GET['id'];
        $category = $this->categoryModel->getCategoryById($id);

        if (!$category) {
            // Nếu không tìm thấy category, quay về danh sách
            header('Location: ?controllers=CategoryController&action=viewCategories');
            exit;
        }

        // Lưu dữ liệu category vào session để view sử dụng
        $_SESSION['category_edit'] = $category;

        // Chuyển hướng sang view edit
        header('Location: ?views=categories&action=edit');
        exit;
    }


    public function deleteCategory()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Nếu không có id, chuyển về trang danh sách
            header("Location: ?controllers=CategoryController&action=viewCategories");
            exit;
        }

        $id = (int) $_GET['id'];

        // Trước khi xóa danh mục, có thể kiểm tra xem có khóa học thuộc danh mục này không
        $courses = $this->courseModel->getCoursesByCategory($id);
        if (!empty($courses)) {
            header("Location: ?controllers=CategoryController&action=viewCategories");
            exit;
        }

        // Thực hiện xóa
        $deleted = $this->categoryModel->deleteCategory($id);


        // Chuyển về trang danh sách
        header("Location: ?controllers=CategoryController&action=viewCategories");
        exit;
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $data = [
                'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                'description' => isset($_POST['description']) ? trim($_POST['description']) : ''
            ];

            if ($id > 0 && !empty($data['name'])) {
                // Gọi model, truyền đúng 2 tham số
                $result = $this->categoryModel->updateCategory($id, $data);

                if ($result) {
                    $_SESSION['success'] = "Cập nhật danh mục thành công!";
                } else {
                    $_SESSION['error'] = "Cập nhật thất bại. Vui lòng thử lại!";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            }
        }

        // Quay lại trang danh sách category
        header('Location: ?controllers=CategoryController&action=viewCategories');
        exit;
    }
    // Các phương thức khác như index, createCategory, editCategory, viewCoursesByCategory...
}
