<?php
// เชื่อมต่อ Navicat
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
if(isset($_GET['query']) && !empty($_GET['query'])) {
    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // รับคำค้นหาจากแบบฟอร์ม
    $query = $_GET['query'];

    // ค้นหาข้อมูลในฐานข้อมูล
    $sql = "SELECT * FROM `employees` WHERE `Name (TH)` LIKE '%$query%'";
    $result = $conn->query($sql);

    // แสดงข้อมูล
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo " ชื่อ : " . $row["Name (TH)"]. "<br>";
        }
    } else {
        echo "ท่านอาจเคยลงทะเบียน Health ID (หมอพร้อม)
        แต่ท่านยังไม่ได้ลงทะเบียน Provider ID<br>
        ท่านสามารถลงทะเบียนได้ด้วยตนเอง
        ที่เว็บไซต์ <a href='https://provider.id.th'>ProviderID</a>
        ตามคู่มือนี้<br><a target='blank' href='http://localhost/search/pdf/การลงทะเบียน Provider_ID ด้วยแอพหมอพร้อม.pdf'>การลงทะเบียน Provider_ID ด้วยแอพหมอพร้อม</a>
        <br><a target='blank' href='http://localhost/search/pdf/คู่มือการลงทะเบียน Provider ID ด้วยแอพ THAID.pdf'>คู่มือการลงทะเบียน Provider ID ด้วยแอพ THAID</a>
        <br><br><img src='http://localhost/search/pdf/S__3186712.jpg' width='600' height='900'>";
    }
    $conn->close();
} else {
    echo "กรุณาป้อนคำค้นหา";
}
?>