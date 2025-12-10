<?php
class Material
{
    private $conn;
    private $table = "materials";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả materials theo lesson_id
    public function getMaterialsByCourse($course_id)
    {
        $sql = "SELECT m.* 
            FROM materials AS m
            INNER JOIN lessons AS l ON m.lesson_id = l.id
            WHERE l.course_id = :course_id
            ORDER BY m.uploaded_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Thêm tài liệu mới
    public function create($data)
    {
        $sql = "INSERT INTO " . $this->table . " (lesson_id, filename, file_path, file_type, uploaded_at)
                VALUES (:lesson_id, :filename, :file_path, :file_type, :uploaded_at)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa tài liệu
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
