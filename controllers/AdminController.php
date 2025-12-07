<?php

class AdminController
{
    public function __construct()
    {
        // Khởi động session nếu cần (thường đã được xử lý trong index.php)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra quyền Admin (role = 2)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        // *Chú ý: Giả định Model cần thiết được nạp bằng Autoloading hoặc thủ công ở nơi khác.*
    }

    /**
     * Hiển thị bảng điều khiển (Dashboard) của Quản trị viên.
     * URL: ?controller=admin&action=dashboard
     */
    public function dashboard()
    {
        // Logic nghiệp vụ (Ví dụ: Lấy số liệu thống kê)
        // $stats = $this->adminModel->getSystemStats();

        // Nạp giao diện Admin
        include_once ROOT . '/views/dashboard.php';
    }

    /**
     * Quản lý người dùng.
     * URL: ?controller=admin&action=manageUsers
     */
    public function manageUsers()
    {
        // $users = $this->userModel->getAllUsers();
        include_once ROOT . '/views/admin/users/manage.php';
    }

    /**
     * Hiển thị danh sách categories.
     * URL: ?controller=admin&action=listCategories
     */
    public function listCategories()
    {
        // $categories = $this->categoryModel->getAll();
        include_once ROOT . '/views/admin/categories/list.php';
    }
    
    // Bạn cần thêm các action khác như createCategory, editCategory, reports/statistics...
}