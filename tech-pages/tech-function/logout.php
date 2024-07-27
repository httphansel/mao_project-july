<?php 
    require '../../config/condb.php';

    if(isset($_GET['admin_id'])){
        date_default_timezone_set('Asia/Manila');
        $ddate = new DateTime();
        $new_ddate = $ddate->format('Y-m-d');
        $dday = $ddate->format('l');
        $ttime = $ddate->format('h:i a');
        $tech_id = $_SESSION['tech_id'];
        $adminuser_name = $_SESSION['user_name'];

    $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                            VALUES ('$ttime', '$adminuser_name', 'Log Out Account', 'Technician', '$tech_id')";
    $account_logResult = mysqli_query($conn, $account_logQuery);
    if ($account_logResult) {
        unset($_SESSION['tech_id']);
        header("Location: ../../index.php");
        exit();
    }
    }
?>