<?php
require 'PHPExcel/IOFactory.php';

// MySQL database connection
$host = "172.18.2.23";
$username = "admin_sat";
$password = "7MPlJPZ68v";
$database = "admin_sat";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Excel file path
$excelFile = 'uploadfile/โรงพยาบาลเจ้าพระยาอภัยภูเบศร (6).xlsx';

// Load Excel file
$objPHPExcel = PHPExcel_IOFactory::load($excelFile);

// Assume data starts from the second row (header in the first row)
$worksheet = $objPHPExcel->getActiveSheet();
$highestRow = $worksheet->getHighestRow();
$highestColumn = $worksheet->getHighestColumn();

// Loop through each row of the worksheet
for ($row = 2; $row <= $highestRow; $row++) {
    // Get row data
    $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

    // Insert data into MySQL database
    $sql = "INSERT INTO employees_test (Title (TH), Name (TH), Title (ENG), Name (ENG)) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ssss", $rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3]);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

echo "Data imported successfully from Excel to MySQL.";
?>