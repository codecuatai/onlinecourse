<?php

class StudentController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra quyền: Chỉ cần đảm bảo đã đăng nhập
        // (Nếu cần hạn chế chỉ role 0, thì dùng: $_SESSION['role'] != 0)
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    /**
     * Hiển thị bảng điều khiển (Dashboard) của Học viên.
     * URL: ?controller=student&action=dashboard
     */
    public function dashboard()
    {
        // $data = $this->enrollmentModel->getDashboardData($_SESSION['user_id']);
        include_once ROOT . '/views/dashboard.php';
    }

    /**
     * Hiển thị các khóa học đã đăng ký.
     * URL: ?controller=student&action=myCourses
     */
    public function myCourses()
    {
        include_once ROOT . '/views/student/my_courses.php';
    }

    /**
     * Xem tiến độ khóa học.
     * URL: ?controller=student&action=courseProgress&course_id=X
     */
    public function courseProgress()
    {
        // $progress = $this->enrollmentModel->getProgress($_GET['course_id']);
        include_once ROOT . '/views/student/course_progress.php';
    }
}