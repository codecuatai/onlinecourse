<?php
class LessonController {

    private $db;
    private $lessonModel;
    private $materialModel;

    public function __construct($db) {
        session_start();

        // Chỉ cho phép giảng viên
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        include_once "models/Lesson.php";
        include_once "models/Material.php";
        $this->db = $db;
        $this->lessonModel = new Lesson($db);
        $this->materialModel = new Material($db);
    }

    // Quản lý bài học theo khóa học
    public function manage() {
        if (!isset($_GET["course_id"])) {
            header("Location: index.php?controller=course&action=manage");
            exit;
        }

        $course_id = $_GET["course_id"];
        $stmt = $this->lessonModel->getLessonsByCourse($course_id);
        $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "views/instructor/lessons/manage.php";
    }

    // Hiển thị form tạo bài học
    public function create() {
        $course_id = $_GET["course_id"] ?? null;
        include "views/instructor/lessons/create.php";
    }

    // Lưu bài học mới
    public function store() {
        if (empty($_POST['title'])) {
            $_SESSION['error'] = "Vui lòng nhập tiêu đề!";
            header("Location: index.php?controller=lesson&action=create&course_id=".$_POST['course_id']);
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

        header("Location: index.php?controller=lesson&action=manage&course_id=".$_POST["course_id"]);
    }

    // Hiển thị form sửa bài học
    public function edit() {
        $id = $_GET["id"];
        $lesson = $this->lessonModel->getLessonById($id);
        include "views/instructor/lessons/edit.php";
    }

    // Lưu cập nhật
    public function update() {
        $data = [
            ":id" => $_POST["id"],
            ":course_id" => $_POST["course_id"],
            ":title" => $_POST["title"],
            ":content" => $_POST["content"],
            ":video_url" => $_POST["video_url"],
            ":lesson_order" => $_POST["lesson_order"]
        ];

        $this->lessonModel->update($data);

        header("Location: index.php?controller=lesson&action=manage&course_id=".$_POST["course_id"]);
    }

    // Xóa bài học
    public function delete() {
        $id = $_GET["id"];
        $course_id = $_GET["course_id"];

        $this->lessonModel->delete($id, $course_id);

        header("Location: index.php?controller=lesson&action=manage&course_id=$course_id");
    }


// ================= MATERIAL FUNCTIONS ================= //

    // Form upload tài liệu
    public function uploadMaterial() {
        $lesson_id = $_GET['lesson_id'];
        include "views/instructor/materials/upload.php";
    }

    // Xử lý upload
    public function storeMaterial() {
        $lesson_id = $_POST['lesson_id'];

        if (!empty($_FILES['material']['name'])) {

            // đặt tên file tránh trùng
            $file_name = time() . "_" . $_FILES['material']['name']; 
            $file_tmp = $_FILES['material']['tmp_name'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

            $uploadPath = "assets/uploads/materials/" . $file_name;

            // tạo thư mục nếu chưa có
            if (!is_dir("assets/uploads/materials/")) {
                mkdir("assets/uploads/materials/", 0777, true);
            }

            move_uploaded_file($file_tmp, $uploadPath);

            $data = [
                ":lesson_id" => $lesson_id,
                ":filename" => $file_name,
                ":file_path" => $uploadPath,
                ":file_type" => $file_type,
            ];

            $this->materialModel->create($data);
        }

        header("Location: index.php?controller=lesson&action=edit&id=" . $lesson_id);
    }

    // Xóa tài liệu
    public function deleteMaterial() {
        $id = $_GET["id"];

        $file = $this->materialModel->getFileById($id);

        if ($file && file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }

        $this->materialModel->delete($id);

        header("Location: index.php?controller=lesson&action=edit&id=" . $file['lesson_id']);
    }
}