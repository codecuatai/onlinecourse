<?php
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/User.php';

class MaterialController
{
    private $materialModel;
    private $lessonModel;
    private $courseModel;
    private $userModel;

    public function __construct()
    {
        $this->materialModel = new Material();
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
        $this->userModel = new User();
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

        // Lấy tất cả bài học của khóa học
        $stmtLessons = $this->lessonModel->getLessonsByCourse($course_id);
        $lessons = $stmtLessons->fetchAll(PDO::FETCH_ASSOC); // chuyển PDOStatement sang mảng

        // Lấy thông tin khóa học
        $course = $this->courseModel->getCourseById($course_id);

        // Lưu dữ liệu vào session hoặc trực tiếp sang view
        $_SESSION['materials'] = $materials;
        $_SESSION['lessons'] = $lessons;
        $_SESSION['course'] = $course;


        header("Location: ?views=instructor&instructor=materials&action=manage");
        exit;
    }


    public function viewCreateMaterial()
    {
        // Kiểm tra course_id
        if (!isset($_GET['course_id'])) {
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
            $course_id = $_POST['course_id'] ?? null;
            $lesson_id = $_POST['lesson_id'] ?? null;
            $title = trim($_POST['title'] ?? '');
            $file = $_FILES['file'] ?? null;

            if (!$course_id || !$lesson_id || !$file || $file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Vui lòng chọn khóa học, bài học và tệp hợp lệ.";
                header("Location: ?views=instructor&instructor=materials&action=create&course_id=$course_id");
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
                header("Location: ?views=instructor&instructor=materials&action=create&course_id=$course_id");
                exit;
            }

            // Chuẩn bị dữ liệu để lưu vào database
            $data = [
                'course_id'   => $course_id,
                'lesson_id'   => $lesson_id,
                'filename'    => $title ?: $file['name'], // dùng tên do user nhập, nếu trống thì lấy tên file
                'file_path'   => 'assets/uploads/materials/' . $fileName,
                'file_type'   => pathinfo($file['name'], PATHINFO_EXTENSION),
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Gọi model để thêm tài liệu
            if ($this->materialModel->create($data)) {
                $_SESSION['success'] = "Tải tài liệu thành công!";
            } else {
                $_SESSION['error'] = "Thêm tài liệu thất bại!";
            }

            // Chuyển hướng về trang quản lý tài liệu của khóa học
            header("Location: ?controllers=MaterialController&action=viewMaterials&course_id=$course_id");
            exit;
        }

        // Nếu không phải POST, hiển thị form tạo mới
        $course_id = $_GET['course_id'] ?? 0;
        $lessons = $this->lessonModel->getLessonsByCourse($course_id)->fetchAll(PDO::FETCH_ASSOC);
        require_once _PATH_URL . '/../views/instructor/materials/create.php';
    }



    // Xóa tài liệu
    public function deleteMaterial()
    {
        if (!isset($_GET['material_id']) || !isset($_GET['course_id'])) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?views=instructor&instructor=courses&action=manage");
            exit;
        }

        $material_id = (int)$_GET['material_id'];
        $course_id = (int)$_GET['course_id'];

        // Gọi model xóa tài liệu
        $this->materialModel->delete($material_id);

        // Chuyển hướng về trang quản lý tài liệu của khóa học
        header("Location: ?controllers=MaterialController&action=viewMaterials&course_id=" . $course_id);
        exit;
    }


    public function viewEditMaterial()
    {
        // Kiểm tra tham số
        if (!isset($_GET['material_id']) || !isset($_GET['course_id'])) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            header("Location: ?views=instructor&instructor=courses&action=manage");
            exit;
        }

        $material_id = (int)$_GET['material_id'];
        $course_id = (int)$_GET['course_id'];

        // Lấy thông tin tài liệu từ model
        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            $_SESSION['error'] = "Tài liệu không tồn tại!";
            header("Location: ?views=instructor&instructor=materials&action=manage&course_id=$course_id");
            exit;
        }

        // Lấy danh sách bài học của khóa học
        $lessons = $this->lessonModel->getLessonsByCourse($course_id)->fetchAll(PDO::FETCH_ASSOC);

        // Truyền dữ liệu sang view
        require_once _PATH_URL . '/../views/instructor/materials/edit.php';
    }



    public function updateMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $material_id = $_POST['material_id'] ?? null;
            $lesson_id = $_POST['lesson_id'] ?? null;
            $course_id = $_POST['course_id'] ?? null;
            $filename = $_POST['title'] ?? null;
            $file_type = $_POST['type'] ?? null;

            if (!$material_id || !$lesson_id || !$course_id || !$filename || !$file_type) {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
                header("Location: javascript:history.back()");
                exit;
            }

            // Lấy file cũ
            $material = $this->materialModel->getMaterialById($material_id);
            if (!$material) {
                $_SESSION['error'] = "Tài liệu không tồn tại!";
                header("Location: javascript:history.back()");
                exit;
            }

            // Nếu có file mới tải lên
            $file_path = $material['file_path'];
            if (!empty($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = _PATH_URL . '/../assets/uploads/materials/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileNameNew = time() . "_" . basename($_FILES['file']['name']);
                $filePathNew = $uploadDir . $fileNameNew;

                if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePathNew)) {
                    $_SESSION['error'] = "Không thể tải file lên server.";
                    header("Location: javascript:history.back()");
                    exit;
                }

                $file_path = 'assets/uploads/materials/' . $fileNameNew;
                $file_type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            }

            // Dữ liệu để cập nhật
            $data = [
                'lesson_id'   => $lesson_id,
                'course_id'   => $course_id,
                'filename'    => $filename,
                'file_path'   => $file_path,
                'file_type'   => $file_type,
                'uploaded_at' => date('Y-m-d H:i:s'),
                'id'          => $material_id
            ];

            if ($this->materialModel->update($data)) {
                $_SESSION['success'] = "Cập nhật tài liệu thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật tài liệu thất bại!";
            }

            header("Location: ?controllers=MaterialController&action=viewMaterials&course_id=" . $course_id);
            exit;
        }

        // Nếu không phải POST, hiển thị form
        $material_id = $_GET['material_id'] ?? 0;
        $material = $this->materialModel->getMaterialById($material_id);
        $lessons = $this->lessonModel->getLessonsByCourse($_GET['course_id'] ?? 0);
        $course_id = $_GET['course_id'] ?? 0;

        require_once _PATH_URL . '/../views/instructor/materials/edit.php';
    }


    public function viewMaterialOfStudent()
    {
        // Lấy course_id từ GET
        $course_id = $_GET['course_id'] ?? null;

        if (!$course_id) {
            $_SESSION['error'] = "Không tìm thấy khóa học!";
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            exit();
        }

        // Lấy thông tin khóa học
        $course = $this->courseModel->getById($course_id);
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header("Location: ?controllers=CourseController&action=viewCoursesOfInstructor");
            exit();
        }

        // Lấy thông tin giảng viên
        $instructor = $this->userModel->getUserById($course['instructor_id']);

        // Lấy danh sách tài liệu của khóa học
        $materials = $this->materialModel->getMaterialsAndLessonsByCourse($course_id);

        // lưu vào sesson
        $_SESSION['course'] = $course;
        $_SESSION['instructor'] = $instructor;
        $_SESSION['materials'] = $materials;
        // Load view
        header("Location: ?views=student&action=course_of_material");
    }
}
