<?php
require '../../config/condb.php';
session_start();
// technician function ito

// task funtion dito
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['tech_id'];
    $technician = $_SESSION['user_name'];

    $taskDoneQuery = "UPDATE technician_task SET `task_status` = '1' WHERE task_id = '$task_id' ";
    $taskDoneResult = mysqli_query($conn, $taskDoneQuery);

    if ($taskDoneResult) {

        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$technician', 'Task Done', 'Technician', '$tech_id')";
        $account_logResult = mysqli_query($conn, $account_logQuery);

        if ($account_logResult) {
            $_SESSION['message'] = "Task Done!";
            $_SESSION['icon'] = "success";
            header("Location: ../page.php?page=dashboard");
            exit();
        }
    } else {
        $_SESSION['message'] = "Unable to perform task.";
        $_SESSION['icon'] = "error";
        header("Location: ../page.php?page=dashboard");
        exit();
    }
}

//request item
if(isset($_POST['requestItemBtn'])){
    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['tech_id'];
    $technician = $_SESSION['user_name'];

    $cluster_id = $_SESSION['cluster_id'];
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
    $distribution_status = 'Requested';

    $getAdminItem = "SELECT * FROM inventory WHERE item_name = '$item_name' ";
    $getAdminItemResult = mysqli_query($conn, $getAdminItem);

    if($getAdminItemResult->num_rows>0){
        while($adminItems = $getAdminItemResult->fetch_assoc()){
            $newItemQuantity = $adminItems['item_quantity'] - $item_quantity;

            $updateAdminInventory = "UPDATE inventory SET item_quantity = '$newItemQuantity' WHERE item_name = '$item_name' ";
            $updateAdminInventoryResult = mysqli_query($conn, $updateAdminInventory);

            if($updateAdminInventoryResult){
                $requestItemQuery = "INSERT INTO tech_inventory (item_name, item_quantity, cluster_id, distribution_status)
                VALUES ('$item_name', '$item_quantity', '$cluster_id', '$distribution_status')";
                $requestItemResult = mysqli_query($conn, $requestItemQuery);

                if($requestItemResult){
                    $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                    VALUES ('$ttime', '$technician', 'Requested an Item', 'Technician', '$tech_id')";
                    $account_logResult = mysqli_query($conn, $account_logQuery);

                    if ($account_logResult) {
                        $_SESSION['message'] = "Requested Item Successfully!";
                        $_SESSION['icon'] = "success";
                        header("Location: ../page.php?page=inventory");
                        exit();
                    }
                }
            }
        }
    }
}

//register a farmer
if(isset($_POST['registerFarmerBtn'])){
    // Function to generate a unique farmer code
    function generateFarmerCode()
    {
        $prefix = 'FR2024';
        $numbers = '0123456789';

        $randomString = $prefix;

        for ($i = 0; $i < 6; $i++) {
            $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
        }

        return $randomString;
    }

    // Generate a unique farmer code
    $farmer_code = generateFarmerCode();

    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['tech_id'];
    $technician = $_SESSION['user_name'];

    $farmer_fname = mysqli_real_escape_string($conn, $_POST['farmer_fname']);
    $farmer_mname = mysqli_real_escape_string($conn, $_POST['farmer_mname']);
    $farmer_lname = mysqli_real_escape_string($conn, $_POST['farmer_lname']);
    $farmer_extname = mysqli_real_escape_string($conn, $_POST['farmer_extname']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $addFarmerQuery = "INSERT INTO farmer (farmer_code, farmer_fname, farmer_mname, farmer_lname, farmer_extname, birthday, age, sex, barangay, phone_number, tech_id)
    VALUES ('$farmer_code', '$farmer_fname', '$farmer_mname', '$farmer_lname', '$farmer_extname', '$birthday', '$age', '$sex', '$barangay', '$phone_number', '$tech_id')";

    try {
        $addFarmerResult = mysqli_query($conn, $addFarmerQuery);

        if($addFarmerResult){
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                            VALUES ('$ttime', '$technician', 'Registered a Farmer', 'Technician', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if ($account_logResult) {
                $_SESSION['message'] = "Registered Farmer Successfully!";
                $_SESSION['icon'] = "success";
                header("Location: ../page.php?page=farmer");
                exit();
            }
        } else {
            throw new Exception("Cannot Add Farmer");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['icon'] = "error";
        header("Location: ../page.php?page=farmer");
        exit();
    }
}

//resident registration
if(isset($_POST['registerResidentBtn'])){
        function generateResidentCode($conn) {
        $prefix = 'RS2024';
        $numbers = '0123456789';
        do {
            $randomString = $prefix;
            for ($i = 0; $i < 6; $i++) {
                $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
            }
            $resident_code = $randomString;

            // Check if the generated resident code already exists
            $query = "SELECT * FROM resident WHERE resident_code = '$resident_code'";
            $result = mysqli_query($conn, $query);
        } while(mysqli_num_rows($result) > 0);

        return $resident_code;
    }

    // Generate a unique resident code
    $resident_code = generateResidentCode($conn);

    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['tech_id'];
    $technician = $_SESSION['user_name'];

    $resident_fname = mysqli_real_escape_string($conn, $_POST['resident_fname']);
    $resident_mname = mysqli_real_escape_string($conn, $_POST['resident_mname']);
    $resident_lname = mysqli_real_escape_string($conn, $_POST['resident_lname']);
    $resident_extname = mysqli_real_escape_string($conn, $_POST['resident_extname']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);

    $addResidentQuery = "INSERT INTO resident (resident_code, resident_fname, resident_mname, resident_lname, resident_extname, birthday, age, sex, barangay, tech_id)
    VALUES ('$resident_code', '$resident_fname', '$resident_mname', '$resident_lname', '$resident_extname', '$birthday', '$age', '$sex', '$barangay', '$tech_id')";

    try {
        $addResidentResult = mysqli_query($conn, $addResidentQuery);

        if($addResidentResult){
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                            VALUES ('$ttime', '$technician', 'Registered a Resident', 'Technician', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if ($account_logResult) {
                $_SESSION['message'] = "Resident Registered Successfully!";
                $_SESSION['icon'] = "success";
                header("Location: ../page.php?page=resident");
                exit();
            }
        } else {
            throw new Exception("Cannot Add Resident");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['icon'] = "error";
        header("Location: ../page.php?page=resident");
        exit();
    }
}

?>