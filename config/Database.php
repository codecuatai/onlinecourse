<?php
const _HOST = "localhost";
const _DB = "onlinecourse";
const _USER = "root";
const _PASS = "";
const _DRIVER = "mysql";

const _DEBUG = true;

try {
    if (class_exists("PDO")) {
        $option = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $dsn = _DRIVER . ':host=' . _HOST . ";dbname=" . _DB;
        $conn = new PDO($dsn, _USER, _PASS, $option);
        echo 'kết nối thành công';
    }
} catch (Exception $ex) {
    echo 'Lỗi kết nối ' . $ex->getMessage();
}
