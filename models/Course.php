<?php
require_once __DIR__ . '/../config/Database.php';
class Course
{
    private $conn;
    private $table = "courses";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả khóa học theo giảng viên
    public function getCoursesByInstructor($instructor_id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE instructor_id = :instructor_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(":instructor_id", $instructor_id);
        $stmt->execute();
        return $stmt;
    }

    // Lấy thông tin khóa học theo id
    public function getCourseById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo khóa học
    public function create($data)
    {
        $sql = "INSERT INTO " . $this->table . "
                (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at)
                VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật khóa học
    public function update($data)
    {
        $sql = "UPDATE " . $this->table . "
                SET title = :title, description = :description, category_id = :category_id,
                    price = :price, duration_weeks = :duration_weeks, level = :level,
                    image = :image, updated_at = NOW()
                WHERE id = :id AND instructor_id = :instructor_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa khóa học
    public function delete($id, $instructor_id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id AND instructor_id = :instructor_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":instructor_id", $instructor_id);
        return $stmt->execute();
    }

    // lấy toàn bộ khóa học
    public function getAll()
    {
        $sql = "SELECT 
                    courses.*, 
                    users.fullname AS instructor_name,
                    categories.name AS category_name
                FROM courses
                JOIN users ON courses.instructor_id = users.id
                JOIN categories ON courses.category_id = categories.id
                ORDER BY courses.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt; // trả về danh sách để controller dùng
    }

    //Tìm kiếm khóa học theo tên
    public function search($keyword)
    {
        $sql = "SELECT 
                courses.*, 
                users.fullname AS instructor_name,
                categories.name AS category_name
            FROM courses
            JOIN users ON courses.instructor_id = users.id
            JOIN categories ON courses.category_id = categories.id
            WHERE courses.title LIKE :keyword
            ORDER BY courses.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $keyword = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();

        return $stmt;
    }

    // ✅ LẤY THÔNG TIN CHI TIẾT 1 KHÓA HỌC
    public function getById($id)
    {
        $sql = "SELECT 
                courses.*, 
                users.fullname AS instructor_name,
                categories.name AS category_name
            FROM courses
            JOIN users ON courses.instructor_id = users.id
            JOIN categories ON courses.category_id = categories.id
            WHERE courses.id = :id
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ XEM CHI TIẾT KHÓA HỌC
    public function detail()
    {
        $id = $_GET['id'];
        $course = $this->courseModel->getById($id);
        require_once __DIR__ . '/../views/courses/detail.php';
    }
}
