<?php
// models/User.php

// Đường dẫn tương đối từ models/ ra config/
// Giữ lại cách dùng __DIR__ để đảm bảo đường dẫn tuyệt đối (an toàn hơn)
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $conn;
    private $table = 'users'; // Giữ lại tên biến ngắn gọn 'table'

    // Khởi tạo kết nối CSDL trong constructor
    // Giữ lại cách khởi tạo tự động trong constructor (từ nhánh Duong)
    public function __construct()
    {
        // Lấy đối tượng kết nối PDO đã được cấu hình
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Tìm kiếm người dùng dựa trên username hoặc email (Dùng cho Đăng nhập).
     * @param string $identifier Tên đăng nhập hoặc email.
     * @return array|false Thông tin người dùng dưới dạng mảng kết hợp hoặc false nếu không tìm thấy.
     */
    public function findUserByIdentifier($identifier)
    {
        // Giữ lại câu query và logic làm sạch data từ nhánh Duong, thêm password
        $query = "SELECT id, username, email, password, fullname, role 
                  FROM " . $this->table . " 
                  WHERE username = :identifier OR email = :identifier 
                  LIMIT 1"; // Đổi LIMIT 0,1 thành LIMIT 1 (hiệu quả hơn)

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
    public function isExist($username, $email)
    {
        // Giữ lại logic của nhánh Duong
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE username = :username OR email = :email 
                  LIMIT 1";

        try {
            $stmt = $this->conn->prepare($query);

            // Làm sạch dữ liệu
            $username = htmlspecialchars(strip_tags($username));
            $email = htmlspecialchars(strip_tags($email));

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Trả về true nếu có dòng dữ liệu (người dùng đã tồn tại)
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
             // Xử lý lỗi CSDL nếu cần thiết
             return false;
        }
    }

    /**
     * Tạo người dùng mới (chức năng đăng ký).
     * @param array $data Dữ liệu người dùng (bao gồm username, email, password, fullname).
     * @return bool True nếu tạo thành công, False nếu thất bại.
     */
    public function createUser(array $data)
    {
        // Lấy và băm mật khẩu (Giữ lại PASSWORD_BCRYPT/PASSWORD_DEFAULT là an toàn)
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $phone_number = $data['phone_number'] ?? NULL;               // Dữ liệu bạn gửi là NULL
        $avatar = $data['avatar'] ?? 'default_avatar.jpg';           // Dùng 'avatar' (sau khi sửa CSDL)
        $status = $data['status'] ?? 1;
        // Giữ lại query của nhánh Duong, thêm created_at
        $query = "INSERT INTO " . $this->table . " 
              (username, email, password, fullname, role, phone_number, avatar, status, created_at) 
              VALUES (:username, :email, :password, :fullname, :role, :phone_number, :avatar, :status, NOW())";

        $stmt = $this->conn->prepare($query);

        // Chuẩn bị và làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($data['username']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        // Đặt role mặc định nếu không được truyền vào, hoặc lấy từ data nếu có
        $role = (int)($data['role'] ?? 0); 

        // Ràng buộc tham số (Binding Parameters)
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); 
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT); // Ràng buộc kiểu dữ liệu số nguyên

        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);

        // Thực thi truy vấn
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Hiển thị lỗi nghiêm trọng (chỉ trong môi trường phát triển)
            echo "<h2>LỖI NGHIÊM TRỌNG KHI GHI VÀO CSDL</h2>";
            echo "Chi tiết lỗi PDO: " . $e->getMessage();
            exit; 
        }
    }

    /**
     * Xác thực mật khẩu sử dụng hàm băm (Static Method tiện ích).
     * @param string $inputPassword Mật khẩu người dùng nhập vào.
     * @param string $hashedPassword Mật khẩu đã hash được lưu trong CSDL.
     * @return bool True nếu mật khẩu khớp, False nếu không.
     */
    public static function verifyPassword($inputPassword, $hashedPassword)
    {
        return password_verify($inputPassword, $hashedPassword);
    }
    
    // Lấy danh sách tất cả người dùng (dành cho Admin)
    public function getAllUsers()
    {
        $query = "SELECT id, username, email, fullname, role, status, created_at FROM " . $this->table . " ORDER BY created_at DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            return [];
        }
    }


    // Cập nhật vai trò (role) của người dùng
    public function updateRole($user_id, $new_role)
    {
        // Giữ lại logic và query của nhánh HEAD
        $query = "UPDATE " . $this->table . " SET role = :role WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':role', $new_role, PDO::PARAM_INT);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

        public function getById($id)
    {
        $query = "SELECT id, username, email, password, fullname, role, status, created_at 
                  FROM " . $this->table . " 
                  WHERE id = :id 
                  LIMIT 1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Cập nhật thông tin user (fullname, email)
     */
    public function updateUser($id, array $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET fullname = :fullname, email = :email 
                  WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);

            $fullname = htmlspecialchars(strip_tags($data['fullname']));
            $email    = htmlspecialchars(strip_tags($data['email']));

            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
            
        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Cập nhật mật khẩu user
     */
    public function updatePassword($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE " . $this->table . " 
                  SET password = :password 
                  WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashed);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Xóa người dùng
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Cập nhật trạng thái user (active = 1, inactive = 0)
     */
    public function setStatus($id, $status)
    {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Tìm kiếm user theo tên, username hoặc email
     */
    public function searchUsers($keyword)
    {
        $query = "SELECT id, username, email, fullname, role, status, created_at
                  FROM " . $this->table . "
                  WHERE username LIKE :kw 
                     OR fullname LIKE :kw 
                     OR email LIKE :kw
                  ORDER BY created_at DESC";

        try {
            $stmt = $this->conn->prepare($query);

            $keyword = "%" . $keyword . "%";
            $stmt->bindParam(':kw', $keyword);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

        /**
     * Wrapper cho Admin: cập nhật fullname, email và role
     * (Tương thích với AdminController.updateUser($id, $fullname, $email, $role))
     */
    public function updateUserAdmin($id, $fullname, $email, $role)
    {
        $query = "UPDATE " . $this->table . " 
                  SET fullname = :fullname, email = :email, role = :role
                  WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);

            $fullname = htmlspecialchars(strip_tags($fullname));
            $email    = htmlspecialchars(strip_tags($email));
            $role     = (int)$role;

            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Toggle lock / unlock user bằng cột `status`
     * Nếu status = 1 (active) -> set 0 (locked/inactive) và ngược lại
     */
    public function toggleLockUser($id)
    {
        try {
            // Lấy trạng thái hiện tại
            $user = $this->getById($id);
            if (!$user) return false;

            $newStatus = ($user['status'] == 1) ? 0 : 1;

            $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Reset mật khẩu (hash rồi lưu)
     */
    public function resetPassword($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashed);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    
}
?>