<?php
require '../config/condb.php';
session_start();

$tech_id = $_SESSION['off_id'];

if (!$tech_id) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <link rel="icon" href="../assets/images/logo.png">
    <link rel="stylesheet" href="../assets/style.css">

    <!-- bootstrap -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">

    <!-- datatable -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <link href="../assets/datatable/datatables.min.css" rel="stylesheet">
    <script src="../assets/datatable/datatables.min.js"></script>

    <!-- fontawesome -->
    <link href="../assets/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/webfonts/fa-solid-900.ttf">

    <!-- alertify -->
    <link rel="stylesheet" href="../assets/alertify/css/alertify.min.css">
    <link rel="stylesheet" href="../assets/alertify/css/bootstrap.min.css">

</head>

<style>
    /* Remove arrows in WebKit browsers (Chrome, Safari, Edge) */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* technician side 'to sa confirm password */
    .error {
        color: red;
    }

    .success {
        color: green;
    }
</style>

<body>

    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- navbar/sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar h-100 text-center" style="background-color: #6c757d;">
                <div class="position-sticky pt-2">
                    <div class="d-flex align-items-center p-0">
                        <img src="../assets/images/logo.png" class="text-center" alt="" style="width: 80px; height: 80px;">
                        <h2 class="mt-3" style="font-family: var(--bebas); color: var(--white); font-weight: 400; text-decoration: underline;">M A O System</h2>
                    </div>

                    <div class="border-bottom my-3"></div>

                    <ul class="nav flex-column text-center">
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                        $pages = [
                            'dashboard' => ['Dashboard', 'fa-home'],
                            'inventory' => ['Inventory', 'fa-warehouse'],
                            'distributed' => ['Distributed', 'fa-share-square'],
                            'technician' => ['Technician', 'fa-user-gear'],
                            'certificates' => ['Certificates', 'fa-certificate'],
                            'm_report' => ['Monthly Report', 'fa-file-invoice']
                        ];
                        foreach ($pages as $key => $value) {
                            $active = ($page == $key) ? 'active' : '';
                            echo "<li class='nav-item'>
                                    <a class='nav-link mt-2 $active' href='?page=$key'>
                                        <i class='fas {$value[1]}'></i> {$value[0]}
                                    </a>
                                </li>";
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <!-- main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 p-3 h-100 overflow-auto bg-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-start bg-success-subtle px-5 p-2 shadow shadow-lg rounded">
                        <h1 class="h5" id="time"></h1>
                        <h3 class="h5" id="date"></h3>
                        <h1 class="h5" id="day"></h1>
                    </div>
                    <?php
                    $adminId = $_SESSION['off_id'];
                    $adminQuery = "SELECT * FROM mao_officer WHERE  off_id = '$adminId' ";
                    $adminResult = mysqli_query($conn, $adminQuery);

                    if ($adminResult->num_rows > 0) {
                        while ($admin = $adminResult->fetch_assoc()) {
                    ?>
                            <div class="d-flex align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#optionsCollapse" aria-expanded="false" aria-controls="optionsCollapse">
                                <img src="data:image/jpeg;base64,<?= base64_encode($admin['user_pic']) ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid green; margin-right: 10px;">
                                <h1 class="h3"> <span class="lead" style="font-size: 12px;">WELCOME</span><br> <?= $admin['user_name'] ?></h1>
                            </div>
                </div>

                <!-- collapse admin/tech options -->
                <div class="collapse text-end ms-auto" id="optionsCollapse" style="width: 200px; align-self: flex-end;">
                    <div class="card card-body">
                        <ul class="nav text-end">
                            <li class="nav-item">
                                <a role="button" class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#adminProfileModal">
                                    User Profile
                                </a>
                            </li>
                            <!-- modal ng admin profile -->
                            <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <h2 class="text-center">Admin Profile</h2>
                                                <div class="border-bottom my-2"></div>
                                                <div class="col-4">
                                                    <div class="shadow shadow-lg p-2 text-center bg-success-subtle">
                                                        <img src="data:image/jpeg;base64,<?= base64_encode($admin['user_pic']) ?>" alt="" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid green; margin-right: 10px;">
                                                        <h5 class="my-2">ADMIN: <?= $admin['user_name'] ?></h5>
                                                        <div class="border-bottom mt-1 mb-3"></div>
                                                        <form action="../function/adminFunction.php" method="post" enctype="multipart/form-data" class="text-start">
                                                            <label for="user_pic" class="form-label fw-bold text-primary">Change Profile Picture?</label>
                                                            <input type="file" class="form-control" name="user_pic">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="shadow shadow-lg p-2 bg-success-subtle">
                                                        <h3 class="text-center">Admin Information</h3>
                                                        <div class="border-bottom my-2"></div>
                                                        <div class="row mb-2 g-1">
                                                            <div class="col w-100">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control w-100" id="name" name="off_fname" placeholder="name@example.com" value="<?= $admin['off_fname'] ?>" autocomplete="off" required>
                                                                    <label for="floatingInput" class="">FIRSTNAME</label>
                                                                    <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                                                </div>
                                                            </div>
                                                            <div class="col w-100">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control w-100" id="name" name="off_mname" placeholder="name@example.com" value="<?= $admin['off_mname'] ?>" autocomplete="off" required>
                                                                    <label for="floatingInput" class="">MIDDLENAME</label>
                                                                    <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                                                </div>
                                                            </div>
                                                            <div class="col w-100">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control w-100" id="name" name="off_lname" placeholder="name@example.com" value="<?= $admin['off_lname'] ?>" autocomplete="off" required>
                                                                    <label for="floatingInput" class="">LASTNAME</label>
                                                                    <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2 g-1">
                                                            <div class="col-3">
                                                                <div class="form-floating">
                                                                    <input type="number" class="form-control" id="floatingInputDisabled" value="<?= $admin['off_extname'] ?>" placeholder="name@example.com" disabled>
                                                                    <label for="floatingInputDisabled">SUFFIX</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating">
                                                                    <input type="date" class="form-control" id="floatingInputDisabled" value="<?= $admin['birthday'] ?>" placeholder="name@example.com" disabled>
                                                                    <label for="floatingInputDisabled">BIRTHDAY</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="form-floating">
                                                                    <input type="number" class="form-control" id="floatingInputDisabled" value="<?= $admin['age'] ?>" placeholder="name@example.com" disabled>
                                                                    <label for="floatingInputDisabled">AGE</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="floatingInputDisabled" value="<?= $admin['barangay'] . ', ' . $admin['municipality'] . ', ' . $admin['province'] . ', ' . $admin['region'] ?>" placeholder="name@example.com" disabled>
                                                            <label for="floatingInputDisabled">ADDRESS</label>
                                                        </div>
                                                        <div class="row g-1 mb-2">
                                                            <div class="col-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control" id="floatingInputDisabled" value="<?= $admin['user_name'] ?>" name="user_name" placeholder="name@example.com" required>
                                                                    <label for="floatingInputDisabled">USERNAME</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating">
                                                                    <input type="email" class="form-control" id="floatingInput" value="<?= $admin['email'] ?>" name="email" placeholder="name@example.com" required>
                                                                    <label for="floatingInput">EMAIL</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-1 mb-2">
                                                            <div class="col">
                                                                <div class="form-floating">
                                                                    <input type="password" class="form-control" name="password" autocomplete="off" required id="password" oninput="validatePassword()" autocomplete="off" value="<?= $admin['password'] ?>" required>
                                                                    <label for="password" class="form-label fw-bold">Password:</label>
                                                                    <span class="error" id="passwordErr"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col mb-2">
                                                                <div class="form-floating">
                                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" oninput="validateConfirmPassword()" autocomplete="off" value="<?= $admin['password'] ?>" required>
                                                                    <label for="confirm_password" class="form-label fw-bold">Confirm Password:</label>
                                                                    <span class="error" id="confirmPasswordErr"></span>
                                                                </div>
                                                                <button class="btn btn-success fw-bold mt-2" style="border-radius: 0; font-family: var(--kanit);" name="updateAdminBtn">UPDATE</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <li class="nav-item">
                                <a href="termscondition.php" target="_blank" class="nav-link text-success">
                                    Terms and Conditions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../function/logout.php?admin_id=<?= $admin['off_id'] ?>" class="nav-link text-danger">
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        <?php
                        }
                    }
        ?>
        <div class="border-bottom my-3"></div>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $page);
        $file = "{$page}.php";
        if (file_exists($file)) {
            include($file);
        } else {
            echo "<p>Page not found.</p>";
        }
        ?>
            </main>
        </div>
    </div>

    <!-- bootstrap -->
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- alertify -->
    <script src="../assets/alertify/js/alertify.min.js"></script>

    <!-- google charts -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- fontawesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <!-- ph adress lib -->
    <script src="ph-address-selector.js"></script>

    <!-- script sa date and time -->
    <script>
        function updateDateTime() {
            const now = new Date();
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const day = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const time = now.toLocaleTimeString();

            document.getElementById('time').innerText = time;
            document.getElementById('date').innerText = `${date} ${month} ${year}`;
            document.getElementById('day').innerText = day;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

    <!-- alertify script -->
    <script>
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            alertify.set('notifier', 'position', 'top-right');
            alertify.<?= $_SESSION['icon'] ?>('<?= $_SESSION['message'] ?>');
        <?php
            unset($_SESSION['message']);
        }
        ?>
    </script>

    <!-- datatable script -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $(document).ready(function() {
            $('#fertilizerTbl').DataTable();
        });

        $(document).ready(function() {
            $('#medicineTbl').DataTable();
        });

        $(document).ready(function() {
            $('#distributionTable').DataTable();
        });

        $(document).ready(function() {
            $('#taskTable').DataTable();
        });
    </script>

    <!-- NO NUMBERS SCRIPT ITO -->
    <script>
        document.getElementById('name').addEventListener('input', function(event) {
            var input = event.target.value;
            var errorText = document.getElementById('errorText');
            if (/\d/.test(input)) {
                errorText.style.display = 'inline';
                event.target.value = input.replace(/\d/g, ''); // Remove the numeric characters
            } else {
                errorText.style.display = 'none';
            }
        });
        document.getElementById('m_name').addEventListener('input', function(event) {
            var input = event.target.value;
            var errorText = document.getElementById('errorText');
            if (/\d/.test(input)) {
                errorText.style.display = 'inline';
                event.target.value = input.replace(/\d/g, ''); // Remove the numeric characters
            } else {
                errorText.style.display = 'none';
            }
        });
        document.getElementById('l_name').addEventListener('input', function(event) {
            var input = event.target.value;
            var errorText = document.getElementById('errorText');
            if (/\d/.test(input)) {
                errorText.style.display = 'inline';
                event.target.value = input.replace(/\d/g, ''); // Remove the numeric characters
            } else {
                errorText.style.display = 'none';
            }
        });
    </script>
    <!-- validate password -->
<script>
    function validatePassword() {
        let password = document.getElementById('password').value;
        let passwordErr = document.getElementById('passwordErr');
        if (password.length < 6) {
            passwordErr.textContent = 'Password must have at least 6 characters.';
        } else {
            passwordErr.textContent = '';
        }
        validateConfirmPassword(); // Call confirm password validation to ensure consistency
    }

    function validateConfirmPassword() {
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm_password').value;
        let confirmPasswordErr = document.getElementById('confirmPasswordErr');
        if (confirmPassword !== password) {
            confirmPasswordErr.textContent = 'Passwords did not match.';
        } else {
            confirmPasswordErr.textContent = '';
        }
    }
</script>
</body>

</html>