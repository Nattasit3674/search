<?php
$servername = "172.18.2.23";
$username = "admin_sat";
$password = "7MPlJPZ68v";
$dbname = "admin_sat";

if(isset($_POST["truncate"])) {
    // เชื่อมต่อกับฐานข้อมูล
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ส่งคำสั่ง SQL สำหรับ Truncate ไฟล์
    $sql = "TRUNCATE TABLE your_table_name"; // แทน your_table_name ด้วยชื่อตารางที่ต้องการ Truncate
    if ($conn->query($sql) === TRUE) {
        echo "File truncated successfully.";
    } else {
        echo "Error truncating file: " . $conn->error;
    }

    $conn->close();
}
?>
