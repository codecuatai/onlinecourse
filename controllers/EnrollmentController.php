<?php
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController
{
    private $enrollmentModel;

    public function __construct()
    {
        $this->enrollmentModel = new Enrollment();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    // ===============================================
    // 🔵 XỬ LÝ ĐĂNG KÝ KHÓA HỌC
    // ===============================================
    public function enroll()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để đăng ký!";
            header("Location: ?controller=auth&action=login");
            exit();
        }

        $course_id  = (int) $_POST['course_id'];
        $student_id = (int) $_SESSION['user_id'];


        // Kiểm tra trùng đăng ký
        if ($this->enrollmentModel->isEnrolled($course_id, $student_id)) {
            $_SESSION['error_enrolled'] = "Bạn đã đăng ký khóa học này rồi!";
            header("Location: ?controllers=CourseController&action=viewDetail&id=$course_id");
            exit();
        }
        // Thực hiện đăng ký
        if ($this->enrollmentModel->enroll($course_id, $student_id)) {
            $_SESSION['success'] = "Đăng ký khóa học thành công!";
            header("Location: ?controllers=EnrollmentController&action=myCourses");
            exit();
        } else {
            $_SESSION['error'] = "Đăng ký thất bại, vui lòng thử lại!";
            header("Location: ?controllers=CourseController&action=viewDetail&id=$course_id");
            exit();
        }
    }


    // ===============================================
    // 🔵 HIỂN THỊ KHÓA HỌC ĐÃ ĐĂNG KÝ CỦA HỌC VIÊN
    // ===============================================
    public function myCourses()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập!";
            header("Location: ?controllers=AuthController&action=login");
            exit();
        }

        $student_id = (int) $_SESSION['user_id'];

        // Lấy danh sách khóa học đã đăng ký
        $courses = $this->enrollmentModel->getMyCourses($student_id);
        $_SESSION['enroll_courses'] = $courses;

        header("Location: ?views=student&action=my_courses");
    }
}
