<?php
// models/User.php

// Đường dẫn tương đối từ models/ ra config/
require_once '../config/Database.php'; 

class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db; // $db lúc này là đối tượng PDO
    }

    // [Chức năng Đăng ký] - Kiểm tra tồn tại bằng PDO
    public function isExist($username, $email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username OR email = :email LIMIT 1";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Trả về true nếu có dòng dữ liệu (người dùng đã tồn tại)
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Xử lý hoặc ghi log lỗi CSDL
            return false;
        }
    }

    // [Chức năng Đăng ký] - Tạo người dùng mới bằng PDO
    public function create($username, $email, $password, $fullname) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " 
                  (username, email, password, fullname, role) 
                  VALUES (:username, :email, :password, :fullname, :role)";
        
        $role = 0; // Mặc định là Học viên

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password); // Đã hash
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Xử lý lỗi CSDL (ví dụ: ghi log)
            return false;
        }
    }

    // [Chức năng Đăng nhập] - Tìm người dùng bằng username/email bằng PDO
    public function findByUsername($username) {
        $query = "SELECT id, username, password, fullname, role FROM " . $this->table_name . " WHERE username = :username OR email = :username LIMIT 1";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            // Thiết lập chế độ fetch là trả về mảng kết hợp
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            return $stmt->fetch(); // Trả về mảng dữ liệu người dùng hoặc false
        } catch (PDOException $e) {
            // Xử lý lỗi CSDL
            return false;
        }
    }
}
?>