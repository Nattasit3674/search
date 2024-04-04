<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>
<body>
    

<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// กำหนดค่าการเชื่อมต่อฐานข้อมูล MySQL
$servername = "172.18.2.23";
$username = "admin_sat";
$password = "7MPlJPZ68v";
$dbname = "admin_sat";

// เชื่อมต่อกับฐานข้อมูล MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// กำหนดตัวแปรสำหรับเก็บที่อยู่ไฟล์ที่จะอัปโหลด
$target_dir = "uploadfile/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ Excel หรือไม่
if($imageFileType != "xlsx" && $imageFileType != "xls") {
    echo "Sorry, only Excel files are allowed.";
    $uploadOk = 0;
}

// ตรวจสอบว่าไฟล์มีอยู่หรือไม่
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// จำกัดขนาดของไฟล์
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// อนุญาตเฉพาะส่วนขยายของไฟล์
if($imageFileType != "xlsx" && $imageFileType != "xls") {
    echo "Sorry, only Excel files are allowed.";
    $uploadOk = 0;
}

// ตรวจสอบสถานะการอัปโหลด
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// อัปโหลดไฟล์
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        // อ่านข้อมูลจากไฟล์ Excel
        $inputFileName = $target_file;
        $reader = new Xlsx();
        $spreadsheet = $reader->load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Truncate ข้อมูลในตารางก่อน
        $truncateSql = "TRUNCATE TABLE employees_test";
        if ($conn->query($truncateSql) === TRUE) {
            echo "Table truncated successfully.";
        } else {
            echo "Error truncating table: " . $conn->error;
        }

        // แทรกข้อมูลลงในฐานข้อมูล MySQL
        $success = true;
        foreach ($sheetData as $row) {
            $sql = "INSERT INTO employees_test (`Title (TH)`, `Name (TH)`, `Title (ENG)`, `Name (ENG)`, `Position`, `Provider ID`, `Has CA`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssi", $row['A'], $row['B'], $row['C'], $row['D'], $row['E'], $row['F'], $row['G']);
                if (!$stmt->execute()) {
                    $success = false;
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Error: Unable to prepare SQL statement.";
            }
        }

        if ($success) {

            ?>
            <script>
                Swal.fire({
                icon: "success",
                title: "เพิ่มไฟล์สำเร็จ",
                showConfirmButton: true,
                confirmButtonText: "OK",
                allowOutsideClick: false // Prevent dismissing by clicking outside
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = "index.html";
                }
            });
            </script>
            <?php
            
        }
        
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// ปิดการเชื่อมต่อ MySQL
$conn->close();
?>
</body>
</html>