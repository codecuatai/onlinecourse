<?php

// Đảm bảo file Database.php được load để có kết nối CSDL
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        // Lấy đối tượng kết nối PDO đã được cấu hình
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Tìm kiếm người dùng dựa trên username hoặc email.
     * Phương thức này được dùng cho cả đăng nhập và validation.
     * @param string $identifier Tên đăng nhập hoặc email.
     * @return array|false Thông tin người dùng dưới dạng mảng kết hợp hoặc false nếu không tìm thấy.
     */
    public function findUserByIdentifier($identifier) {
        $query = "SELECT id, username, email, password, fullname, role 
                  FROM " . $this->table . " 
                  WHERE username = :identifier OR email = :identifier 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu trước khi ràng buộc tham số
        $identifier = htmlspecialchars(strip_tags($identifier));
        
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Kiểm tra xem username hoặc email đã tồn tại trong CSDL chưa (dùng cho validation đăng ký).
     * @param string $username Tên đăng nhập.
     * @param string $email Địa chỉ email.
     * @return bool True nếu đã tồn tại, False nếu chưa.
     */
    public function isExist($username, $email) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE username = :username OR email = :email 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Tạo người dùng mới (chức năng đăng ký).
     * @param array $data Dữ liệu người dùng (bao gồm username, email, password, fullname, role).
     * @return bool True nếu tạo thành công, False nếu thất bại.
     */
    public function createUser(array $data) {
        // Lấy và băm mật khẩu
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
        
        $query = "INSERT INTO " . $this->table . " (username, email, password, fullname, role, created_at) 
                  VALUES (:username, :email, :password, :fullname, :role, NOW())";

        $stmt = $this->conn->prepare($query);

        // Chuẩn bị và làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($data['username']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        $role = (int)$data['role']; // Chuyển role sang số nguyên

        // Ràng buộc tham số (Binding Parameters)
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); 
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT); // Ràng buộc kiểu dữ liệu số nguyên

        // Thực thi truy vấn
    try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // *******************************
            // * 2. SỬA ĐỔI ĐỂ HIỂN THỊ LỖI *
            // *******************************
            echo "<h2>LỖI NGHIÊM TRỌNG KHI GHI VÀO CSDL</h2>";
            echo "Chi tiết lỗi PDO: " . $e->getMessage();
            exit; // Dừng lại để xem lỗi SQL
            // return false; // Giữ lại lệnh này nếu không muốn hiển thị lỗi
        }
    }

    /**
     * Xác thực mật khẩu sử dụng hàm băm.
     * @param string $inputPassword Mật khẩu người dùng nhập vào.
     * @param string $hashedPassword Mật khẩu đã hash được lưu trong CSDL.
     * @return bool True nếu mật khẩu khớp, False nếu không.
     */
    public static function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }
    
    // Thêm các phương thức CRUD khác tại đây (updateUser, deleteUser, getAllUsers...)
}

?>