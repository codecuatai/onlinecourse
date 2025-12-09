<?php
class Material {
    private $conn;
    private $table = "materials";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByLesson($lesson_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE lesson_id = :lesson_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":lesson_id", $lesson_id);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $sql = "INSERT INTO " . $this->table . "
                (lesson_id, filename, file_path, file_type, uploaded_at)
                VALUES (:lesson_id, :filename, :file_path, :file_type, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getFileById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>