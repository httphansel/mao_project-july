<?php
//count lang ng active,inactive at archived techs ito
$totalTechnicianQuery = "SELECT * FROM mao_technician WHERE account_status != 'Archived' ";
$totalTechnicianResult = mysqli_query($conn, $totalTechnicianQuery);

if ($totalTechnicianResult->num_rows > 0) {
    $totalTechnician = mysqli_num_rows($totalTechnicianResult);

    $activeTechnicianQuery = "SELECT * FROM mao_technician WHERE account_status = 'Active' ";
    if ($activeTechnicianResult = mysqli_query($conn, $activeTechnicianQuery)) {
        $activeTechnician = mysqli_num_rows($activeTechnicianResult);

        $inactiveTechnicianQuery = "SELECT * FROM mao_technician WHERE account_status = 'Inactive' ";
        if ($inactiveTechnicianResult = mysqli_query($conn, $inactiveTechnicianQuery)) {
            $inactiveTechnician = mysqli_num_rows($inactiveTechnicianResult);

            $archivedTechnicianQuery = "SELECT * FROM mao_technician WHERE account_status = 'Archived' ";
            if ($archivedTechnicianResult = mysqli_query($conn, $archivedTechnicianQuery)) {
                $archivedTechnician = mysqli_num_rows($archivedTechnicianResult);
            }
        }
    }
}
?>
<h2>TECHNICIAN</h2>

<div class="shadow shadow-lg p-3 rounded">
    <div class="row mb-5">
        <div class="col-9">
            <div class="card mt-3" style="border-radius: 0;">
                <div class="card-body py-4">
                    <h5 class="text-center">Technician Analytics</h5>
                    <div class="row g-2 text-center">
                        <div class="col">
                            <div class="card p-0 pt-2 bg-success-subtle" style="border-radius: 0;">
                                <div class="card-body fw-bold p-0">
                                    <div class="row">
                                        <div class="col">
                                            ACTIVE
                                            <h2 class="fw-bold"><?= $activeTechnician ?></h2>
                                        </div>
                                        <div class="col">
                                            <p class="fs-1">
                                                <i class="fa-solid fa-user-check text-success"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- inactive -->
                        <div class="col" role="button" data-bs-toggle="modal" data-bs-target="#inactiveModal">
                            <div class="card p-0 pt-2 bg-warning-subtle" style="border-radius: 0;">
                                <div class="card-body fw-bold p-0">
                                    <div class="row">
                                        <div class="col">
                                            INACTIVE
                                            <h2 class="fw-bold"><?= $inactiveTechnician ?></h2>
                                        </div>
                                        <div class="col">
                                            <p class="fs-1">
                                                <i class="fa-solid fa-user-xmark text-warning"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- inactive end -->
                        <div class="col">
                            <div class="card p-0 pt-2 bg-danger-subtle" style="border-radius: 0;">
                                <div class="card-body fw-bold p-0 pb-0">
                                    <div class="row">
                                        <div class="col">
                                            ARCHIVED
                                            <h2 class="fw-bold"><?= $archivedTechnician ?></h2>
                                        </div>
                                        <div class="col">
                                            <p class="fs-1">
                                                <i class="fa-solid fa-user-slash text-danger"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- assign task and register a technician column -->
        <div class="col text-center">
            <div class="shadow p-3 rounded bg-success-subtle" style="border-radius: 0;">
                <!-- assign task -->
                <div class="shadow p-3 shadow-lg rounded btn btn-success w-100 p-3 mt-3" role="button" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                    <div class="row">
                        <h5><i class="fa-solid fa-list-check"></i> Assign Task</h5>
                    </div>
                </div>

                <div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="border-radius: 0;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h1 class="modal-title fw-bold text-center" id="exampleModalLabel"><i class="fa-solid fa-list-check text-success"></i> ASSIGN TASK</h1>
                            </div>
                            <div class="modal-body p-3">
                                <form action="../function/technicianFunction.php" method="post">
                                    <div class="row g-2 mb-2">
                                        <div class="col w-100">
                                            <div class="form-floating">
                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="cluster_id">
                                                    <option selected>Select Cluster to assign</option>
                                                    <option></option>
                                                    <?php
                                                    $clusterQuery = "SELECT c.cluster_id, c.tech_id, mt.tech_fname, mt.tech_lname 
                                                                    FROM cluster c 
                                                                    JOIN mao_technician mt ON c.tech_id = mt.tech_id 
                                                                    WHERE c.tech_id != 'Not Assigned'";
                                                    $clusterQueryResult = mysqli_query($conn, $clusterQuery);

                                                    if ($clusterQueryResult->num_rows > 0) {
                                                        while ($clusters = $clusterQueryResult->fetch_assoc()) {
                                                            $technician = $clusters['tech_fname'] . ' ' . $clusters['tech_lname'];
                                                    ?>
                                                            <option value="<?= $clusters['cluster_id'] ?>"><?= $clusters['cluster_id'] ?>: <?= $technician ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label for="floatingSelect">Cluster</label>
                                            </div>
                                        </div>
                                        <div class="col w-100">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="task_name" required>
                                                <label for="floatingInput">Task</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <textarea class="form-control" placeholder="Leave a comment here" name="task_desc" id="floatingTextarea" required></textarea>
                                            <label for="floatingTextarea">Task Description</label>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-6 w-50">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" id="floatingInput" placeholder="name@example.com" name="task_date" required>
                                                    <label for="floatingInput">Must do on/before</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-outline-success fw-bold w-100 float-start mt-2 me-1" style="border-radius: 0;" name="assignTaskBtn">ASSIGN</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- assign task -->

                <!-- register technician -->
                <div class="shadow p-3 shadow-lg rounded btn btn-outline-success w-100 p-3 mt-3" role="button" data-bs-toggle="modal" data-bs-target="#registerTechnicianModal">
                    <div class="row">
                        <h5><i class="fa-solid fa-user-plus"></i> Register a Technician</h5>
                    </div>
                </div>

                <div class="modal fade" id="registerTechnicianModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4" id="exampleModalLabel">REGISTER TECHNICIAN</h1>
                            </div>
                            <div class="modal-body pt-2">
                                <form action="../function/technicianFunction.php" method="post" id="technicianForm" onsubmit="return validateForm()" enctype="multipart/form-data">
                                    <div class="row mb-3 g-1">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" class="form-control w-100" id="name" name="tech_fname" placeholder="name@example.com" autocomplete="off" required>
                                                <label for="floatingInput" class="">FIRSTNAME</label>
                                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" class="form-control w-100" id="m_name" name="tech_mname" placeholder="name@example.com" autocomplete="off" required>
                                                <label for="floatingInput" class="">MIDDLENAME</label>
                                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" class="form-control w-100" id="l_name" name="tech_lname" placeholder="name@example.com" autocomplete="off" required>
                                                <label for="floatingInput" class="">LASTNAME</label>
                                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 g-2">
                                        <div class="col-3">
                                            <div class="form-floating">
                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="tech_extname" autocomplete="off" required>
                                                    <option></option>
                                                    <option value="n/a">n/a</option>
                                                    <option value="Sr">Sr</option>
                                                    <option value="Jr">Jr</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                </select>
                                                <label for="floatingSelect" class="fw-bold">SUFFIX</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" id="birthdate" onchange="calculateAge()" name="birthday" placeholder="Password" autocomplete="off" required>
                                                <label for="floatingPassword" class="fw-bold">BIRTHDAY</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="ageNow" name="age" value="<?= $age ?>" readonly>
                                                <label for="floatingPassword" class="">AGE</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 g-2">
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="sex" autocomplete="off" required>
                                                    <option></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <label for="floatingSelect" class="fw-bold">GENDER</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="barangay" autocomplete="off" required>
                                                    <option selected>Select Barangay</option>
                                                    <option></option>
                                                    <option value="Akle">Akle</option>
                                                    <option value="Alagao">Alagao</option>
                                                    <option value="Anyatam">Anyatam</option>
                                                    <option value="Bagong Barrio">Bagong Barrio</option>
                                                    <option value="Basuit">Basuit</option>
                                                    <option value="Bubulong Malak">Bubulong Malaki</option>
                                                    <option value="Bubulong Munti">Bubulong Munti</option>
                                                    <option value="Buhol na Mangga">Buhol na Mangga</option>
                                                    <option value="Bulusukan">Bulusukan</option>
                                                    <option value="Calasag">Calasag</option>
                                                    <option value="Calawitan">Calawitan</option>
                                                    <option value="Casalat">Casalat</option>
                                                    <option value="Gabihan">Gabihan</option>
                                                    <option value="Garlang">Garlang</option>
                                                    <option value="Lapnit">Lapnit</option>
                                                    <option value="Maasim">Maasim</option>
                                                    <option value="Makapilapil">Makapilapil</option>
                                                    <option value="Malipampang">Malipampang</option>
                                                    <option value="Mataas na Par">Mataas na Parang</option>
                                                    <option value="Matimbubong">Matimbubong</option>
                                                    <option value="Nabaong Garlang">Nabaong Garlang</option>
                                                    <option value="Palapala">Palapala</option>
                                                    <option value="Pasong Bakal">Pasong Bakal</option>
                                                    <option value="Pinaod">Pinaod</option>
                                                    <option value="Poblacion">Poblacion</option>
                                                    <option value="Pulong Tamo">Pulong Tamo</option>
                                                    <option value="San Juan">San Juan</option>
                                                    <option value="Santa Catalina Bata">Santa Catalina Bata</option>
                                                    <option value="Santa Catalina Matanda">Santa Catalina Matanda</option>
                                                    <option value="Sapang Dayap">Sapang Dayap</option>
                                                    <option value="Sapang Putik">Sapang Putik</option>
                                                    <option value="Sapang Putol">Sapang Putol</option>
                                                    <option value="Sumandig">Sumandig</option>
                                                    <option value="Telepatio">Telepatio</option>
                                                    <option value="Umpucan">Umpucan</option>
                                                    <option value="Upig">Upig</option>
                                                </select>
                                                <label for="floatingSelect" class="fw-bold">BARANGAY</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 g-2">
                                        <div class="col-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control w-100" id="name" name="user_name" placeholder="name@example.com" autocomplete="off" required>
                                                <label for="floatingInput" class="">USERNAME</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="email" class="form-control w-100" id="name" name="email" placeholder="name@example.com" autocomplete="off" required>
                                                <label for="floatingInput" class="">EMAIL</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 g-2">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" name="password" autocomplete="off" required id="password" oninput="validatePassword()" autocomplete="off" required>
                                                <label for="password" class="form-label fw-bold">Password:</label>
                                                <span class="error" id="passwordErr"></span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" oninput="validateConfirmPassword()" autocomplete="off" required>
                                                <label for="confirm_password" class="form-label fw-bold">Confirm Password:</label>
                                                <span class="error" id="confirmPasswordErr"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 g-2 text-start">
                                        <div class="col-6">
                                            <div class="form-floating mt-2">
                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="cluster_id" autocomplete="off" required>
                                                    <option></option>
                                                    <?php
                                                    $clusterQuery = "SELECT * FROM cluster WHERE tech_id = 'Not Assigned' ";
                                                    $clusterQueryResult = mysqli_query($conn, $clusterQuery);
                                                    if ($clusterQueryResult->num_rows > 0) {
                                                        while ($cluster = $clusterQueryResult->fetch_assoc()) {
                                                    ?>
                                                            <option value="<?= $cluster['cluster_id'] ?>"><?= $cluster['cluster_id'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label for="floatingSelect" class="fw-bold">CLUSTER</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="user_pic" class="form-label fw-bold text-start">PROFILE PICTURE</label>
                                            <input type="file" class="form-control" name="user_pic" required>
                                            <span class="text-danger mb-3 ms-1">Size Limit: 5MB</span>
                                            <button class="btn btn-success fw-bold p-2 px-3 mt-3 float-end" style="border-radius: 0;" name="registerTechBtn">
                                                REGISTER
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- register technician -->
            </div>
        </div>
    </div>
    <!-- active technicians -->
    <div class="row">
        <div class="col">
            <h2>Active Technician</h2>
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="table-info text-center">
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Cluster</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <!-- technician query start here -->
                    <?php
                    $technicianQuery = "SELECT * FROM mao_technician WHERE account_status = 'Active' ";
                    $technicianQueryResult = mysqli_query($conn, $technicianQuery);

                    if ($technicianQueryResult->num_rows > 0) {
                        while ($technician = $technicianQueryResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $technician['tech_fname'] ?></td>
                                <td><?= $technician['tech_lname'] ?></td>
                                <td><?= $technician['sex'] ?></td>
                                <td><?= $technician['email'] ?></td>
                                <td><?= $technician['cluster_id'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-outline-secondary p-0 px-3" type="button" data-bs-toggle="modal" data-bs-target="#viewTechnician<?= $technician['tech_id'] ?>" aria-controls="offcanvasExample">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-danger p-0 px-3" type="button" data-bs-toggle="modal" data-bs-target="#archiveTechnician<?= $technician['tech_id'] ?>">
                                        <i class="fa-solid fa-trash-arrow-up" data-bs-toggle="tooltip" title="Delete Data?"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- technician query ends here -->

                            <!-- view profile modal -->
                            <div class="modal fade" id="viewTechnician<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered p-5">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <div class="row">
                                                <h2>Technician Profile</h2>
                                                <div class="border-bottom my-3"></div>
                                                <div class="col-4">
                                                    <div class="shadow shadow-lg rounded p-2 text-center align-items-center justify-self-center justify-content-center mt-4">
                                                        <img src="data:image/jpeg;base64,<?= base64_encode($technician['user_pic']) ?>" class="text-center" alt="user_picture" style="border-radius: 50%; border: 1px solid var(--success-subtle); width: 200px; height: 200px;">
                                                        <p class="fw-bold fs-4 mt-2">TECH. <?= $technician['user_name'] ?></p>
                                                        <p class="fw-bold fs-5 text-success mt-2">ACTIVE</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="shadow shadow-lg p-3 rounded pt-5">
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="tech_fname" name="tech_fname" value="<?= $technician['tech_fname'] ?>" placeholder="First Name" disabled>
                                                                    <label for="tech_fname" class="fw-bold">First Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="tech_lname" name="tech_lname" value="<?= $technician['tech_lname'] ?>" placeholder="Last Name" disabled>
                                                                    <label for="tech_lname" class="fw-bold">Last Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control" id="email" name="email" value="<?= $technician['email'] ?>" placeholder="Email" disabled>
                                                                <label for="email" class="fw-bold mx-2">Email</label>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control w-100" id="email" name="email" value="<?= $technician['age'] ?>" placeholder="Email" disabled>
                                                                        <label for="age" class="fw-bold mx-2">Age</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control w-100" id="email" name="email" value="<?= $technician['birthday'] ?>" placeholder="Email" disabled>
                                                                        <label for="birthday" class="fw-bold mx-2">Birthday</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" value=" <?= $technician['barangay'] . ", " . $technician['municipality'] . ", " . $technician['province'] . ", " . $technician['region'] ?>" disabled>
                                                                <label for="floatingInputDisabled" class="fw-bold mx-2">Address</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" value="<?= $technician['cluster_id'] ?>" disabled>
                                                                <label for="floatingInputDisabled" class="fw-bold mx-2">Cluster</label>
                                                            </div>
                                                            <button class="btn btn-warning w-25 ms-3" data-bs-toggle="modal" data-bs-target="#inactiveModal<?= $technician['tech_id'] ?>" style="border-radius: 0;">
                                                                Mark As Inactive
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- view profile modal -->

                            <!-- modal for inactive prompt -->
                            <div class="modal fade" id="inactiveModal<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <p class="h4 mb-2">
                                                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                Mark "<?= $technician['tech_fname'] . " " . $technician['tech_lname'] ?>" as an "Inactive"?
                                            </p>
                                            <button class="btn btn-secondary float-end ms-1" data-bs-dismiss="modal">Close</button>
                                            <a href="../function/technicianFunction.php?inactive_id=<?= $technician['tech_id'] ?>" class="btn btn-outline-danger float-end">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal for archiving tech -->
                            <div class="modal fade" id="archiveTechnician<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <p class="h4 mb-2">
                                                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                Demote "<?= $technician['tech_fname'] . " " . $technician['tech_lname'] ?>" from being a Technician?
                                            </p>
                                            <button class="btn btn-secondary float-end ms-1" data-bs-dismiss="modal">Close</button>
                                            <a href="../function/technicianFunction.php?archive_id=<?= $technician['tech_id'] ?>" class="btn btn-outline-danger float-end">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- archived technician -->
<div class="shadow p-5 rounded mt-3">
    <div class="row">
        <div class="col">
            <h3>Archived Technician</h3>
            <table class="table table-bordered table-hover text-center" id="fertilizerTbl">
                <thead class="table-danger text-center">
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Barangay</th>
                        <th scope="col">Account Status</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <!-- technician query start here -->
                    <?php
                    $technicianQuery = "SELECT * FROM mao_technician WHERE account_status = 'Inactive' OR account_status = 'Archived' ";
                    $technicianQueryResult = mysqli_query($conn, $technicianQuery);

                    if ($technicianQueryResult->num_rows > 0) {
                        while ($technician = $technicianQueryResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $technician['tech_fname'] ?></td>
                                <td><?= $technician['tech_lname'] ?></td>
                                <td><?= $technician['sex'] ?></td>
                                <td><?= $technician['email'] ?></td>
                                <td><?= $technician['barangay'] ?></td>
                                <td><?= $technician['account_status'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-outline-secondary p-0 px-3" type="button" data-bs-toggle="modal" data-bs-target="#viewTechnician<?= $technician['tech_id'] ?>" aria-controls="offcanvasExample">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success p-0 px-3" type="button" data-bs-toggle="modal" data-bs-target="#archiveTechnician<?= $technician['tech_id'] ?>">
                                        <i class="fa-solid fa-circle-up" data-bs-toggle="tooltip" title="Mark as Active?"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- technician query ends here -->

                            <!-- view profile modal -->
                            <div class="modal fade" id="viewTechnician<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered p-5">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <div class="row">
                                                <h2>Technician Profile</h2>
                                                <div class="border-bottom my-3"></div>
                                                <div class="col-4">
                                                    <div class="shadow shadow-lg rounded p-2 text-center align-items-center justify-self-center justify-content-center mt-4">
                                                        <img src="data:image/jpeg;base64,<?= base64_encode($technician['user_pic']) ?>" class="text-center" alt="user_picture" style="border-radius: 50%; border: 1px solid var(--success-subtle); width: 200px; height: 200px;">
                                                        <p class="fw-bold fs-4 mt-2">TECH. <?= $technician['user_name'] ?></p>
                                                        <?php
                                                        if ($technician['account_status'] == 'Inactive') {
                                                        ?>
                                                            <p class="fw-bold fs-5 text-warning mt-2">INACTIVE</p>
                                                        <?php
                                                        } elseif ($technician['account_status'] == 'Archived') {
                                                        ?>
                                                            <p class="fw-bold fs-5 text-danger mt-2">ARCHIVED</p>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="shadow shadow-lg p-3 rounded pt-5">
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="tech_fname" name="tech_fname" value="<?= $technician['tech_fname'] ?>" placeholder="First Name" disabled>
                                                                    <label for="tech_fname" class="fw-bold">First Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="tech_lname" name="tech_lname" value="<?= $technician['tech_lname'] ?>" placeholder="Last Name" disabled>
                                                                    <label for="tech_lname" class="fw-bold">Last Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control" id="email" name="email" value="<?= $technician['email'] ?>" placeholder="Email" disabled>
                                                                <label for="email" class="fw-bold mx-2">Email</label>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control w-100" id="email" name="email" value="<?= $technician['age'] ?>" placeholder="Email" disabled>
                                                                        <label for="age" class="fw-bold mx-2">Age</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control w-100" id="email" name="email" value="<?= $technician['birthday'] ?>" placeholder="Email" disabled>
                                                                        <label for="birthday" class="fw-bold mx-2">Birthday</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" value=" <?= $technician['barangay'] . ", " . $technician['municipality'] . ", " . $technician['province'] . ", " . $technician['region'] ?>" disabled>
                                                                <label for="floatingInputDisabled" class="fw-bold mx-2">Address</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" value="<?= $technician['cluster_id'] ?>" disabled>
                                                                <label for="floatingInputDisabled" class="fw-bold mx-2">Cluster</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- view profile modal -->

                            <!-- modal for inactive prompt -->
                            <div class="modal fade" id="inactiveModal<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <p class="h4 mb-2">
                                                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                Mark "<?= $technician['tech_fname'] . " " . $technician['tech_lname'] ?>" as an "Inactive"?
                                            </p>
                                            <button class="btn btn-secondary float-end ms-1" data-bs-dismiss="modal">Close</button>
                                            <a href="../function/technicianFunction.php?=<? $technician['tech_id'] ?>" class="btn btn-outline-danger float-end">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal for archiving tech -->
                            <div class="modal fade" id="archiveTechnician<?= $technician['tech_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-3">
                                            <p class="h4 mb-2">
                                                <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                                Bring back "<?= $technician['tech_fname'] . " " . $technician['tech_lname'] ?>" from being a Technician?
                                            </p>
                                            <button class="btn btn-secondary float-end ms-1" data-bs-dismiss="modal">Close</button>
                                            <a href="../function/technicianFunction.php?bringback_id=<?= $technician['tech_id'] ?>" class="btn btn-outline-success float-end">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- age calculator -->
<script>
    function calculateAge() {
        var birthdate = document.getElementById('birthdate').value;
        if (birthdate) {
            var birthDate = new Date(birthdate);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            document.getElementById('ageNow').value = age;
        } else {
            document.getElementById('ageNow').value = '';
        }
    }
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