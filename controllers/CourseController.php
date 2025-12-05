// Trong controllers/CourseController.php

class CourseController {
    private $courseModel;

    public function __construct($db) {
        // Khởi tạo đối tượng Model
        $this->courseModel = new Course($db);
    }

    public function create() {
        // Kiểm tra quyền: Chỉ Giảng viên (role = 1) hoặc Admin (role = 2) được phép [cite: 28, 100]
        // if ($_SESSION['user_role'] < 1) { header('Location: /login'); exit; } 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy dữ liệu từ POST
            $data = $_POST;
            $data['instructor_id'] = $_SESSION['user_id']; // Lấy từ session người dùng đang đăng nhập

            // 2. Validate dữ liệu đầu vào (cần thực hiện chi tiết hơn)
            if (empty($data['title']) || empty($data['description'])) {
                $error = "Vui lòng điền đầy đủ tiêu đề và mô tả.";
                // Tải lại View với thông báo lỗi
                include 'views/instructor/course/create.php';
                return;
            }

            // 3. Xử lý Upload file ảnh bìa (cần code logic upload file vào assets/uploads/courses) [cite: 39, 71]
            $data['image'] = $this->handleImageUpload($_FILES['course_image']);

            // 4. Gọi Model để lưu vào CSDL
            if ($this->courseModel->createCourse($data)) {
                // Thành công: Chuyển hướng đến trang quản lý khóa học
                header('Location: /instructor/courses/manage');
                exit;
            } else {
                $error = "Lỗi tạo khóa học. Vui lòng thử lại.";
            }
        }
        
        // Tải View form tạo khóa học
        include 'views/instructor/course/create.php';
    }

    private function handleImageUpload($file) {
        // Logic xử lý upload file ảnh vào assets/uploads/courses/ [cite: 71, 98]
        // Ví dụ: kiểm tra kích thước, loại tệp, đổi tên file và trả về đường dẫn
        return 'default.jpg'; 
    }
}


// Trong controllers/CourseController.php

public function edit($course_id) {
    // 1. Kiểm tra quyền và Giảng viên sở hữu khóa học [cite: 100]
    // ...

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý CẬP NHẬT dữ liệu (logic tương tự như create, nhưng gọi updateCourse)
        $data = $_POST;
        $data['instructor_id'] = $_SESSION['user_id'];
        
        // Xử lý ảnh (giữ ảnh cũ nếu không có ảnh mới)
        if (!empty($_FILES['course_image']['name'])) {
             $data['image'] = $this->handleImageUpload($_FILES['course_image']);
        } else {
             $data['image'] = $data['current_image']; // Giữ ảnh hiện tại
        }

        if ($this->courseModel->updateCourse($course_id, $data)) {
            header('Location: /instructor/courses/manage');
            exit;
        } else {
            $error = "Lỗi cập nhật khóa học. Hoặc bạn không có quyền chỉnh sửa.";
        }
    }

    // Lấy dữ liệu khóa học hiện tại để hiển thị trên form
    $course = $this->courseModel->getCourseById($course_id);
    
    if (!$course) {
        // Xử lý lỗi không tìm thấy
        header('Location: /404');
        exit;
    }
    
    // Tải View form chỉnh sửa khóa học với dữ liệu $course
    include 'views/instructor/course/edit.php';
}