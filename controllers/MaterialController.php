<?php
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class MaterialController
{
    private $materialModel;
    private $lessonModel;
    private $courseModel;

    public function __construct()
    {
        $this->materialModel = new Material();
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
    }

    // Hiển thị tất cả tài liệu theo bài học
    public function viewMaterials()
    {
        // Kiểm tra course_id
        if (empty($_GET['course_id'])) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=instructor&instructor=courses&action=manage");
            exit;
        }

        $course_id = (int) $_GET['course_id']; // ép kiểu INT

        // Lấy tất cả tài liệu của khóa học
        $materials = $this->materialModel->getMaterialsByCourse($course_id);

        // Lấy tất cả bài học của khóa học (nếu cần dùng trong view create)
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);

        // Truyền dữ liệu sang view
        $course = $this->courseModel->getCourseById($course_id); // nếu bạn có phương thức lấy tên khóa học

        $_SESSION['materials'] = $materials;
        $_SESSION['lessons'] = $lessons;
        $_SESSION['course'] = $course;


        header("Location: ?views=instructor&instructor=materials&action=manage");
        exit;
    }



    public function viewCreateMaterial()
    {
        // Kiểm tra course_id
        if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?views=instructor&instructor=courses&action=manage");
            exit;
        }

        $course_id = (int) $_GET['course_id'];

        // Lấy danh sách tất cả bài học của khóa học
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);

        // Kiểm tra nếu chưa có bài học
        if (empty($lessons)) {
            $_SESSION['error'] = "Khóa học chưa có bài học nào. Vui lòng tạo bài học trước.";
            header("Location: ?views=instructor&instructor=courses&action=manage");
            exit;
        }

        // Truyền dữ liệu sang view
        require_once _PATH_URL . '/../views/instructor/materials/create.php';
    }



    public function createMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $lesson_id = $_POST['lesson_id'] ?? null;
            $file = $_FILES['file'] ?? null;

            if (!$lesson_id || !$file || $file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Vui lòng chọn bài học và tệp hợp lệ.";
                header("Location: ?views=instructor&instructor=materials&action=create");
                exit;
            }

            // Thư mục lưu file
            $uploadDir = _PATH_URL . '/../assets/uploads/materials/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Tạo tên file duy nhất
            $fileName = time() . "_" . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            // Di chuyển file lên server
            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                $_SESSION['error'] = "Không thể tải file lên server.";
                header("Location: ?views=instructor&instructor=materials&action=create");
                exit;
            }

            // Chuẩn bị dữ liệu để lưu vào database
            $data = [
                'lesson_id'   => $lesson_id,
                'filename'    => $file['name'], // tên gốc
                'file_path'   => 'assets/uploads/materials/' . $fileName, // đường dẫn để view sử dụng
                'file_type'   => pathinfo($file['name'], PATHINFO_EXTENSION),
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Gọi model để thêm tài liệu
            if ($this->materialModel->create($data)) {
                $_SESSION['success'] = "Tải tài liệu thành công!";
            } else {
                $_SESSION['error'] = "Thêm tài liệu thất bại!";
            }

            // Chuyển hướng về trang quản lý tài liệu của bài học
            header("Location: ?views=instructor&instructor=materials&action=manage&course_id=" . $_POST['course_id']);
            exit;
        }

        // Nếu không phải POST, hiển thị form tạo mới
        $lessons = $this->lessonModel->getLessonsByCourse($_GET['course_id'] ?? 0);
        require_once _PATH_URL . '/../views/instructor/materials/create.php';
    }


    // Xóa tài liệu
    public function deleteMaterial()
    {
        if (!isset($_GET['id']) || !isset($_GET['lesson_id'])) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?views=instructor&instructor=lessons&action=manage");
            exit;
        }

        $id = $_GET['id'];
        $lesson_id = $_GET['lesson_id'];

        $this->materialModel->delete($id);

        header("Location: ?controllers=MaterialController&action=viewMaterials&lesson_id=" . $lesson_id);
        exit;
    }
}
