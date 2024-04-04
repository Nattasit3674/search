<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
header("Content-type:application/json; charset=UTF-8");
if ($_SESSION['username'] !== 'admin') {
    echo json_encode("เปิดใช้งานเฉพาะ ADMIN เจ้าพระยาอภัยภูเบศรเท่านั้น");
    exit();
}

require_once "./cpawebsite/sqlconfig/config.php";
error_reporting(0);
$successData = [];
$errorData = [];

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod === 'POST') {
    try {
        // Check if file is uploaded successfully
        if (isset($_FILES["fileToUpload"]["tmp_name"]) && $_FILES["fileToUpload"]["tmp_name"] != '') {
            // Load the Excel file
            $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

            // Get the first worksheet
            $worksheet = $spreadsheet->getActiveSheet();
            // Define field mappings (Excel column => database column)
            $fieldMappings = array(
                'A' => 'accdate',
                'B' => 'type',
                'C' => 'status',
                'D' => 'plan',
                'E' => 'pi',
                'F' => 'po',
                'G' => 'sendno',
                'H' => 'senddate',
                'I' => 'getdate',
                'J' => 'taxid',
                'K' => 'taxname',
                'L' => 'price',
                'M' => 'ba',
                'N' => 'bb',
                'O' => 'bc',
                'P' => 'bd',
            );
            $sql = "TRUNCATE TABLE finance_outstanding_creditors";
            $con->query($sql);
            $cc = 0;
            $ccSuccess = 0;
            $errorData = 0;
            foreach ($worksheet->getRowIterator(2) as $row) {
                $cc += 1;
                $rowData = array();
                foreach ($row->getCellIterator() as $cell) {
                    $column = $cell->getColumn();
                    if (isset($fieldMappings[$column])) {
                        $value = $cell->getValue();
                        // Check if the value is a date
                        if ($cell->getDataType() == \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC) {
                            if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                                $value = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value));
                            }
                        }
                        $rowData[$fieldMappings[$column]] = $value;
                    }
                }

                // Prepare SQL query
                $sql = "INSERT INTO finance_outstanding_creditors (";
                $sql .= implode(", ", array_keys($rowData));
                $sql .= ") VALUES ('";
                $sql .= implode("', '", $rowData);
                $sql .= "')";

                // Execute SQL query
                if ($con->query($sql) === true) {
                    $ccSuccess += 1;
                } else {
                    $ccError += 1;
                    array_push($errorData, $con->error);
                }
            }

            $response = array(
                'code' => 200,
                'status' => false,
                'message' => "ok",
                'data' => array(
                    "Clear_Old_Data" => "Success",
                    "Success" => $ccSuccess,
                    "Error" => $ccError,
                    "Import_Error" => $errorData,
                ),
            );
            http_response_code(200);
            echo json_encode($response);
        } else {
            // $response->success(400, true, "Error: File not uploaded.");
            // exit();
        }
    } catch (\Throwable $th) {
        $response = array(
            'code' => 400,
            'status' => false,
            'message' => $th->getMessage(),
            'data' => []
        );
        http_response_code(400);
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'code' => 405,
        'status' => false,
        'message' => "Error :Merhods Not allows!!",
        'data' => []
    );
    http_response_code(405);
    echo json_encode($response);
}