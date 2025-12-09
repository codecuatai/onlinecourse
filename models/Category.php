<?php

class Category
{
    private $conn;
    private $table = "categories";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /* ========================= CREATE ========================= */
    public function createCategory(array $data)
    {
        $sql = "INSERT INTO {$this->table} (name, description, created_at)
                VALUES (:name, :description, NOW())";

        $stmt = $this->conn->prepare($sql);

        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi tạo category: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= UPDATE ========================= */
    public function updateCategory(int $id, array $data)
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, description = :description
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi cập nhật category: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= DELETE ========================= */
    public function deleteCategory(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi xóa category: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= GET ALL ========================= */
    public function getAllCategories()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ========================= GET COURSES BY CATEGORY ========================= */
    public function getCoursesByCategory(int $categoryId)
    {
        $sql = "SELECT 
                    courses.*, 
                    users.fullname AS instructor_name, 
                    categories.name AS category_name
                FROM courses
                JOIN users ON courses.instructor_id = users.id
                JOIN categories ON courses.category_id = categories.id
                WHERE courses.category_id = :categoryId
                ORDER BY courses.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ========================= GET CATEGORY BY ID ========================= */
    public function getCategoryById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
