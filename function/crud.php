<?php 
    require '../config/condb.php';

    session_start();
    
    if (isset($_POST['addInventoryBtn'])) {
        date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['off_id'];
        $user_name = $_SESSION['user_name'];

        $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
        $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
        $quantity_type = mysqli_real_escape_string($conn, $_POST['quantity_type']);
        $item_variety = mysqli_real_escape_string($conn, $_POST['item_variety']);
        $item_category = mysqli_real_escape_string($conn, $_POST['item_category']);
        $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);
    
        $addInventoryQuery = "INSERT INTO inventory (item_name, item_quantity, quantity_type, item_variety, item_category, exp_date)
        VALUES ('$item_name', '$item_quantity', '$quantity_type', '$item_variety', '$item_category', '$exp_date')";
        $addInventoryResult = mysqli_query($conn, $addInventoryQuery);
    
        if ($addInventoryResult) {
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$user_name', 'Added New Inventory Item', 'Admin', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if($account_logResult){
                $_SESSION['message'] = "Item Added Successfully!";
                $_SESSION['icon'] = "success";
                header("Location: ../pages/page.php?page=inventory");
                exit();
            }
        }else{
            $_SESSION['message'] = "Error Adding Item!";
            $_SESSION['icon'] = "error";
            header("Location: ../pages/page.php?page=inventory");
            exit();
        }
        }

    if(isset($_POST['updateInventoryBtn'])){
        date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['off_id'];
        $user_name = $_SESSION['user_name'];

        $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
        $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
        $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
        $quantity_type = mysqli_real_escape_string($conn, $_POST['quantity_type']);
        $item_variety = mysqli_real_escape_string($conn, $_POST['item_variety']);
        $item_category = mysqli_real_escape_string($conn, $_POST['item_category']);
        $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);

        $updateInventoryQuery = "UPDATE `inventory` SET `item_name`='$item_name',`item_variety`='$item_variety',`item_quantity`='$item_quantity',`quantity_type`='$quantity_type',`item_category`='$item_category',`exp_date`='$exp_date' 
        WHERE item_id = '$item_id' ";
        $updateInventoryResult = mysqli_query($conn, $updateInventoryQuery);
    
        if ($updateInventoryResult) {
            $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$user_name', 'Updated Inventory Item', 'Admin', '$tech_id')";
            $account_logResult = mysqli_query($conn, $account_logQuery);
            if($account_logResult){
                $_SESSION['message'] = "Item Updated Successfully!";
                $_SESSION['icon'] = "success";
                header("Location: ../pages/page.php?page=inventory");
                exit();
            }
        }else{
            $_SESSION['message'] = "Error Updating Item!";
            $_SESSION['icon'] = "error";
            header("Location: ../pages/page.php?page=inventory");
            exit();
        }
    }
?>