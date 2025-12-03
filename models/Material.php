<?php
class Material
{
    private $conn;
    private $table = "materials";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Thêm tài liệu mới
     * @param array $data ['lesson_id', 'filename', 'file_path', 'file_type']
     * @return bool
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (lesson_id, filename, file_path, file_type, uploaded_at)
                VALUES (:lesson_id, :filename, :file_path, :file_type, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':lesson_id', $data['lesson_id']);
        $stmt->bindParam(':filename', $data['filename']);
        $stmt->bindParam(':file_path', $data['file_path']);
        $stmt->bindParam(':file_type', $data['file_type']);
        return $stmt->execute();
    }

    /**
     * Lấy tất cả tài liệu theo lesson_id
     * @param int $lesson_id
     * @return array
     */
    public function getByLesson($lesson_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE lesson_id = :lesson_id ORDER BY uploaded_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy 1 tài liệu theo ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật thông tin tài liệu
     * @param int $id
     * @param array $data ['filename', 'file_path', 'file_type']
     * @return bool
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                    filename = :filename, 
                    file_path = :file_path, 
                    file_type = :file_type
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':filename', $data['filename']);
        $stmt->bindParam(':file_path', $data['file_path']);
        $stmt->bindParam(':file_type', $data['file_type']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Xóa tài liệu
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Kiểm tra loại file hợp lệ
     * @param string $file_type
     * @return bool
     */
    public static function isValidFileType($file_type)
    {
        $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
        return in_array(strtolower($file_type), $allowed);
    }
}
