<?php
$servername = "172.18.2.23";
$username = "admin_sat";
$password = "7MPlJPZ68v";
$dbname = "admin_sat";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>