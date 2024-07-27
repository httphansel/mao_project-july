<?php
session_start();

require '../config/condb.php';

//Login
if (isset($_POST['submitLogin'])) {
    $email = $_POST['email'];
    $password =  $_POST['password'];


    $query = "SELECT * FROM mao_officer WHERE email = '$email' limit 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password && $user_data['email'] === $email) {

                $sql = "SELECT * FROM mao_officer WHERE email = '$email' ";
                $show_result = mysqli_query($conn, $sql);
                if ($show_result) {
                    $row = mysqli_fetch_assoc($show_result);

                    $admin_id = $row['off_id'];
                    $user_name = $row['user_name'];
                    $user_type = 'Admin';
                    $user_action = 'Login Account';

                    date_default_timezone_set('Asia/Manila');
                    $ddate = new DateTime();

                    $new_ddate = $ddate->format('Y-m-d');
                    $dday = $ddate->format('l');
                    $ttime = $ddate->format('h:i a');
                    $current_hour = (int)date('G');
                    $time_of_day = '';


                    $queri = "INSERT INTO account_log (user_id, user_name, user_type, user_action, log_date, log_time)
                    VALUES ('$admin_id', '$user_name', '$user_type', '$user_action', '$new_ddate','$ttime')";
                    $admin_results = mysqli_query($conn, $queri);

                    if ($current_hour >= 5 && $current_hour < 12) {
                        $time_of_day = 'Good morning';
                        $_SESSION['login_message'] = "$time_of_day! $user_name, start your day with a big smile :). ";
                    } elseif ($current_hour >= 12 && $current_hour < 18) {
                        $time_of_day = 'Good afternoon';
                        $_SESSION['login_message'] = "$time_of_day! $user_name, already tired? be energetic the job isn't done already. ";
                    } else {
                        $time_of_day = 'Good evening';
                        $_SESSION['login_message'] = "$time_of_day! $user_name, how the day today? I hope everything is okay.";
                    }

                    $_SESSION['message'] = "Log In Successful!";
                    $_SESSION['icon'] = "success";
                    $_SESSION['off_id'] = $user_data['off_id'];
                    $_SESSION['user_name'] = $user_data['user_name']; 
                    header("Location: ../pages/page.php?page=dashboard");
                    die;
                }
            } else {
                $_SESSION['message'] = "Incorrect email or password!";
                $_SESSION['icon'] = "error";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $querys = "SELECT * FROM mao_technician WHERE email = '$email' limit 1";
            $results = mysqli_query($conn, $querys);
            if ($results) {
                if ($results && mysqli_num_rows($results) > 0) {
                    $user_datas = mysqli_fetch_assoc($results);

                    if ($user_datas['password'] === $password && $user_datas['email'] === $email) {
                        if ($user_datas['account_status'] === 'Active') {

                            $sqls = "SELECT * FROM mao_technician WHERE email = '$email' ";
                            $shows_result = mysqli_query($conn, $sqls);
                            if ($shows_result) {
                                $row = mysqli_fetch_assoc($shows_result);

                                $user_id = $row['tech_id'];
                                $user_name = $row['user_name'];
                                $user_type = 'Technician';
                                $user_action = 'Login Account';

                                date_default_timezone_set('Asia/Manila');
                                $ddate = new DateTime();

                                $new_ddate = $ddate->format('Y-m-d');
                                $dday = $ddate->format('l');
                                $ttime = $ddate->format('h:i a');
                                $current_hour = (int)date('G');
                                $time_of_day = '';

                                $queri = "INSERT INTO account_log (user_id, user_name, user_type, user_action, log_date, log_time)
                    VALUES ('$user_id', '$user_name', '$user_type', '$user_action', '$new_ddate', '$ttime')";
                                $results = mysqli_query($conn, $queri);

                                if ($current_hour >= 5 && $current_hour < 12) {
                                    $time_of_day = 'Good morning';
                                    $_SESSION['login_message'] = "$time_of_day! $user_name, start your day with a big smile :). ";
                                } elseif ($current_hour >= 12 && $current_hour < 18) {
                                    $time_of_day = 'Good afternoon';
                                    $_SESSION['login_message'] = "$time_of_day! $user_name, already tired? be energetic the job isn't done already. ";
                                } else {
                                    $time_of_day = 'Good evening';
                                    $_SESSION['login_message'] = "$time_of_day! $user_name, how the day today? I hope everything is okay.";
                                }

                                $_SESSION['tech_id'] = $user_datas['tech_id'];
                                $_SESSION['user_name'] = $user_datas['user_name'];
                                $_SESSION['cluster_id'] = $user_datas['cluster_id'];
                                $_SESSION['message'] = "Log In Successful!";
                                $_SESSION['icon'] = "success";
                                header("Location: ../tech-pages/page.php?page=dashboard");
                                exit;
                            }
                        } else {
                            $_SESSION['message'] = "Account has been disabled! Contact the Administrator for more details.";
                            $_SESSION['icon'] = "error";
                            header("Location: ../index.php");
                            exit();
                        }
                    } else {
                        $_SESSION['message'] = "Incorrect email or password!";
                        $_SESSION['icon'] = "error";
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    $_SESSION['message'] = "Incorrect email or password!";
                    $_SESSION['icon'] = "error";
                    header("Location: ../index.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Incorrect email or password!";
                $_SESSION['icon'] = "error";
                header("Location: ../index.php");
                exit();
            }
        }
    }
}
