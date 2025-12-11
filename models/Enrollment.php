<?php
require_once __DIR__ . '/../config/Database.php';
class Enrollment
{
    private $conn;
    private $table = "enrollments";

    public function __construct()
    {
        // Lấy đối tượng kết nối PDO đã được cấu hình
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    // ✅ KIỂM TRA HỌC VIÊN ĐÃ ĐĂNG KÝ KHÓA HỌC CHƯA
    public function isEnrolled($course_id, $student_id)
    {
        $sql = "SELECT id 
                FROM enrollments 
                WHERE course_id = :course_id 
                  AND student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // ✅ ĐĂNG KÝ KHÓA HỌC
    public function enroll($course_id, $student_id)
    {
        $sql = "INSERT INTO enrollments
                (course_id, student_id, enrolled_date, status, progress)
                VALUES (:course_id, :student_id, NOW(), 'active', 0)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->bindParam(":student_id", $student_id);

        return $stmt->execute();
    }

    // ✅ LẤY DANH SÁCH KHÓA HỌC HỌC VIÊN ĐÃ ĐĂNG KÝ
    public function getMyCourses($student_id)
    {
        $sql = "SELECT 
                    courses.*, 
                    enrollments.progress,
                    enrollments.status,
                    users.fullname as instructor_name,
                    categories.name as category_name
                FROM enrollments
                JOIN courses ON enrollments.course_id = courses.id
                JOIN users ON courses.instructor_id = users.id
                JOIN categories ON categories.id = courses.category_id
                WHERE enrollments.student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }


    // ✅ LẤY DANH SÁCH HỌC VIÊN ĐĂNG KÝ THEO course_id
    public function getEnrollmentByCourseId($course_id)
    {
        $sql = "SELECT 
                enrollments.*, 
                users.fullname AS student_name,
                users.email AS student_email
            FROM enrollments
            JOIN users ON enrollments.student_id = users.id
            WHERE enrollments.course_id = :course_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createEnrollmentForStudent($course_id, $student_id, $status, $progress)
    {
        $sql = "INSERT INTO enrollments 
            (course_id, student_id, enrolled_date, status, progress)
            VALUES (:course_id, :student_id, NOW(), :status, :progress)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":course_id", $course_id);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":progress", $progress);

        return $stmt->execute();
    }

    public function deleteEnrollment($enrollment_id)
    {
        $sql = "DELETE FROM enrollments WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $enrollment_id, PDO::PARAM_INT);

        return $stmt->execute();  // Trả về true/false
    }


    public function getEnrollmentById($id)
    {
        $sql = "SELECT e.*, u.fullname AS student_name, u.email AS student_email, u.username as username
            FROM enrollments e
            JOIN users u ON e.student_id = u.id
            WHERE e.id = :id
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateEnrollment($id, $status, $progress)
    {
        $sql = "UPDATE enrollments 
            SET status = :status, progress = :progress
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':progress', $progress, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
