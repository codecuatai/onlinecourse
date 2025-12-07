<?php
// C:\xampp\htdocs\onlinecourse\controllers\StudentController.php

// Yêu cầu các Model cần thiết (ví dụ: User.php, Course.php)
// require_once __DIR__ . '/../models/Course.php'; 

class StudentController 
{
    // private $model; // Nếu cần tương tác với Model

    public function __construct() 
    {
        // Khởi tạo các Model nếu cần
    }

    /**
     * Xử lý yêu cầu: ?views=student&action=myCourses
     */
    public function myCourses() 
    {
        // 1. Logic kiểm tra đăng nhập (nếu cần)
        // if (!isset($_SESSION['user_id'])) { header('Location: ?views=auth&action=login'); exit; }
        
        // 2. Logic lấy danh sách khóa học của học viên (ví dụ: $data = $this->model->getStudentCourses($_SESSION['user_id']);)

        // 3. Hiển thị View
        include_once ROOT . '/views/student/my_courses.php'; 
    }
    
    // Bạn có thể thêm các Action khác ở đây
}