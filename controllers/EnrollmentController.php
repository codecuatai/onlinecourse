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


        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controllers=AuthController&action=login");
            exit();
        }

        // ✅ ÉP KIỂU AN TOÀN
        $course_id  = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
        $student_id = intval($_SESSION['user_id']);

        // ✅ KIỂM TRA course_id HỢP LỆ
        if ($course_id <= 0) {
            $_SESSION['error'] = "Khóa học không hợp lệ!";
            header("Location: index.php");
            exit();
        }

        // Kiểm tra trùng đăng ký
        if ($this->enrollModel->isEnrolled($course_id, $student_id)) {
            $_SESSION['error'] = "Bạn đã đăng ký khóa học này rồi!";
            header("Location: index.php?controllers=CourseController&action=detail&id=" . $course_id);
            exit();
        }


        // Thực hiện đăng ký
        if ($this->enrollModel->enroll($course_id, $student_id)) {
            $_SESSION['success'] = "Đăng ký khóa học thành công!";
            header("Location: index.php?controller=EnrollmentController&action=myCourses");
            exit();
        } else {
            $_SESSION['error'] = "Đăng ký thất bại!";
            header("Location: index.php?controllers=CourseController&action=detail&id=" . $course_id);
            exit();
        }
    }

    // ✅ HIỂN THỊ KHÓA HỌC ĐÃ ĐĂNG KÝ
    public function myCourses()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=AuthController&action=login");
        exit();
    }

    $student_id = intval($_SESSION['user_id']);
    $courses = $this->enrollModel->getMyCourses($student_id);

    require_once __DIR__ . '/../views/student/my_courses.php';
}

}
