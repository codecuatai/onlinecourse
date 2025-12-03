<?php
const _HOST = "localhost:3307";
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

function getALL($sql)
{
    global $conn;
    $stm = $conn->prepare($sql); // bảo về câu lệnh SQL khỏi SQL injection

    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getOne($sql)
{
    global $conn;
    $stm = $conn->prepare($sql); // bảo về câu lệnh SQL khỏi SQL injection
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getRows($sql)
{
    global $conn;
    $stm = $conn->prepare($sql); // bảo về câu lệnh SQL khỏi SQL injection
    $stm->execute();
    $result = $stm->rowCount();
    return $result;
}

function insert($table, $data)
{
    global $conn;
    $keys = array_keys($data);

    $cot = implode(',', $keys);
    $place = ':' . implode(',:', $keys);

    $sql = "INSERT INTO $table ($cot) values ($place)";
    $stm = $conn->prepare($sql);

    $rel = $stm->execute($data);
    return $rel;
}

function update($table, $data, $condition = '')
{
    global $conn;
    $update = '';

    foreach ($data as $key => $value) {
        $update .= $key . '=:' . $key . ',';
    }
    $update = trim($update, ',');

    if (!empty($condition)) {
        $sql = "UPDATE $table SET $update where $condition";
    } else {
        $sql = "UPDATE $table SET $update";
    }

    $stm = $conn->prepare($sql);

    $rel = $stm->execute($data);
    return $rel;
}

function delete($table, $condition = '')
{
    global $conn;
    if (!empty($condition)) {
        $sql = "DELETE from $table where $condition";
    } else {
        $sql = "DELETE from $table";
    }

    $stm = $conn->prepare($sql);
    $rel = $stm->execute();
    return $rel;
}
