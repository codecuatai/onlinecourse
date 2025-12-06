<?php
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../config/Database.php';

class EnrollmentController
{
    private $enrollModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
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

        $course_id  = $_POST['course_id'];
        $student_id = $_SESSION['user_id'];

        // Kiểm tra trùng đăng ký
        if ($this->enrollModel->isEnrolled($course_id, $student_id)) {
            echo "Bạn đã đăng ký khóa học này rồi!";
            return;
        }

        // Thực hiện đăng ký
        if ($this->enrollModel->enroll($course_id, $student_id)) {
            header("Location: index.php?controller=enrollment&action=myCourses");
        } else {
            echo "Đăng ký thất bại!";
        }
    }

    // ✅ HIỂN THỊ KHÓA HỌC ĐÃ ĐĂNG KÝ
    public function myCourses()
    {
        session_start();
        $student_id = $_SESSION['user_id'];

        $courses = $this->enrollModel->getMyCourses($student_id);
        require_once __DIR__ . '/../views/student/my_courses.php';
    }
}
