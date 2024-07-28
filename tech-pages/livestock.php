<h2>LIVESTOCK AND PET</h2>

<div class="row p-2">
    <div class="col-4">
        <div class="shadow p-3">
            <div class="row g-3">
                <div class="col bg-success-subtle p-3">
                    <h5 class="text-center"><i class="fa-solid fa-feather-pointed"></i> Livestock Registration</h5>
                    <div class="border-bottom my-3"></div>
                    <form action="tech-function/function.php" method="post">
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="farmer_code" required>
                                <option selected>Open this select farmer</option>
                                <option value=""></option>
                                <?php
                                $farmerOption = "SELECT f.farmer_code, f.farmer_fname, f.farmer_lname, f.barangay as farmer_brgy, c.cluster_id, c.barangay as cluster_brgy
                                                    FROM farmer f
                                                    JOIN cluster c
                                                    ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                                                    WHERE cluster_id = '$cluster_id' ";
                                $farmerOptionResult = mysqli_query($conn, $farmerOption);

                                if ($farmerOptionResult->num_rows > 0) {
                                    while ($farmers = $farmerOptionResult->fetch_assoc()) {
                                        $farmerName = $farmers['farmer_fname'] . " " . $farmers['farmer_lname'];
                                ?>
                                        <option value="<?= $farmers['farmer_code'] ?>"><?= $farmers['farmer_code'] ?>: <?= $farmerName ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <label for="floatingSelect">Select Farmer</label>
                        </div>
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="livestock_category" required>
                                <option selected>Category</option>
                                <option value=""></option>
                                <option value="Backyard">Backyard</option>
                                <option value="Farm">Farm</option>
                                <option value="Poultry">Poultry</option>
                            </select>
                            <label for="floatingSelect">Livestock Category</label>
                        </div>
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="livestock_type" required>
                                <option selected>Select Livestock Type</option>
                                <option value="Chicken">Chicken</option>
                                <option value="Cow">Cow</option>
                                <option value="Carabao">Carabao</option>
                                <option value="Duck">Duck</option>
                                <option value="Goat">Goat</option>
                                <option value="Sheep">Sheep</option>
                                <option value="Goose">Goose</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Rabbit">Rabbit</option>
                                <option value="Pig">Pig</option>
                                <option value="Horse">Horse</option>
                            </select>
                            <label for="floatingSelect">Livestock Category</label>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="livestock_age" required>
                                    <label for="floatingPassword">Livestock Age</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" id="floatingPassword" placeholder="Password" name="livestock_quantity" required>
                                    <label for="floatingPassword">Quantity</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="livestock_status" required>
                                <option selected>Select Livestock Status</option>
                                <option></option>
                                <option value="Healthy">Healthy</option>
                                <option value="Sick">Sick</option>
                                <option value="Deceased">Deceased</option>
                                <option value="Sold">Sold</option>
                                <option value="Butcher">Butcher</option>
                            </select>
                            <label for="floatingSelect">Livestock Status</label>
                        </div>
                        <button class="btn btn-secondary w-25 float-end fw-bold" style="border-radius: 0;" name="addLivestockBtn">
                            <i class="fa-solid fa-registered"></i> ADD
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-bottom my-3 p-0 px-0"></div>
            <div class="row g-3">
                <div class="col bg-secondary-subtle p-3">
                    <h5 class="text-center"><i class="fa-solid fa-paw"></i> Pet Registration</h5>
                    <div class="border-bottom my-3"></div>
                    <form action="tech-function/function.php" method="post">
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="resident_code" required>
                                <option selected>Select Resident</option>
                                <option></option>
                                <?php
                                $residentOption = "SELECT f.resident_code, f.resident_fname, f.resident_lname, f.barangay as resident_brgy, c.cluster_id, c.barangay as cluster_brgy
                                                    FROM resident f
                                                    JOIN cluster c
                                                    ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                                                    WHERE cluster_id = '$cluster_id' ";
                                $residentOptionResult = mysqli_query($conn, $residentOption);

                                if ($residentOptionResult->num_rows > 0) {
                                    while ($residents = $residentOptionResult->fetch_assoc()) {
                                        $residentName = $residents['resident_fname'] . " " . $residents['resident_lname'];
                                ?>
                                        <option value="<?= $residents['resident_code'] ?>"><?= $residents['resident_code'] ?>: <?= $residentName ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <label for="floatingSelect">Livestock Resident</label>
                        </div>
                        <div class="form-floating mb-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="pet_type" required>
                                <option selected>Select Pet Type</option>
                                <option></option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Bird">Bird</option>
                                <option value="Other.">Other.</option>
                            </select>
                            <label for="floatingSelect">Pet Type</label>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="pet_name" required>
                                    <label for="floatingPassword">Pet Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="pet_color" required>
                                    <label for="floatingPassword">Pet Color</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="pet_breed" required>
                                    <label for="floatingPassword">Pet Breed</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="pet_age" required>
                                    <label for="floatingPassword">Pet Age</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success w-25 float-end fw-bold" style="border-radius: 0;" name="addPetBtn">
                            <i class="fa-solid fa-registered"></i> ADD
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="shadow shadow-lg p-2" id="bar_chart_div" style="height: 300px; width: 99%;"></div>

        <div class="shadow p-3 mt-4">
            <h4 class="text-center pt-2">LIVESTOCK INFORMATION</h4>
            <div class="border-bottom my-3"></div>
            <table class="table table-light table-hover table-bordered" id="myTable">
                <thead class="table-success">
                    <tr>
                        <th scope="col">Farmer</th>
                        <th scope="col">Livestock</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Age</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $livestockQuery = "
            SELECT 
                ls.farmer_code, 
                ls.livestock_type, 
                ls.livestock_quantity, 
                ls.livestock_age, 
                ls.livestock_status,
                f.farmer_code, 
                f.farmer_fname, 
                f.farmer_lname, 
                f.barangay as farmer_barangay,
                c.cluster_id, 
                c.barangay as cluster_barangay
            FROM 
                livestock ls
            JOIN 
                farmer f ON ls.farmer_code = f.farmer_code
            JOIN 
                cluster c ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
            WHERE 
                c.cluster_id = '$cluster_id' 
        ";
                    $livestockResult = mysqli_query($conn, $livestockQuery);

                    if ($livestockResult && $livestockResult->num_rows > 0) {
                        while ($livestock = $livestockResult->fetch_assoc()) {
                            $farmer = htmlspecialchars($livestock['farmer_fname']) . " " . htmlspecialchars($livestock['farmer_lname']);
                    ?>
                            <tr>
                                <td><?= $farmer ?></td>
                                <td><?= htmlspecialchars($livestock['livestock_type']) ?></td>
                                <td><?= htmlspecialchars($livestock['livestock_quantity']) ?></td>
                                <td><?= htmlspecialchars($livestock['livestock_age']) ?></td>
                                <td><?= htmlspecialchars($livestock['livestock_status']) ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <div class="shadow p-3 mt-4">
            <h4 class="text-center pt-2">PET INFORMATION</h4>
            <div class="border-bottom my-3"></div>
            <table class="table table-light table-hover table-bordered" id="fertilizerTbl">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Resident</th>
                        <th scope="col">Pet</th>
                        <th scope="col">Name</th>
                        <th scope="col">Breed</th>
                        <th>Color</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $petQuery = "SELECT
                        p.resident_code,
                        p.pet_type,
                        p.pet_name,
                        p.pet_breed,
                        p.pet_color,
                        p.pet_age,
                        r.resident_code,
                        r.resident_fname,
                        r.resident_lname,
                        r.barangay as resident_barangay,
                        c.cluster_id,
                        c.barangay as cluster_barangay
                        FROM pet p
                        JOIN resident r ON p.resident_code = r.resident_code
                        JOIN cluster c ON FIND_IN_SET(r.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                        WHERE c.cluster_id = '$cluster_id' ";
                        $petResult = mysqli_query($conn, $petQuery);

                        if ($petResult && $petResult->num_rows > 0) {
                            while ($pet = $petResult->fetch_assoc()) {
                            $resident = htmlspecialchars($pet['resident_fname']) . " " . htmlspecialchars($pet['resident_lname']);
                    ?>
                    <tr>
                        <td><?= $resident ?></td>
                        <td><?= htmlspecialchars($pet['pet_type']) ?></td>
                        <td><?= htmlspecialchars($pet['pet_name']) ?></td>
                        <td><?= htmlspecialchars($pet['pet_breed']) ?></td>
                        <td><?= htmlspecialchars($pet['pet_color']) ?></td>
                        <td><<?= htmlspecialchars($pet['pet_age']) ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Animal', 'Count', {
                role: 'style'
            }],
            <?php
            $colors = ['#FF5733', '#3357FF', '#FF33A1', '#FFC133', '#57FF33', '#A133FF'];
            $colorIndex = 0;

            $query = "SELECT livestock_type, SUM(livestock_quantity) AS total_quantity FROM livestock GROUP BY livestock_type";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $color = $colors[$colorIndex % count($colors)];
                    echo "['" . $row['livestock_type'] . "', " . $row['total_quantity'] . ", '" . $color . "'],";
                    $colorIndex++;
                }
            } else {
                echo "['No Data', 0, '#000000'],";
            }
            ?>
        ]);

        var options = {
            title: 'Registered Livestock Data',
            chartArea: {
                width: '50%'
            },
            hAxis: {
                title: 'Total Count',
                minValue: 0
            },
            vAxis: {
                title: 'Livestock Type'
            },
            legend: {
                position: 'none'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
        chart.draw(data, options);
    }
</script>