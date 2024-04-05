<?php
session_start();

// ตรวจสอบว่ามีการส่งข้อมูล fig code มาหรือไม่
if(isset($_POST['fig_code'])) {
    // รับค่า fig code ที่ผู้ใช้ป้อนเข้ามา
    $entered_fig_code = $_POST['fig_code'];

    // เปรียบเทียบกับรหัส fig ที่ถูกต้อง
    $correct_fig_code = "admin1234";

    // ตรวจสอบว่า fig code ที่ผู้ใช้ป้อนเข้ามาถูกต้องหรือไม่
    if($entered_fig_code === $correct_fig_code) {
        // เก็บค่า fig code ใน Session
        $_SESSION['fig_code'] = $entered_fig_code;
        
        // ถ้าถูกต้อง redirect ไปยังหน้าสำหรับการ login สำเร็จ
        header("Location: upload_file");
        exit(); // ออกจากการประมวลผล PHP
    } else {
        // ถ้าไม่ถูกต้องแสดงข้อความว่า fig code ไม่ถูกต้อง
        echo "Fig code is incorrect.";
    }
}
?>
