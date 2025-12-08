<?php
// C:\xampp\htdocs\onlinecourse\controllers\AdminController.php

class AdminController
{
    // ... Constructor và các hàm khác ...

    /**
     * Hiển thị danh sách khóa học trong trang quản trị.
     */
    public function browseCourses()
    {
        // 1. Kiểm tra quyền (Authorization)
        // Đảm bảo chỉ có Quản trị viên (role=2) mới truy cập được.
        // if ($_SESSION['role'] != 2) { 
        //     header('Location: unauthorized.php'); 
        //     exit;
        // }

        // 2. Gọi Model để lấy dữ liệu (Fetch Data)
        // $courses = $this->courseModel->getAllCourses(); 

        // 3. Hiển thị View (Render View)
        include_once ROOT . '/views/admin/browseCourses.php';
    }

    // ... Các Action khác (ví dụ: addCourse, editCourse, v.v.)
}
