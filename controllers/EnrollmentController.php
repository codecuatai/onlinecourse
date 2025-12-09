<?php
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../config/Database.php';

class EnrollmentController
{
    private $enrollModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->enrollModel = new Enrollment($db);
    }

    // ✅ XỬ LÝ ĐĂNG KÝ KHÓA HỌC
    public function enroll()
    {
        session_start();

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $course_id  = $_POST['course_id']?? 0;
        $student_id = $_SESSION['user_id'];

        // Kiểm tra trùng đăng ký
        if ($course_id == 0) {
            $_SESSION['error'] = "Khóa học không hợp lệ!";
            header("Location: index.php");
            exit();
        }


        // Thực hiện đăng ký
        if ($this->enrollModel->enroll($course_id, $student_id)) {
            $_SESSION['success'] = "Đăng ký khóa học thành công!";
            header("Location: index.php?controller=enrollment&action=myCourses");
        } else {
            echo "Đăng ký thất bại!";
            header("Location: index.php?controller=course&action=detail&id=" . $course_id);
        }
    }

    // ✅ HIỂN THỊ KHÓA HỌC ĐÃ ĐĂNG KÝ
    public function myCourses()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $student_id = $_SESSION['user_id'];

        $courses = $this->enrollModel->getMyCourses($student_id);
        require_once __DIR__ . '/../views/student/my_courses.php';
    }
}
