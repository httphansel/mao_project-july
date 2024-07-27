<?php
    $cropQuery = "SELECT COUNT(*) as count FROM inventory WHERE item_category = 'Crop Seed' ";
    $cropResult = mysqli_query($conn, $cropQuery);
    $cropCountRow = mysqli_fetch_assoc($cropResult);
    $cropCount = $cropCountRow['count'];

    $cropFertilizerQuery = "SELECT COUNT(*) as count FROM inventory WHERE item_category = 'Crop Fertilizer' ";
    $cropFertilizerResult = mysqli_query($conn, $cropFertilizerQuery);
    $cropFertilizerCountRow = mysqli_fetch_assoc($cropFertilizerResult);
    $cropFertilizerCount = $cropFertilizerCountRow['count'];

    $medicineQuery = "SELECT COUNT(*) as count FROM inventory WHERE item_category = 'Animal Medicine' ";
    $medicineResult = mysqli_query($conn, $medicineQuery);
    $medicineCountRow = mysqli_fetch_assoc($medicineResult);
    $medicineCount = $medicineCountRow['count'];
?>
<h2 class="mb-3">DISTRIBUTION PAGE</h2>

<div class="row p-3 mb-3">
    <div class="col">
        <div class="shadow p-4 rounded">
            <p class="h5 text-dark">Monthly Chart</p>
            <!-- distributed query start -->
            <?php
            $distributedQuery = "SELECT 
                    DATE_FORMAT(date_distributed, '%M %Y') AS month,
                    item_name,
                    SUM(item_quantity) AS total_quantity
                    FROM distributed_item
                    GROUP BY month, item_name
                    ORDER BY date_distributed";
            $distributedQueryResult = mysqli_query($conn, $distributedQuery);

            $data = [];
            $items = [];
            if ($distributedQueryResult->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($distributedQueryResult)) {
                    $data[] = $row;
                    if (!in_array($row['item_name'], $items)) {
                        $items[] = $row['item_name'];
                    }
                }
            } else {
                echo "<p class='text-white fs-1'>No Data Available</p>";
            }
            ?>
            <!-- distributed query end -->
            <div id="chart_div" style="width: 100%; height: 300px;"></div>
        </div>
    </div>
    <div class="col">
        <div class="shadow shadow-lg p-3 rounded">
            <div class="row p-3">
                <!-- distribute form here -->
                <div class="col">
                    <button class="btn btn-success p-0 px-3 w-100" data-bs-toggle="modal" data-bs-target="#distributeModal">
                        <div class="d-flex m-0 mt-3">
                            <p class="fs-3">
                                <i class="fa-solid fa-square-up-right"></i>
                            </p>
                            <h5 class="ms-auto mt-3">
                                DISTRIBUTE
                            </h5>
                        </div>
                    </button>
                </div>

                <div class="modal fade" id="distributeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2 class="text-center"><i class="fa-solid fa-truck"></i> Distribute Items</h2>
                                <div class="border-bottom my-3"></div>
                                <form action="../function/adminFunction.php" method="post">
                                    <div class="row">
                                        <div class="col">
                                            <label for="item_name" class="form-label fw-bold">Item Name:</label>
                                            <select class="form-select" name="item_name" aria-label="Default select example">
                                                <option selected>Select Item to Distribute</option>
                                                <option></option>
                                                <?php
                                                $availableItemQuery = "SELECT * FROM inventory WHERE item_quantity != 0 ";
                                                $availableItemResult = mysqli_query($conn, $availableItemQuery);

                                                if ($availableItemResult->num_rows > 0) {
                                                    while ($availableItems = $availableItemResult->fetch_assoc()) {
                                                ?>
                                                        <option value="<?= $availableItems['item_name'] ?>"><?= $availableItems['item_name'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="item_quantity" class="form-label fw-bold">Quantity:</label>
                                                    <input type="number" class="form-control mb-3" name="item_quantity" autocomplete="off" required>
                                                </div>
                                                <div class="col">
                                                    <label for="barangay" class="form-label fw-bold">Cluster:</label>
                                                    <select class="form-select" name="cluster_id" aria-label="Default select example">
                                                        <option selected></option>
                                                        <?php
                                                        $barangayQuery = "SELECT * FROM mao_technician WHERE account_status = 'Active' ";
                                                        $barangayResult = mysqli_query($conn, $barangayQuery);

                                                        if ($barangayResult->num_rows > 0) {
                                                            while ($barangay = $barangayResult->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?= $barangay['cluster_id'] ?>"><?= $barangay['cluster_id'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <button class="btn btn-outline-success fw-bold mt-2 float-end" name="distributeBtn">Distribute</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- requested items -->
                <div class="col">
                    <button class="btn btn-outline-success fw-bold p-0 px-3 w-100" data-bs-toggle="modal" data-bs-target="#requestedItemModal">
                        <div class="d-flex m-0 mt-3">
                            <p class="fs-3">
                                <i class="fa-solid fa-hand"></i>
                            </p>
                            <h5 class="ms-auto mt-2">
                                ITEM REQUEST
                                <?php
                                $requestQuery = "SELECT COUNT(*) as count FROM tech_inventory WHERE distribution_status = 'Requested' ";
                                $requestResult = mysqli_query($conn, $requestQuery);
                                $requestCountRow = mysqli_fetch_assoc($requestResult);
                                $requestCount = $requestCountRow['count'];
                                if ($requestCount > 0) : ?>
                                    <span class="translate-middle badge rounded-pill bg-danger ms-3">
                                        <?= $requestCount ?>
                                        <span class="visually-hidden">request</span>
                                    </span>
                                <?php endif; ?>
                            </h5>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <h4 class="text-center">AVAILABLE ITEMS</h4>
                <div class="border-bottom"></div>
                <div class="row text-center mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-success h1"><i class="fa-solid fa-leaf"></i></h5>
                                <p class="card-text fs-1 fw-bold"><?= $cropCount ?> <br> <span class="fs-3">Crop Seed</span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-success-subtle h1"><i class="fa-brands fa-pagelines"></i></h5>
                                <p class="card-text fs-1 fw-bold"><?= $cropFertilizerCount ?> <br> <span class="fs-5">Crop Fertilizer</span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-warning h1"><i class="fa-solid fa-capsules"></i></h5>
                                <p class="card-text fs-1 fw-bold"><?= $medicineCount ?> <br> <span class="fs-5">Animal Medicine</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row p-3">
    <div class="shadow shadow-lg p-4 rounded">
        <h3>Technician Distribution History</h3>
        <table class="table table-bordered table-hover" id="myTable">
            <thead class="table-success text-center">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Variety</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Quantity Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Farmer Name</th>
                    <th scope="col">Barangay</th>
                </tr>
            </thead>
            <tbody class="table-light">
                <!-- distributed query start here -->
                <?php
                $distributedQuery = "SELECT d.item_name, d.item_quantity, d.date_distributed, f.farmer_code, f.farmer_fname, f.farmer_lname, f.barangay, i.item_variety, i.quantity_type
                    FROM distributed_item d 
                    JOIN farmer f ON d.farmer_code = f.farmer_code
                    JOIN inventory i ON i.item_name = d.item_name";
                $distributedQueryResult = mysqli_query($conn, $distributedQuery);

                if ($distributedQueryResult->num_rows > 0) {
                    while ($distributed = $distributedQueryResult->fetch_assoc()) {
                        $farmer = $distributed['farmer_fname'] . " " . $distributed['farmer_lname'];
                ?>
                        <tr>
                            <td><?= $distributed['item_name'] ?></td>
                            <td><?= $distributed['item_variety'] ?></td>
                            <td><?= $distributed['item_quantity'] ?></td>
                            <td><?= $distributed['quantity_type'] ?></td>
                            <td><?= $distributed['date_distributed'] ?></td>
                            <td><?= $farmer ?></td>
                            <td><?= $distributed['barangay'] ?></td>
                        </tr>
                        <!-- distributed query ends here -->

                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row p-5">
    <div class="shadow shadow-lg p-5 rounded bg-success-subtle">
        <h3>Admin Distribution History</h3>
        <table class="table table-bordered table-hover" id="distributionTable">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Variety</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Quantity Type</th>
                    <th scope="col">Distribution Date</th>
                    <th scope="col">Technician</th>
                    <th scope="col">Cluster</th>
                </tr>
            </thead>
            <tbody class="table-light">
                <!-- distributed by admin query start here -->
                <?php
                $distributedQuery = "SELECT ti.item_name, ti.item_quantity, ti.cluster_id, ti.distribution_date, i.item_variety, i.quantity_type, i.item_category, i.exp_date, mt.tech_fname, mt.tech_lname, mt.barangay
                FROM tech_inventory ti
                JOIN inventory i ON ti.item_name = i.item_name
                JOIN mao_technician mt ON ti.cluster_id = mt.cluster_id
                WHERE distribution_status = 'Approved' ";
                $distributedResult = mysqli_query($conn, $distributedQuery);

                if ($distributedResult->num_rows > 0) {
                    while ($adminDistributed = $distributedResult->fetch_assoc()) {
                        $technician = $adminDistributed['tech_fname'] . " " . $adminDistributed['tech_lname'];
                        $barangay = $adminDistributed['barangay']; // Adjust this if barangay is stored differently
                ?>
                        <tr>
                            <td><?= htmlspecialchars($adminDistributed['item_name']) ?></td>
                            <td><?= htmlspecialchars($adminDistributed['item_variety']) ?></td>
                            <td><?= htmlspecialchars($adminDistributed['item_quantity']) ?></td>
                            <td><?= htmlspecialchars($adminDistributed['quantity_type']) ?></td>
                            <td><?= htmlspecialchars($adminDistributed['distribution_date']) ?></td>
                            <td><?= htmlspecialchars($technician) ?></td>
                            <td><?= htmlspecialchars($adminDistributed['cluster_id']) ?></td> <!-- Display barangay here -->
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center text-danger">No items found.</td></tr>';
                }
                ?>
                <!-- distributed by admin query ends here -->
            </tbody>

        </table>
    </div>
</div>

<!-- /* requested modal */ -->
<div class="modal fade" id="requestedItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <h2>Requested Items</h2>
            <div class="border-bottom my-3"></div>
            <table class="table table-bordered table-hover" id="distributionTable">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Variety</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Quantity Type</th>
                        <th scope="col">Distribution Date</th>
                        <th scope="col">Technician</th>
                        <th scope="col">Cluster</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <!-- distributed by admin query start here -->
                    <?php
                    $distributedQuery = "SELECT ti.distribution_id, ti.item_name, ti.item_quantity, ti.cluster_id, ti.distribution_date, i.item_variety, i.quantity_type, i.item_category, i.exp_date, mt.tech_fname, mt.tech_lname, mt.barangay
                    FROM tech_inventory ti
                    JOIN inventory i ON ti.item_name = i.item_name
                    JOIN mao_technician mt ON ti.cluster_id = mt.cluster_id
                    WHERE distribution_status = 'Requested' ";
                    $distributedResult = mysqli_query($conn, $distributedQuery);

                    if ($distributedResult->num_rows > 0) {
                        while ($adminDistributed = $distributedResult->fetch_assoc()) {
                            $technician = $adminDistributed['tech_fname'] . " " . $adminDistributed['tech_lname'];
                            $barangay = $adminDistributed['barangay']; // Adjust this if barangay is stored differently
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($adminDistributed['item_name']) ?></td>
                                <td><?= htmlspecialchars($adminDistributed['item_variety']) ?></td>
                                <td><?= htmlspecialchars($adminDistributed['item_quantity']) ?></td>
                                <td><?= htmlspecialchars($adminDistributed['quantity_type']) ?></td>
                                <td><?= htmlspecialchars($adminDistributed['distribution_date']) ?></td>
                                <td><?= htmlspecialchars($technician) ?></td>
                                <td><?= htmlspecialchars($adminDistributed['cluster_id']) ?></td> 
                                <td class="text-center">
                                    <a href="../function/approveRequest.php?distribution_id=<?= $adminDistributed['distribution_id'] ?>" class="btn btn-secondary p-0 px-3 text-center">Approve</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <!-- distributed by admin query ends here -->
                </tbody>

            </table>
        </div>
    </div>
</div>
</div>

<!-- google chart  js -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // script ng bar chart dito
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', <?php echo "'" . implode("','", $items) . "'"; ?>],
            <?php
            $monthlyData = [];
            foreach ($data as $row) {
                $month = $row['month'];
                $item = $row['item_name'];
                $quantity = $row['total_quantity'];
                if (!isset($monthlyData[$month])) {
                    $monthlyData[$month] = array_fill(0, count($items), 0);
                }
                $itemIndex = array_search($item, $items);
                $monthlyData[$month][$itemIndex] = $quantity;
            }
            foreach ($monthlyData as $month => $quantities) {
                echo "['$month', " . implode(", ", $quantities) . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Distributed Items per Month',
            hAxis: {
                title: 'Month'
            },
            vAxis: {
                title: 'Total Quantity'
            },
            bars: 'vertical',
            height: 300,
            series: {
                <?php
                foreach ($items as $index => $item) {
                    // Define fixed colors here
                    $colors = ['#3366CC', '#DC3912', '#FF9900', '#109618', '#990099', '#0099C6', '#DD4477', '#66AA00', '#B82E2E', '#316395', '#994499', '#22AA99', '#AAAA11', '#6633CC', '#E67300', '#8B0707', '#329262', '#5574A6', '#3B3EAC', '#B77322', '#16D620', '#B91383', '#F4359E', '#9C5935', '#A9C413', '#2A778D', '#668D1C', '#BEA413', '#0C5922', '#743411'];
                    echo $index . ": { color: '" . $colors[$index % count($colors)] . "' },";
                }
                ?>
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>