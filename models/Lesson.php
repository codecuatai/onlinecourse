<?php
class Lesson {
    private $conn;
    private $table = "lessons";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách bài học của khóa học
    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE course_id = :course_id ORDER BY `order` ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->execute();
        return $stmt;
    }

    // Lấy bài học theo id
    public function getLessonById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo bài học mới
    public function create($data) {
        $sql = "INSERT INTO " . $this->table . "
                (course_id, title, content, video_url, `order`, created_at)
                VALUES (:course_id, :title, :content, :video_url, :order, NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật bài học
    public function update($data) {
        $sql = "UPDATE " . $this->table . "
                SET title = :title, content = :content, 
                    video_url = :video_url, `order` = :order
                WHERE id = :id AND course_id = :course_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa bài học
    public function delete($id, $course_id) {
        $sql = "DELETE FROM " . $this->table . " 
                WHERE id = :id AND course_id = :course_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":course_id", $course_id);
        return $stmt->execute();
    }
}
