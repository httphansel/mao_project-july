<?php
require '../config/condb.php';
session_start();

require '../vendor/autoload.php'; // Include PHPWord library

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//good standing generator
if (isset($_POST['good_standingBtn'])) {
            date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['off_id'];
        $user_name = $_SESSION['user_name'];
    // Fetch and sanitize inputs
    $document_client = mysqli_real_escape_string($conn, $_POST['document_client']);
    $document_description = mysqli_real_escape_string($conn, $_POST['document_description']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $issuance_date = date('d F Y');

    // Calculate expiration date
    $currentDate = new DateTime();
    $currentDate->modify('+6 months');
    $exp_date = $currentDate->format('d F Y');

    // Load the template
    $templatePath = realpath('../assets/template/goodstanding_template.docx');
    if (!$templatePath) {
        $_SESSION['message'] = 'Template not found.';
        $_SESSION['icon'] = 'error';
        header("Location: ../index.php?page=goodstanding");
        exit();
    }

    $templateProcessor = new TemplateProcessor($templatePath);

    // Replace placeholders with dynamic content
    $templateProcessor->setValue('{client_name}', $document_client);
    $templateProcessor->setValue('{description}', $document_description);
    $templateProcessor->setValue('{barangay}', $barangay);
    $templateProcessor->setValue('{issue_date}', $issuance_date);
    $templateProcessor->setValue('{exp_date}', $exp_date);


    // Save the modified document on the server
    $outputFilePath = '../generated/' . $document_client . '_goodstanding.docx';
    $templateProcessor->saveAs($outputFilePath);

    // Ensure the file is saved before attempting to download it
    if (file_exists($outputFilePath)) {
        // Save the data to the database
        $saveQuery = "INSERT INTO document_data (document_type, document_client, document_description, barangay) 
        VALUES ('GOOD STANDING', '$document_client', '$document_description', '$barangay')";
        $saveResult = mysqli_query($conn, $saveQuery);

        if ($saveResult) {
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$user_name', 'Generated Good Standing Certificate', 'Admin', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if($account_logResult){
            
            // Set session message for successful transaction
            $_SESSION['message'] = 'Document Generated Successfully!';
            $_SESSION['icon'] = 'success';

            // Download the generated document
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . basename($outputFilePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($outputFilePath));

            readfile($outputFilePath);

            // Optionally, remove the generated file from the server
            unlink($outputFilePath);
            exit();
            }
    } else {
        $_SESSION['message'] = 'Failed to generate document.';
        $_SESSION['icon'] = 'error';
        header("Location: ../pages/page.php?page=certificates");
        exit();
    }
}
}
//asf free generator
if (isset($_POST['asf_freeBtn'])) {
            date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['off_id'];
        $user_name = $_SESSION['user_name'];
    // Fetch and sanitize inputs
    $document_client = mysqli_real_escape_string($conn, $_POST['document_client']);
    $farm_name = mysqli_real_escape_string($conn, $_POST['farm_name']);
    $dateToday = date('d F Y');

    // Load the template
    $templatePath = realpath('../assets/template/asffree_template.docx');
    if (!$templatePath) {
        $_SESSION['message'] = 'Template not found.';
        $_SESSION['icon'] = 'error';
        header("Location: ../pages/page.php?page=certificates");
        exit();
    }

    $templateProcessor = new TemplateProcessor($templatePath);

    // Replace placeholders with dynamic content
    $templateProcessor->setValue('{NAME}', $document_client);
    $templateProcessor->setValue('{farm}', $farm_name);
    $templateProcessor->setValue('{DATE}', $dateToday);

    // Save the modified document on the server
    $outputFilePath = '../generated/' . $document_client . '_asffree.docx';
    $templateProcessor->saveAs($outputFilePath);

    // Ensure the file is saved before attempting to download it
    if (file_exists($outputFilePath)) {
        // Save the data to the database
        $saveQuery = "INSERT INTO document_data (document_type, document_client, farm_name) 
                      VALUES ('ASF-FREE', '$document_client', '$farm_name')";
        $saveResult = mysqli_query($conn, $saveQuery);

        if ($saveResult) {
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$user_name', 'Generated ASF-FREE Certificate', 'Admin', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if($account_logResult){
            
            // Set session message for successful transaction
            $_SESSION['message'] = 'Document Generated Successfully!';
            $_SESSION['icon'] = 'success';

            // Download the generated document
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . basename($outputFilePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($outputFilePath));

            readfile($outputFilePath);

            // Optionally, remove the generated file from the server
            unlink($outputFilePath);
            exit();
            }
        } else {
            $_SESSION['message'] = 'Failed to save document data.';
            $_SESSION['icon'] = 'error';
            header("Location: ../pages/page.php?page=certificates");
            exit();
        }
    } else {
        $_SESSION['message'] = 'Failed to generate document.';
        $_SESSION['icon'] = 'error';
        header("Location: ../pages/page.php?page=certificates");
        exit();
    }
}
//loan format generator
if (isset($_POST['loan_formatBtn'])) {
            date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['off_id'];
        $user_name = $_SESSION['user_name'];
    // Fetch and sanitize inputs
    $document_client = mysqli_real_escape_string($conn, $_POST['document_client']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $document_description = mysqli_real_escape_string($conn, $_POST['document_description']);
    $dateToday = date('F j, Y');

    require '../vendor/autoload.php'; // Include PHPWord library

    // Load the template
    $templatePath = realpath('../assets/template/loanformat_template.docx');
    if (!$templatePath) {
        $_SESSION['message'] = 'Template not found.';
        $_SESSION['icon'] = 'error';
        header("Location: ../pages/page.php?page=certificates");
        exit();
    }

    $templateProcessor = new TemplateProcessor($templatePath);

    // Replace placeholders with dynamic content
    $templateProcessor->setValue('{NAME}', $document_client);
    $templateProcessor->setValue('{BARANGAY}', $barangay);
    $templateProcessor->setValue('{DESCRIPTION}', $document_description);
    $templateProcessor->setValue('{DATE}', $dateToday);

    // Save the modified document on the server
    $outputFilePath = '../generated/' . $document_client . '_loanformat.docx';
    $templateProcessor->saveAs($outputFilePath);

    // Ensure the file is saved before attempting to download it
    if (file_exists($outputFilePath)) {
        // Save the data to the database
        $saveQuery = "INSERT INTO document_data (document_type, document_client, barangay, document_description) 
                      VALUES ('LOAN FORMAT', '$document_client', '$barangay', '$document_description')";
        $saveResult = mysqli_query($conn, $saveQuery);

        if ($saveResult) {
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$user_name', 'Generated Loan Format Certificate', 'Admin', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if($account_logResult){
            
            // Set session message for successful transaction
            $_SESSION['message'] = 'Document Generated Successfully!';
            $_SESSION['icon'] = 'success';

            // Download the generated document
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . basename($outputFilePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($outputFilePath));

            readfile($outputFilePath);

            // Optionally, remove the generated file from the server
            unlink($outputFilePath);
            exit();
            }
        } else {
            $_SESSION['message'] = 'Failed to save document data.';
            $_SESSION['icon'] = 'error';
            header("Location: ../pages/page.php?page=certificates");
            exit();
        }
    } else {
        $_SESSION['message'] = 'Failed to generate document.';
        $_SESSION['icon'] = 'error';
        header("Location: ../pages/page.php?page=certificates");
        exit();
    }
}
//generate monthly report
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generateExcelBtn'])) {
    // Retrieve start and end dates from the form
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);

    // Your SQL query to fetch data within the specified date range
    $monthReportQuery = "SELECT
                            'Register Farmer' AS description, f.farmer_code AS item_id, CONCAT(f.farmer_fname, ' ', f.farmer_mname, ' ', f.farmer_lname) AS item_name, f.reg_date AS item_date
                        FROM farmer f
                        WHERE f.reg_date BETWEEN '$startDate' AND '$endDate'
                        UNION ALL
                        SELECT
                            'Added Item in Inventory' AS description, i.item_id, i.item_name, i.date_added
                        FROM inventory i
                        WHERE i.date_added BETWEEN '$startDate' AND '$endDate'
                        UNION ALL
                        SELECT
                            'Registered Livestock' AS description, ls.livestock_id, ls.livestock_type, ls.reg_date
                        FROM livestock ls
                        WHERE ls.reg_date BETWEEN '$startDate' AND '$endDate'
                        UNION ALL
                        SELECT
                            'Registered Pet' AS description, p.pet_id, CONCAT(p.pet_name, ' - ', p.pet_breed) AS item_name, p.reg_date
                        FROM pet p
                        WHERE p.reg_date BETWEEN '$startDate' AND '$endDate'
                        UNION ALL
                        SELECT
                            'Item Distributed' AS description, id.distribution_id, CONCAT(id.item_name, ' - ', id.item_quantity) AS item_name, id.distribution_date
                        FROM tech_inventory id
                        WHERE id.distribution_date BETWEEN '$startDate' AND '$endDate'
                        UNION ALL
                        SELECT
                            'Generated Document' AS description, dd.document_id, CONCAT(dd.document_type, ' - ', dd.document_client) AS item_name, dd.document_date
                        FROM document_data dd
                        WHERE dd.document_date BETWEEN '$startDate' AND '$endDate'";

    $monthReportResult = mysqli_query($conn, $monthReportQuery);

    // Initialize PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $sheet->setCellValue('A1', 'Description');
    $sheet->setCellValue('B1', 'ID');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Date');

    // Populate data from database
    $row = 2;
    while ($monthReport = $monthReportResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $monthReport['description']);
        $sheet->setCellValue('B' . $row, $monthReport['item_id']);
        $sheet->setCellValue('C' . $row, $monthReport['item_name']);
        $sheet->setCellValue('D' . $row, $monthReport['item_date']);
        $row++;
    }

    // Set headers for download
    $fileName = 'MonthReport_'. $startDate .'to'. $endDate .'.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    // Save Excel file to output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    // Handle invalid requests or direct access
    echo 'Invalid request';
}
