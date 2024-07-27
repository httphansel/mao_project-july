<h2>FARMER DATA</h2>

<div class="d-flex text-end align-items-end justify-content-end">
    <button class="btn btn-outline-success p-3 fw-bold w-25 float-end me-2" style="border-radius: 0;"><i class="fa-solid fa-address-card"></i> Register a Farmer</button>
    <button class="btn btn-danger p-3 me-2 fw-bold w-25 float-end" style="border-radius: 0;"><i class="fa-solid fa-box-archive"></i> Archived Farmer</button>
</div>

<div class="row m-2 mt-3">
    <div class="shadow shadow-lg p-4">
        <h3><?= htmlspecialchars($cluster_id) ?> FARMER INFORMATION</h3>
        <table class="table table-light table-bordered table-hover" id="myTable">
            <thead class="table-success">
                <tr>
                    <th scope="col">Firstname</th>
                    <th scope="col">Middlename</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Barangay</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Mobile No.</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $farmerQuery = "
                    SELECT f.farmer_code, f.farmer_fname, f.farmer_mname, f.farmer_lname, f.farmer_extname, f.birthday, f.age, f.sex, f.barangay as farmers_barangay, f.phone_number, f.reg_date, c.cluster_id, c.barangay as cluster_barangays
                    FROM farmer f
                    JOIN cluster c ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                    WHERE c.cluster_id = '$cluster_id' 
                ";
                $farmerQueryResult = mysqli_query($conn, $farmerQuery);

                if ($farmerQueryResult && $farmerQueryResult->num_rows > 0) {
                    while ($farmer = $farmerQueryResult->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($farmer['farmer_fname']) ?></td>
                            <td><?= htmlspecialchars($farmer['farmer_mname']) ?></td>
                            <td><?= htmlspecialchars($farmer['farmer_lname']) ?></td>
                            <td><?= htmlspecialchars($farmer['farmers_barangay']) ?></td>
                            <td><?= htmlspecialchars($farmer['sex']) ?></td>
                            <td><?= htmlspecialchars($farmer['phone_number']) ?></td>
                            <td class="d-flex text-center">
                                <a href="" class="nav-link p-0 text-primary me-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight<?= htmlspecialchars($farmer['farmer_code']) ?>" aria-controls="offcanvasRight">
                                    <i class="fa-solid fa-circle-info"></i> View
                                </a>
                                | 
                                <a href="" class="nav-link p-0 text-success btn-success ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightUpdate<?= htmlspecialchars($farmer['farmer_code']) ?>" aria-controls="offcanvasRightUpdate">
                                    Update <i class="fa-solid fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Offcanvas for viewing farmer details -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight<?= htmlspecialchars($farmer['farmer_code']) ?>" aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Farmer Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['farmer_fname']) ?>" placeholder="Firstname" disabled>
                                    <label>FIRSTNAME</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['farmer_mname']) ?>" placeholder="Middlename" disabled>
                                    <label>MIDDLENAME</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['farmer_lname']) ?>" placeholder="Lastname" disabled>
                                    <label>LASTNAME</label>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" value="<?= htmlspecialchars($farmer['birthday']) ?>" placeholder="Birthday" disabled>
                                            <label>BIRTHDAY</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['age']) ?>" placeholder="Age" disabled>
                                            <label>AGE</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['sex']) ?>" placeholder="Sex" disabled>
                                            <label>SEX</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['phone_number']) ?>" placeholder="Phone Number" disabled>
                                            <label>PHONE NO.</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($farmer['farmers_barangay']) ?>" placeholder="Barangay" disabled>
                                            <label>BARANGAY</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="date" class="form-control" value="<?= htmlspecialchars($farmer['reg_date']) ?>" placeholder="Registration Date" disabled>
                                    <label>REGISTRATION DATE</label>
                                </div>
                                <div class="border-bottom my"></div>
                                <h4>LIVESTOCK OWNED</h4>
                                <?php
                                $farmer_code = $farmer['farmer_code'];
                                $livestockQuery = "
                                    SELECT ls.livestock_type, ls.livestock_quantity
                                    FROM livestock ls
                                    WHERE ls.farmer_code = '$farmer_code'
                                ";
                                $livestockResult = mysqli_query($conn, $livestockQuery);
                                if ($livestockResult && $livestockResult->num_rows > 0) {
                                    while ($livestock = $livestockResult->fetch_assoc()) {
                                        echo "<p>" . htmlspecialchars($livestock['livestock_quantity']) . " " . htmlspecialchars($livestock['livestock_type']) ."/s </p>";
                                    }
                                } else {
                                    echo "<p>No livestock owned</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Offcanvas for updating farmer details -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightUpdate<?= htmlspecialchars($farmer['farmer_code']) ?>" aria-labelledby="offcanvasRightLabelUpdate">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabelUpdate">Update Farmer Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                                <form action="" method="post">

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
