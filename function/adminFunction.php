<?php
require '../config/condb.php';
session_start();

//update admin data
if (isset($_POST['updateAdminBtn'])) {

    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $technician = $_SESSION['user_name'];
    $tech_id = $_SESSION['off_id'];

    $off_fname = mysqli_real_escape_string($conn, $_POST['off_fname']);
    $off_mname = mysqli_real_escape_string($conn, $_POST['off_mname']);
    $off_lname = mysqli_real_escape_string($conn, $_POST['off_lname']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $imgContent = NULL;

    if (isset($_FILES['user_pic']) && $_FILES['user_pic']['error'] == 0) {
        $user_pic = $_FILES['user_pic']['tmp_name'];
        $imgContent = addslashes(file_get_contents($user_pic));

        // Check file size (5MB limit)
        if ($_FILES['user_pic']['size'] > 5 * 1024 * 1024) {
            $_SESSION['message'] = "Error: File size exceeds 5MB limit.";
            $_SESSION['icon'] = "error";
            header("Location: ../index.php?tech-page=dashboard");
            exit();
        }
    }

    $updateTechQuery = "UPDATE mao_officer SET 
        off_fname = '$off_fname', 
        off_mname = '$off_mname', 
        off_lname = '$off_lname', 
        user_name = '$user_name',
        email = '$email',
        password = '$password'";

    // Append user_pic update if an image was uploaded
    if ($imgContent) {
        $updateTechQuery .= ", user_pic = '$imgContent'";
    }

    $updateTechQuery .= " WHERE off_id = '$tech_id' ";

    $updateTechResult = mysqli_query($conn, $updateTechQuery);

    if ($updateTechResult) {
        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
        VALUES ('$ttime', '$technician', 'Update Account Data', 'Admin', '$tech_id')";
        $account_logResult = mysqli_query($conn, $account_logQuery);

        if ($account_logResult) {
            $_SESSION['message'] = "Profile Updated Successfully!";
            $_SESSION['icon'] = "success";
            header("Location: ../pages/page.php");
            exit();
        } else {
            $_SESSION['message'] = "Error logging the update.";
            $_SESSION['icon'] = "error";
            header("Location: ../pages/page.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Error updating technician.";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php");
        exit();
    }
}

//distribute button
if (isset($_POST['distributeBtn'])) {
    date_default_timezone_set('Asia/Manila');
    $ddate = new DateTime();
    $new_ddate = $ddate->format('Y-m-d');
    $dday = $ddate->format('l');
    $ttime = $ddate->format('h:i a');
    $tech_id = $_SESSION['off_id'];
    $user_name = $_SESSION['user_name'];

    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
    $cluster_id = mysqli_real_escape_string($conn, $_POST['cluster_id']);

    $itemInventory = "SELECT * FROM inventory WHERE item_name = '$item_name' ";
    $itemInventoryResult = mysqli_query($conn, $itemInventory);

    if ($itemInventoryResult->num_rows > 0) {
        while ($inventory = $itemInventoryResult->fetch_assoc()) {

            if ($item_quantity <= $inventory['item_quantity']) {
                $updatedQuantity = $inventory['item_quantity'] - $item_quantity;

                $updateInventoryQuery = "UPDATE inventory SET `item_quantity` = '$updatedQuantity' WHERE item_name = '$item_name'";
                $updateInventoryResult = mysqli_query($conn, $updateInventoryQuery);

                if ($updateInventoryResult) {
                    $techInventoryQuery = "INSERT INTO tech_inventory (item_name, item_quantity, cluster_id)
                        VALUES ('$item_name', '$item_quantity', '$cluster_id')";
                    $techInventoryResult = mysqli_query($conn, $techInventoryQuery);

                    if ($techInventoryResult) {
                        $account_logQuery = "INSERT INTO account_log (log_time, user_name, user_action, user_type, user_id)
                        VALUES ('$ttime', '$user_name', 'Distributed an Item', 'Admin', '$tech_id')";
                        $account_logResult = mysqli_query($conn, $account_logQuery);
                        if ($account_logResult) {
                            $_SESSION['message'] = "Item Distributed Successfully!";
                            $_SESSION['icon'] = "success";
                            header("Location: ../pages/page.php?page=distributed");
                            exit();
                        }
                    } else {
                        $_SESSION['message'] = "There was an error distributing items";
                        $_SESSION['icon'] = "error";
                        header("Location: ../pages/page.php?page=distributed");
                        exit();
                    }
                }
            } else {
                $_SESSION['message'] = "Not enough items in inventory to distribute";
                $_SESSION['icon'] = "error";
                header("Location: ../pages/page.php?page=distributed");
                exit();
            }
        }
    } else {
        $_SESSION['message'] = "Item not found in inventory";
        $_SESSION['icon'] = "error";
        header("Location: ../pages/page.php?page=distributed");
        exit();
    }
}

// assign task functionality rito
if (isset($_POST['assignTaskBtn'])) {

    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_desc = mysqli_real_escape_string($conn, $_POST['task_desc']);
    $task_tech = mysqli_real_escape_string($conn, $_POST['task_tech']);
    $task_date = mysqli_real_escape_string($conn, $_POST['task_date']);

    $assignTaskQuery = "INSERT INTO technician_task (task_name, task_desc, task_tech, task_date)
        VALUES ('$task_name', '$task_desc', '$task_tech', '$task_date')";
    $assignTaskResult = mysqli_query($conn, $assignTaskQuery);

    if ($assignTaskResult) {
        $_SESSION['message'] = "Task Assigned Successfully!";
        $_SESSION['icon'] = "success";
        header("Location: ../index.php?page=technician");
        exit();
    } else {
        $_SESSION['message'] = "There was an error assigning task!";
        $_SESSION['icon'] = "error";
        header("Location: ../index.php?page=technician");
        exit();
    }
}
