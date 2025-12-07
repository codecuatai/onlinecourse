<?php
// C:\xampp\htdocs\onlinecourse\controllers\InstructorController.php

// KHÔNG CẦN require_once Model Course nếu không sử dụng nó
// Bạn có thể bỏ comment nếu muốn xóa hẳn:
require_once __DIR__ . '/../models/Course.php'; 

class InstructorController 
{
    private $courseModel; 
    
    // Vẫn cần khởi tạo constructor để tránh lỗi Fatal Error khi lớp được tạo
    public function __construct() 
    {
        // Loại bỏ logic khởi tạo nếu bạn muốn vứt bỏ mọi thứ liên quan đến Model
        // Tuy nhiên, nếu bạn để lại require_once Course.php, bạn sẽ vẫn cần khởi tạo nó.
        // TỐT NHẤT là vẫn giữ constructor nếu bạn có ý định dùng Model sau này.
        global $db; 
        if (class_exists('Course')) {
            $this->courseModel = new Course($db); 
        }
    }
    
    // ... (Phương thức checkInstructorAccess() và dashboard() giữ nguyên) ...

    /**
     * Xử lý yêu cầu: ?views=instructor&action=manageCourses
     * CHỈ THỰC HIỆN KIỂM TRA QUYỀN VÀ HIỂN THỊ VIEW
     */
    public function manageCourses() 
    {
        // 1. Kiểm tra quyền truy cập (BẮT BUỘC)
        if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
            header('Location: ?views=auth&action=login');
            exit;
        }

        // 2. KHÔNG GỌI MODEL VÀ KHÔNG LẤY DỮ LIỆU
        // (Tất cả logic lấy dữ liệu Model đã bị vứt bỏ)
        
        // 3. Hiển thị View (Nhiệm vụ duy nhất)
        include_once ROOT . '/views/instructor/course/manage.php';
    }

    // ... (Các Action khác) ...
}