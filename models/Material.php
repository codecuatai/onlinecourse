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

    /**
     * Lấy thông tin chi tiết một tài liệu theo material_id
     *
     * @param int $id
     * @return array|false Trả về mảng thông tin tài liệu hoặc false nếu không tìm thấy
     */
    public function getMaterialById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Thêm tài liệu mới
    // Thêm tài liệu mới
    public function create($data)
    {
        $sql = "INSERT INTO " . $this->table . " 
            (course_id, lesson_id, filename, file_path, file_type, uploaded_at)
            VALUES (:course_id, :lesson_id, :filename, :file_path, :file_type, :uploaded_at)";
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


    // Material.php
    // Cập nhật tài liệu
    public function update($data)
    {
        $sql = "UPDATE " . $this->table . " SET 
                lesson_id = :lesson_id,
                course_id = :course_id,
                filename = :filename,
                file_path = :file_path,
                file_type = :file_type,
                uploaded_at = :uploaded_at
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }


    public function getMaterialsAndLessonsByCourse($course_id)
    {
        $sql = "SELECT m.* ,l.*
            FROM materials AS m
            INNER JOIN lessons AS l ON m.lesson_id = l.id
            WHERE l.course_id = :course_id
            ORDER BY m.uploaded_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
