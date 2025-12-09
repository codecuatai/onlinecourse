<?php
class Lesson
{
    private $conn;
    private $table = 'lessons'; // Giữ lại tên biến ngắn gọn 'table'

    // Khởi tạo kết nối CSDL trong constructor
    // Giữ lại cách khởi tạo tự động trong constructor (từ nhánh Duong)
    public function __construct()
    {
        // Lấy đối tượng kết nối PDO đã được cấu hình
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    // Lấy danh sách bài học của khóa học
    public function getLessonsByCourse($course_id)
    {
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE course_id = :course_id ORDER BY lesson_order ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->execute();
        return $stmt;
    }

    // Lấy một bài học theo id
    public function getLessonById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm bài học mới
    public function create($data)
    {
        $sql = "INSERT INTO " . $this->table . "
                (course_id, title, content, video_url, lesson_order)
                VALUES (:course_id, :title, :content, :video_url, :lesson_order)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật bài học
    public function update($data)
    {
        $sql = "UPDATE " . $this->table . "
                SET title = :title, content = :content,
                    video_url = :video_url, lesson_order = :lesson_order
                WHERE id = :id AND course_id = :course_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa bài học
    public function delete($id, $course_id)
    {
        $sql = "DELETE FROM " . $this->table . " 
                WHERE id = :id AND course_id = :course_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":course_id", $course_id);
        return $stmt->execute();
    }
}
