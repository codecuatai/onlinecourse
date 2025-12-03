<?php
// controllers/AdminController.php

require_once '../config/Database.php';
require_once '../models/User.php'; 

class AdminController {
    private $user_model;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user_model = new User($db);
        
        // Luôn kiểm tra quyền truy cập Admin khi khởi tạo Controller này
        $this->checkAdminAccess();
    }

    private function checkAdminAccess() {
        // Kiểm tra xem người dùng đã đăng nhập chưa và có role = 2 (Quản trị viên) không
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 2) {
            // Chuyển hướng về trang chủ hoặc trang báo lỗi 403 (Không có quyền)
            header('Location: /'); 
            exit;
        }
    }

    // Phương thức hiển thị trang dashboard Admin
    public function dashboard() {
        $stats = []; // Dữ liệu thống kê sẽ được thêm sau
        include '../views/admin/dashboard.php';
    }

    // Phương thức hiển thị danh sách người dùng (URL: /admin/manageUsers)
    public function manageUsers() {
        $users = $this->user_model->getAllUsers();
        include '../views/admin/users/manage.php';
    }

    // Phương thức xử lý cập nhật vai trò (URL POST: /admin/updateRole)
    public function updateRole() {
        $user_id = $_POST['user_id'] ?? null;
        $new_role = $_POST['new_role'] ?? null;
        
        if ($user_id && in_array($new_role, [0, 1, 2])) {
            if ($this->user_model->updateRole($user_id, (int)$new_role)) {
                $message = "Cập nhật vai trò thành công!";
            } else {
                $error = "Cập nhật thất bại. Vui lòng thử lại.";
            }
        } else {
            $error = "Dữ liệu không hợp lệ.";
        }
        
        // Quay lại trang quản lý người dùng sau khi cập nhật
        $this->manageUsers();
    }
}
?>