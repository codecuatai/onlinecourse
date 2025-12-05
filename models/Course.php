// Trong models/Course.php
<php?
class Course {
    private $db;

    public function __construct($db) {
        $this->db = $db; // Đối tượng kết nối CSDL (PDO)
    }

    public function createCourse($data) {
        // SQL Injection Prevention (Sử dụng prepared statement) 
        $sql = "INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at, updated_at) 
                VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        // Gán các giá trị từ $data vào statement
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':duration_weeks', $data['duration_weeks']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':image', $data['image']);

        return $stmt->execute(); // Trả về true/false
    }
    // ... các phương thức khác
}


// Trong models/Course.php

public function updateCourse($id, $data) {
    // Chỉ cập nhật các trường được phép
    $sql = "UPDATE courses SET title = :title, description = :description, 
            category_id = :category_id, price = :price, duration_weeks = :duration_weeks, 
            level = :level, image = :image, updated_at = NOW() 
            WHERE id = :id AND instructor_id = :instructor_id"; // Đảm bảo chỉ Giảng viên tạo mới sửa được
    
    $stmt = $this->db->prepare($sql);
    
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':instructor_id', $data['instructor_id']); // Kiểm tra quyền truy cập [cite: 100]
    // Gán các giá trị khác...
    
    return $stmt->execute();
}

public function getCourseById($id) {
    $sql = "SELECT * FROM courses WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>