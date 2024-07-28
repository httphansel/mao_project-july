<h2>RESIDENT DATA</h2>

<div class="d-flex align-items-end justify-content-end">
    <button class="btn btn-outline-success p-3 fw-bold w-25 float-end me-2" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#addResidentData">
        <i class="fa-solid fa-address-card"></i> Register a Resident
    </button>

    <!-- <button class="btn btn-danger p-3 me-2 fw-bold w-25 float-end" style="border-radius: 0;">
        <i class="fa-solid fa-box-archive"></i> Archived Resident
    </button> -->
    <!-- archived farmer modal table -->
</div>

<!-- add resident data modal -->
<div class="modal fade" id="addResidentData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h2>REGISTER A RESIDENT</h2>
                <div class="border-bottom my-2"></div>
                <form action="tech-function/function.php" method="post" id="technicianForm" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <div class="row mb-3 g-1">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" id="fname" name="resident_fname" placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingInput" class="">FIRSTNAME</label>
                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" id="m_name" name="resident_mname" placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingInput" class="">MIDDLENAME</label>
                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" id="l_name" name="resident_lname" placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingInput" class="">LASTNAME</label>
                                <span id="errorText" class="text-danger" style="display:none;">Numbers are not allowed</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="resident_extname" autocomplete="off" required>
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
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control w-100" id="name" name="phone_number" placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingInput" class="">PHONE NO.</label>
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-success fw-bold p-2 px-3 float-end" style="border-radius: 0;" name="registerFarmerBtn">
                                REGISTER
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- farmer table here -->
<div class="row m-2 mt-3">
    <div class="shadow shadow-lg p-4">
        <h3><?= htmlspecialchars($cluster_id) ?> RESIDENT INFORMATION</h3>
        <table class="table table-light table-bordered table-hover" id="myTable">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Firstname</th>
                    <th scope="col">Middlename</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Barangay</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $residentQuery = "
                    SELECT rs.resident_code, 
                    rs.resident_fname, 
                    rs.resident_mname, 
                    rs.resident_lname, 
                    rs.resident_extname, 
                    rs.birthday, 
                    rs.age, 
                    rs.sex, 
                    rs.barangay as residents_barangay, 
                    rs.reg_date, 
                    c.cluster_id, 
                    c.barangay as cluster_barangays
                    FROM resident rs
                    JOIN cluster c ON FIND_IN_SET(rs.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                    WHERE c.cluster_id = '$cluster_id' 
                ";
                $residentQueryResult = mysqli_query($conn, $residentQuery);

                if ($residentQueryResult && $residentQueryResult->num_rows > 0) {
                    while ($resident = $residentQueryResult->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= htmlspecialchars($resident['resident_fname']) ?></td>
                            <td><?= htmlspecialchars($resident['resident_mname']) ?></td>
                            <td><?= htmlspecialchars($resident['resident_lname']) ?></td>
                            <td><?= htmlspecialchars($resident['residents_barangay']) ?></td>
                            <td><?= htmlspecialchars($resident['sex']) ?></td>
                            <td class="d-flex text-center">
                                <a href="" class="nav-link p-0 text-primary me-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#viewResident<?= htmlspecialchars($resident['resident_code']) ?>" aria-controls="offcanvasRight">
                                    <i class="fa-solid fa-circle-info"></i> View
                                </a>
                                |
                                <a href="" class="nav-link p-0 text-success btn-success ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightUpdate<?= htmlspecialchars($resident['resident_code']) ?>" aria-controls="offcanvasRightUpdate">
                                    Update <i class="fa-solid fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Offcanvas for viewing resident details -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="viewResident<?= htmlspecialchars($resident['resident_code']) ?>" aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Resident Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($resident['resident_fname']) ?>" placeholder="Firstname" disabled>
                                    <label>FIRSTNAME</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($resident['resident_mname']) ?>" placeholder="Middlename" disabled>
                                    <label>MIDDLENAME</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($resident['resident_lname']) ?>" placeholder="Lastname" disabled>
                                    <label>LASTNAME</label>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" value="<?= htmlspecialchars($resident['birthday']) ?>" placeholder="Birthday" disabled>
                                            <label>BIRTHDAY</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($resident['age']) ?>" placeholder="Age" disabled>
                                            <label>AGE</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($resident['sex']) ?>" placeholder="Sex" disabled>
                                            <label>SEX</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($resident['phone_number']) ?>" placeholder="Phone Number" disabled>
                                            <label>PHONE NO.</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($resident['residents_barangay']) ?>" placeholder="Barangay" disabled>
                                            <label>BARANGAY</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="date" class="form-control" value="<?= htmlspecialchars($resident['reg_date']) ?>" placeholder="Registration Date" disabled>
                                    <label>REGISTRATION DATE</label>
                                </div>
                                <div class="border-bottom my"></div>
                                <h4>LIVESTOCK OWNED</h4>
                                <?php
                                $resident_code = $resident['resident_code'];
                                $petQuery = "
                                    SELECT ls.pet_type, ls.pet_quantity
                                    FROM pet ls
                                    WHERE ls.resident_code = '$resident_code'
                                ";
                                $petResult = mysqli_query($conn, $petQuery);
                                if ($petResult && $petResult->num_rows > 0) {
                                    while ($pet = $petResult->fetch_assoc()) {
                                        echo "<p>" . htmlspecialchars($pet['pet_quantity']) . " " . htmlspecialchars($pet['pet_type']) . "/s </p>";
                                    }
                                } else {
                                    echo "<p>No pet owned</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Offcanvas for updating resident details -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightUpdate<?= htmlspecialchars($resident['resident_code']) ?>" aria-labelledby="offcanvasRightLabelUpdate">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabelUpdate">Update Farmer Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                                <form action="" method="post">
                                    asdasdsd
                                </form>
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
    document.getElementById('fname').addEventListener('input', function(event) {
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