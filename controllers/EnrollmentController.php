<?php
require_once __DIR__ . '/../models/Enrollment.php';
// Gọi model User
require_once __DIR__ . '/../models/User.php';


class EnrollmentController
{
    private $enrollmentModel;
    private $userModel;

    public function __construct()
    {
        $this->enrollmentModel = new Enrollment();
        $this->userModel = new User();

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


    public function viewCreateEnrollment()
    {
        // Lấy course_id từ URL
        $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;


        // Lấy ID học viên từ session
        $student_id = $_SESSION['user_id'] ?? 0;

        if ($student_id <= 0) {
            echo "❌ Bạn phải đăng nhập!";
            return;
        }

        header("Location: ?views=instructor&instructor=students&action=create&course_id=$course_id");
    }

    public function createStudent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ!";
            header("Location: ?views=instructor&instructor=students&action=manage");
            exit();
        }

        // Dữ liệu từ form
        $course_id = intval($_POST['course_id'] ?? 0);
        $username  = trim($_POST['username'] ?? "");
        $status    = $_POST['status'] ?? "active";
        $progress  = intval($_POST['progress'] ?? 0);

        if ($course_id <= 0 || $username === "") {
            $_SESSION['error'] = "Thiếu thông tin sinh viên!";
            header("Location: ?views=instructor&instructor=students&action=create&course_id=$course_id");
            exit();
        }

        // Tìm user theo username
        $student = $this->userModel->getUserByUsername($username);

        if (!$student) {
            $_SESSION['error'] = "Không tìm thấy username: $username";
            header("Location: ?views=instructor&instructor=students&action=create&course_id=$course_id");
            exit();
        }

        $student_id = $student['id'];

        // Kiểm tra đã đăng ký khóa này chưa
        if ($this->enrollmentModel->isEnrolled($course_id, $student_id)) {
            $_SESSION['error'] = "User $username đã đăng ký khóa học này!";
            header("Location: ?views=instructor&instructor=students&action=create&course_id=$course_id");
            exit();
        }

        // Thực hiện thêm vào DB (gọi model)
        $result = $this->enrollmentModel->createEnrollmentForStudent(
            $course_id,
            $student_id,
            $status,
            $progress
        );

        if ($result) {
            $_SESSION['success'] = "Thêm sinh viên vào khóa học thành công!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
        } else {
            $_SESSION['error'] = "Lỗi khi thêm sinh viên!";
            header("Location: ?views=instructor&instructor=students&action=create&course_id=$course_id");
        }
        exit();
    }

    public function deleteEnrollment()
    {
        // Lấy enrollment_id từ URL
        $enrollment_id = isset($_GET['enrollment_id']) ? intval($_GET['enrollment_id']) : 0;
        $course_id     = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

        if ($enrollment_id <= 0 || $course_id <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
            exit;
        }
        // Tiến hành xóa
        if ($this->enrollmentModel->deleteEnrollment($enrollment_id)) {
            $_SESSION['success'] = "Xóa sinh viên khỏi khóa học thành công!";
        } else {
            $_SESSION['error'] = "Xóa thất bại!";
        }

        // Quay về lại danh sách sinh viên
        header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
        exit;
    }




    public function viewEditEnrollment()
    {
        // Lấy ID enrollment từ URL
        $enrollment_id = isset($_GET['enrollment_id']) ? intval($_GET['enrollment_id']) : 0;
        $course_id     = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

        if ($enrollment_id <= 0 || $course_id <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
            exit();
        }

        // Lấy dữ liệu đăng ký theo ID
        $enrollment = $this->enrollmentModel->getEnrollmentById($enrollment_id);

        if (!$enrollment) {
            $_SESSION['error'] = "Không tìm thấy thông tin đăng ký!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
            exit();
        }

        // Lưu vào session để view sử dụng
        $_SESSION['edit_enrollment'] = $enrollment;


        // Chuyển đến view sửa
        header("Location: ?views=instructor&instructor=students&action=edit&course_id=$course_id&enrollment_id=$enrollment_id");
        exit();
    }



    public function updateEnrollment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse");
            exit;
        }

        // Lấy dữ liệu từ form
        $id       = intval($_POST['id']);
        $status   = $_POST['status'] ?? 'active';
        $progress = intval($_POST['progress']);

        // Kiểm tra session chứa enrollment để lấy course_id
        if (!isset($_SESSION['edit_enrollment'])) {
            $_SESSION['error'] = "Không tìm thấy dữ liệu phiên sửa!";
            header("Location: ?controllers=CourseController&action=viewStudentByCourse");
            exit;
        }

        $course_id = $_SESSION['edit_enrollment']['course_id'];

        // Validate tiến độ
        if ($progress < 0 || $progress > 100) {
            $_SESSION['error'] = "Tiến độ phải nằm trong khoảng 0 - 100!";
            header("Location: ?controllers=EnrollmentController&action=viewEditEnrollment&course_id=$course_id&enrollment_id=$id");
            exit;
        }

        // Thực hiện cập nhật bằng model
        $updated = $this->enrollmentModel->updateEnrollment($id, $status, $progress);

        if ($updated) {
            $_SESSION['success'] = "Cập nhật thông tin sinh viên thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại, vui lòng thử lại!";
        }

        // Quay về danh sách sinh viên của khóa học
        header("Location: ?controllers=CourseController&action=viewStudentByCourse&course_id=$course_id");
        exit;
    }
}
