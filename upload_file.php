<?php
session_start();

// ตรวจสอบว่ามี session ของผู้ใช้และ fig code ตรงกับค่าที่กำหนด
if (!isset($_SESSION['fig_code']) || $_SESSION['fig_code'] !== 'admin1234') {
    // ถ้าไม่ตรงกับเงื่อนไข ให้เด้งกลับไปที่หน้า index.php
    header("Location: index");
    exit(); // ออกจากการทำงานของสคริปต์
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            text-align: center;
        }
        input[type="file"] {
            display: block;
            margin: 0 auto 20px;
            padding: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>


    <div class="container">
        <h2>Upload an Excel File</h2>
        <form action="upload_excel" method="post" enctype="multipart/form-data" id="uploadForm">
            หมายเหตุ : ชื่อบุคลากรต้องอยู่ใน Column B <br><br>
            Select Excel file to upload:<br>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="submit">
        </form>
    </div>
</body>
</html>
