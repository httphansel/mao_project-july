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
?>