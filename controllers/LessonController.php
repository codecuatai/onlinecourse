<?php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class LessonController
{
    private $lessonModel;
    private $courseModel;

    public function __construct()
    {
        // Khởi tạo Lesson Model để tương tác với CSDL
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
    }

    public function viewLessonsByCourse()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=instructor&instructor=courses&action=manage");
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
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=instructor&instructor=lessons&action=manage");
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
        // Xử lý upload video (nếu có)
        // ==========================
        $video_url = null;

        if (!empty($_FILES['video']['name'])) {
            $videoName = time() . "_" . basename($_FILES['video']['name']);
            $videoPath = "assets/uploads/videos/" . $videoName;

            move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);

            $video_url = $videoPath;
        }

        // ==========================
        // Xử lý upload document (nếu có)
        // ==========================
        $doc_url = null;

        if (!empty($_FILES['document']['name'])) {
            $docName = time() . "_" . basename($_FILES['document']['name']);
            $docPath = "assets/uploads/documents/" . $docName;

            move_uploaded_file($_FILES['document']['tmp_name'], $docPath);

            $doc_url = $docPath;
        }

        // ==========================
        // Dữ liệu insert
        // (Theo đúng model của bạn)
        // ==========================
        $data = [
            ":course_id"    => $course_id,
            ":title"        => $_POST['title'],
            ":content"      => $_POST['description'] ?? "",
            ":video_url"    => $video_url,
            ":lesson_order" => 1, // Mặc định = 1; hoặc bạn tự tính thứ tự
        ];

        header("Location: ?controllers=LessonController&action=viewLessonsByCourse");
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
    public function edit()
    {
        $id = $_GET["id"];
        $lesson = $this->lessonModel->getLessonById($id);
        include "views/instructor/lessons/edit.php";
    }

    // Lưu cập nhật
    public function update()
    {
        $data = [
            ":id" => $_POST["id"],
            ":course_id" => $_POST["course_id"],
            ":title" => $_POST["title"],
            ":content" => $_POST["content"],
            ":video_url" => $_POST["video_url"],
            ":lesson_order" => $_POST["lesson_order"]
        ];

        $this->lessonModel->update($data);

        header("Location: index.php?controller=lesson&action=manage&course_id=" . $_POST["course_id"]);
    }

    // Xóa bài học
    public function delete()
    {
        $id = $_GET["id"];
        $course_id = $_GET["course_id"];

        $this->lessonModel->delete($id, $course_id);

        header("Location: index.php?controller=lesson&action=manage&course_id=$course_id");
    }
}
