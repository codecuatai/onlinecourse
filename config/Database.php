<?php


// Thông tin kết nối của bạn
const _HOST = "localhost:";
const _DB = "onlinecourse";
const _USER = "root";
const _PASS = "";
const _DRIVER = "mysql";


// Tắt debug trong môi trường sản phẩm
const _DEBUG = true;

class Database
{
    private $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            if (!class_exists("PDO")) {
                throw new Exception("Lỗi: Extension PDO không được bật trong PHP.");
            }

            $option = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $dsn = _DRIVER . ':host=' . _HOST . ";dbname=" . _DB;

            // Tạo kết nối PDO
            $this->conn = new PDO($dsn, _USER, _PASS, $option);

            // Không nên echo 'kết nối thành công' ở đây, vì đây là lớp nền tảng

        } catch (Exception $ex) {
            if (_DEBUG) {
                echo 'Lỗi kết nối CSDL: ' . $ex->getMessage();
            } else {
                echo 'Hệ thống đang bảo trì. Vui lòng thử lại sau.';
            }
            exit();
        }
        return $this->conn;
    }
}
