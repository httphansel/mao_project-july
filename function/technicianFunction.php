<?php 
    require '../config/condb.php';
    session_start();

// register tech function dito
if (isset($_POST['registerTechBtn'])) {
    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['off_id'];
    $adminuser_name = $_SESSION['user_name'];

    $tech_fname = mysqli_real_escape_string($conn, $_POST['tech_fname']);
    $tech_mname = mysqli_real_escape_string($conn, $_POST['tech_mname']);
    $tech_lname = mysqli_real_escape_string($conn, $_POST['tech_lname']);
    $tech_extname = mysqli_real_escape_string($conn, $_POST['tech_extname']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cluster_id = mysqli_real_escape_string($conn, $_POST['cluster_id']);

    if (isset($_FILES['user_pic']) && $_FILES['user_pic']['error'] == 0) {
        $user_pic = $_FILES['user_pic']['tmp_name'];
        $imgContent = addslashes(file_get_contents($user_pic));

        // Check file size (5MB limit)
        if ($_FILES['user_pic']['size'] > 5 * 1024 * 1024) {
            $_SESSION['message'] = "Error: File size exceeds 5MB limit.";
            $_SESSION['icon'] = "error";
            header("Location: ../index.php?page=technician");
            exit();
        }

        $registerTechQuery = "INSERT INTO mao_technician (tech_fname, tech_mname, tech_lname, tech_extname, birthday, age, sex, barangay, user_name, email, password, user_pic, cluster_id)
        VALUES ('$tech_fname', '$tech_mname', '$tech_lname', '$tech_extname', '$birthday', '$age', '$sex', '$barangay', '$user_name', '$email', '$password', '$imgContent', '$cluster_id')";
        $registerTechResult = mysqli_query($conn, $registerTechQuery);

        if ($registerTechResult) {
            $fetchTechQuery = "SELECT tech_id FROM mao_technician WHERE tech_fname = '$tech_fname' AND tech_lname = '$tech_lname' ";
            $fetchTechResult = mysqli_query($conn, $fetchTechQuery);

            if ($fetchTechResult->num_rows > 0) {
                while ($technician = $fetchTechResult->fetch_assoc()) {
                    $tech_id = $technician['tech_id'];
                    $updateClusterQuery = "UPDATE cluster SET `tech_id` = '$tech_id' WHERE cluster_id = '$cluster_id' ";
                    $updateClusterResult = mysqli_query($conn, $updateClusterQuery);

                    if ($updateClusterResult) {
                        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                            VALUES ('$ttime', '$adminuser_name', 'Registered a Technician', 'Admin', '$tech_id')";
                        $account_logResult = mysqli_query($conn, $account_logQuery);
                        if ($account_logResult) {
                            $_SESSION['message'] = "Technician Registered Successfully!";
                            $_SESSION['icon'] = "success";
                            header("Location: ../pages/page.php?page=technician");
                            exit();
                        }
                    }
                }
            }
        }
    }
}
//assign task naman dito
if (isset($_POST['assignTaskBtn'])) {
    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['off_id'];
    $adminuser_name = $_SESSION['user_name'];

    $cluster_id = mysqli_real_escape_string($conn, $_POST['cluster_id']);
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_desc = mysqli_real_escape_string($conn, $_POST['task_desc']);
    $task_date = mysqli_real_escape_string($conn, $_POST['task_date']);

    $assignTaskQuery = "INSERT INTO technician_task (task_name, task_desc, cluster_id, task_date)
        VALUES ('$task_name', '$task_desc', '$cluster_id', '$task_date')";
    $assignTaskResult = mysqli_query($conn, $assignTaskQuery);

    if ($assignTaskResult) {
        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
            VALUES ('$ttime', '$adminuser_name', 'Assigned a Task', 'Admin', '$tech_id')";
        $account_logResult = mysqli_query($conn, $account_logQuery);
        if ($account_logResult) {
            $_SESSION['message'] = "Task Assigned to" . $cluster_id . " Successfully!";
            $_SESSION['icon'] = "success";
            header("Location: ../pages/page.php?page=technician");
            exit();
        }
    }
}
// inactive rito
if (isset($_GET['inactive_id'])) {
    $inactive_id = $_GET['inactive_id'];

    $inactiveQuery = "UPDATE mao_technician SET `account_status` = 'Inactive' WHERE tech_id = '$inactive_id' ";
    $inactiveQueryResult = mysqli_query($conn, $inactiveQuery);

    if ($inactiveQueryResult) {
        $_SESSION['message'] = "Technician is now Inactive";
        $_SESSION['icon'] = "success";
        header("Location: ../pages/page.php?page=technician");
        exit();
    } else {
        $_SESSION['message'] = "There was an error. Try again later";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php?page=technician");
        exit();
    }
}
// archive technician naman dito]
if (isset($_GET['archive_id'])) {
    $archive_id = $_GET['archive_id'];

    $archiveQuery = "UPDATE mao_technician SET `account_status` = 'Archived' WHERE tech_id = '$archive_id' ";
    $archiveQueryResult = mysqli_query($conn, $archiveQuery);

    if ($archiveQueryResult) {
        $_SESSION['message'] = "Technician is now Archived";
        $_SESSION['icon'] = "success";
        header("Location: ../pages/page.php?page=technician");
        exit();
    } else {
        $_SESSION['message'] = "There was an error. Try again later";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php?page=technician");
        exit();
    }
}
// reactivate technician naman dito
if (isset($_GET['bringback_id'])) {
    $bringback_id = $_GET['bringback_id'];

    $bringbackQuery = "UPDATE mao_technician SET `account_status` = 'Active' WHERE tech_id = '$bringback_id' ";
    $bringbackQueryResult = mysqli_query($conn, $bringbackQuery);

    if ($bringbackQueryResult) {
        $_SESSION['message'] = "Technician is now Active!";
        $_SESSION['icon'] = "success";
        header("Location: ../pages/page.php?page=technician");
        exit();
    } else {
        $_SESSION['message'] = "There was an error. Try again later";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php?page=technician");
        exit();
    }
}
?>