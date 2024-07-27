<?php 
    require '../config/condb.php';
    session_start();

    $distribution_id = $_GET['distribution_id'];

    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['off_id'];
    $user_name = $_SESSION['user_name'];

    $approveRequest = "UPDATE tech_inventory SET `distribution_status` = 'Approved' WHERE distribution_id = '$distribution_id' ";
    $approveResult = mysqli_query($conn, $approveRequest);

    if($approveResult){
        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
        VALUES ('$ttime', '$user_name', 'Approved a Requested Item', 'Admin', '$tech_id')";
        $account_logResult = mysqli_query($conn, $account_logQuery);
        if ($account_logResult) {
            $_SESSION['message'] = "Item Distributed Successfully!";
            $_SESSION['icon'] = "success";
            header("Location: ../pages/page.php?page=distributed");
            exit();
        }
    }else{
        $_SESSION['message'] = "There was an error distributing items";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php?page=distributed");
        exit();
    }
?>