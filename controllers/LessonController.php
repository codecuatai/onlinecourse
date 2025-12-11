<?php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/User.php';

class LessonController
{
    private $lessonModel;
    private $courseModel;
    private $enrollmentModel;
    private $userModel;

    public function __construct()
    {
        // Khởi tạo Lesson Model để tương tác với CSDL
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
        $this->enrollmentModel = new Enrollment();
        $this->userModel = new User();
    }

    public function viewLessonsByCourse()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=instructor&instructor=lessons&action=manage");
            exit;
        }

        $course_id = $_GET['id'];

        // Lấy danh sách bài học
        $stmt = $this->lessonModel->getLessonsByCourse($course_id);
        $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lưu vào session để sang view hiển thị
        $_SESSION['lessons'] = $lessons;

        // Lấy thông tin khóa học
        $course = $this->courseModel->getCourseById($course_id);
        $_SESSION['course'] = $course;

        // Chuyển đến trang manage của bài học
        header("Location: ?views=instructor&instructor=lessons&action=manage&id=" . $course_id);
        exit;
    }

    public function createLesson()
    {
        // Lấy course_id từ URL: ?course&id=5
        if (!isset($_POST['id'])) {
            header("Location: ?views=instructor&instructor=course&action=manage");
            exit;
        }

        $course_id = $_POST['id'];

        // Kiểm tra dữ liệu POST
        if (empty($_POST['title'])) {
            $_SESSION['error'] = "Vui lòng nhập tên bài học!";
            header("Location: ?views=instructor&instructor=lessons&action=create&id=" . $course_id);
            exit;
        }

        // ==========================
        // Lấy đường link video (text)
        // ==========================
        $video_url = !empty($_POST['video']) ? trim($_POST['video']) : null;

        // ==========================
        // Dữ liệu insert
        // ==========================
        $data = [
            ":course_id"    => $course_id,
            ":title"        => $_POST['title'],
            ":content"      => $_POST['description'] ?? "",
            ":video_url"    => $video_url,
            ":lesson_order" => 1, // Mặc định = 1; hoặc bạn tự tính thứ tự
        ];

        $result = $this->lessonModel->create($data);

        header("Location: ?controllers=LessonController&action=viewLessonsByCourse&id=" . $course_id);
        exit;
    }



    public function deleteLesson()
    {
        // Kiểm tra GET params
        if (!isset($_GET['lesson_id']) || !isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy bài học!";
            header("Location: ?controllers=CoursesController&action=viewCoursesOfInstructor");
            exit;
        }

        $lesson_id = $_GET['lesson_id'];
        $course_id = $_GET['id'];

        // Gọi model để xóa bài học
        $result = $this->lessonModel->delete($lesson_id, $course_id);

        // Redirect về trang quản lý bài học của khóa học
        header("Location: ?controllers=LessonController&action=viewLessonsByCourse&id=" . $course_id);
        exit;
    }






    // Quản lý bài học theo khóa học
    public function manage()
    {
        if (!isset($_GET["course_id"])) {
            header("Location: index.php?controller=course&action=manage");
            exit;
        }

        $course_id = $_GET["course_id"];
        $stmt = $this->lessonModel->getLessonsByCourse($course_id);
        $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "views/instructor/lessons/manage.php";
    }


    // Lưu bài học mới
    public function store()
    {
        if (empty($_POST['title'])) {
            $_SESSION['error'] = "Vui lòng nhập tiêu đề!";
            header("Location: index.php?controller=lesson&action=create&course_id=" . $_POST['course_id']);
            exit;
        }

        $data = [
            ":course_id" => $_POST["course_id"],
            ":title" => $_POST["title"],
            ":content" => $_POST["content"] ?? "",
            ":video_url" => $_POST["video_url"] ?? "",
            ":lesson_order" => $_POST["lesson_order"] ?? 1
        ];

        $this->lessonModel->create($data);

        header("Location: index.php?controller=lesson&action=manage&course_id=" . $_POST["course_id"]);
    }

    // Hiển thị form sửa bài học
    public function editLesson()
    {
        // Kiểm tra id bài học
        if (!isset($_GET['lesson_id'])) {
            $_SESSION['error'] = "Không tìm thấy bài học!";
            header("Location: ?views=instructor&instructor=lessons&action=manage");
            exit;
        }

        $lesson_id = $_GET['lesson_id'];

        // Lấy dữ liệu bài học từ model
        $lesson = $this->lessonModel->getLessonById($lesson_id);

        $_SESSION['lesson'] = $lesson;
        // Include form sửa bài học
        // Form sẽ sử dụng biến $lesson để hiển thị dữ liệu cũ
        header("Location: ?views=instructor&instructor=lessons&action=edit");
    }



    // Lưu cập nhật
    // Cập nhật bài học
    public function updateLesson()
    {
        if (!isset($_POST['id']) || !isset($_POST['course_id'])) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?views=instructor&instructor=lessons&action=manage");
            exit;
        }

        $lesson_id   = $_POST['id'];
        $course_id   = $_POST['course_id'];
        $title       = $_POST['title'] ?? '';
        $content     = $_POST['description'] ?? '';
        $lesson_order = $_POST['lesson_order'] ?? 1;

        // Chỉ lấy đường dẫn video từ input text
        $video_url = $_POST['video_url'] ?? '';

        // Dữ liệu cập nhật bài học
        $data = [
            ":id"          => $lesson_id,
            ":course_id"   => $course_id,
            ":title"       => $title,
            ":content"     => $content,
            ":video_url"   => $video_url,
            ":lesson_order" => $lesson_order
        ];

        $this->lessonModel->update($data);

        // Chuyển hướng về danh sách bài học của khóa học
        header("Location: ?controllers=LessonController&action=viewLessonsByCourse&id=" . $course_id);
        exit;
    }



    //LESSON CỦA HỌC VIÊN
    public function viewLessonOfStudent()
    {
        // Lấy course_id từ GET
        $course_id = $_GET['course_id'] ?? null;

        if (!$course_id) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=student&action=my_courses");
            exit();
        }

        // Lấy thông tin khóa học
        $course = $this->courseModel->getById($course_id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header("Location: ?views=student&action=my_courses");
            exit();
        }
        // Lấy danh sách bài học
        $lessons = $this->lessonModel->getLessonsByCourse($course_id)->fetchAll(PDO::FETCH_ASSOC);

        // lấy enrolment để lấy tiến độ khóa học
        $enrollment = $this->enrollmentModel->getEnrollmentByCourseId($course_id);

        // lấy giảng viên
        $instructor = $this->userModel->getUserById($course['instructor_id']);

        $_SESSION['enrollment'] = $enrollment;
        $_SESSION['lessons'] = $lessons;
        $_SESSION['course'] = $course;
        $_SESSION['instructor'] = $instructor;


        // Gửi tới view
        header("Location: ?views=student&action=course_of_lession");
    }
}
