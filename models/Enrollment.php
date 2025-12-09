<?php
class Enrollment
{
    private $conn;
    private $table = "enrollments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ✅ KIỂM TRA HỌC VIÊN ĐÃ ĐĂNG KÝ KHÓA HỌC CHƯA
    public function isEnrolled($course_id, $student_id)
    {
        $sql = "SELECT id 
                FROM enrollments 
                WHERE course_id = :course_id 
                  AND student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":course_id", (int)$course_id, PDO::PARAM_INT);
        $stmt->bindValue(":student_id", (int)$student_id, PDO::PARAM_INT);
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
        $stmt->bindValue(":course_id", (int)$course_id, PDO::PARAM_INT);
        $stmt->bindValue(":student_id", (int)$student_id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    // ✅ LẤY DANH SÁCH KHÓA HỌC HỌC VIÊN ĐÃ ĐĂNG KÝ
    public function getMyCourses($student_id)
    {
        $sql = "SELECT 
                    courses.*, 
                    enrollments.progress,
                    enrollments.status
                FROM enrollments
                JOIN courses ON enrollments.course_id = courses.id
                WHERE enrollments.student_id = :student_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":student_id", (int)$student_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
