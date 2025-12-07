<?php

class InstructorController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra quyền Giảng viên (role = 1)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    /**
     * Hiển thị bảng điều khiển (Dashboard) của Giảng viên.
     * URL: ?controller=instructor&action=dashboard
     */
    public function dashboard()
    {
        // $courses = $this->courseModel->getCoursesByInstructor($_SESSION['user_id']);
        include_once ROOT . '/views/dashboard.php';
    }

    /**
     * Hiển thị danh sách khóa học của Giảng viên.
     * URL: ?controller=instructor&action=myCourses
     */
    public function myCourses()
    {
        include_once ROOT . '/views/instructor/my_courses.php';
    }

    /**
     * Hiển thị form tạo khóa học.
     * URL: ?controller=instructor&action=createCourse
     */
    public function createCourse()
    {
        include_once ROOT . '/views/instructor/course/create.php';
    }

    /**
     * Xử lý POST request tạo khóa học.
     * URL: ?controller=instructor&action=processCreateCourse (Nếu Router tự thêm 'process')
     */
    // public function processCreateCourse() { ... }
    
    // Bạn cần thêm các action khác như editCourse, manageCourse, createLesson, manageMaterials...
}