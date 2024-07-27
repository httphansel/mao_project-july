<h2>DASHBOARD</h2>

<!-- buttons graph row -->
<div class="row mt-3 p-2">
    <!-- main col buttons -->
    <div class="col">
        <div class="row g-2">
            <div class="col">
                <div class="row g-2 mt-3">
                    <div class="col-6">
                        <a class="shadow shadow-ls p-4 rounded d-flex nav-link text-dark" id="pageBtn" href="page.php?page=inventory">
                            <p class="fs-1 me-1">
                                <i class="fa-solid fa-warehouse fs-1 me-1"></i>
                            </p>
                            <h3 class="linkBtn mt-3">
                                Inventory
                            </h3>
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="shadow shadow-ls p-4 rounded d-flex nav-link text-dark" id="pageBtn" href="page.php?page=distributed">
                            <p class="fs-1 me-1">
                                <i class="fa-solid fa-square-up-right"></i>
                            </p>
                            <h3 class="linkBtn mt-3">Distributed</h3>
                        </a>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-6">
                        <a class="shadow shadow-ls p-4 rounded d-flex nav-link text-dark" id="pageBtn" href="page.php?page=technician">
                            <p class="fs-1 me-1">
                                <i class="fa-solid fa-users-gear"></i>
                            </p>
                            <h3 class="linkBtn mt-3">Technician</h3>
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="shadow shadow-ls p-4 rounded d-flex nav-link text-dark" id="pageBtn" href="page.php?page=certificates">
                            <p class="fs-1 me-1">
                                <i class="fa-solid fa-certificate"></i>
                            </p>
                            <h3 class="linkBtn mt-3">Certificate</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- col for bar graph -->
    <?php
    // Query ng livestock data
    $livestockQuery = "SELECT livestock_type, livestock_quantity FROM livestock";
    $livestockResult = $conn->query($livestockQuery);

    $data = [];
    while ($livestock = $livestockResult->fetch_assoc()) {
        $data[] = [$livestock['livestock_type'], (int)$livestock['livestock_quantity']];
    }
    ?>
    <div class="col">
        <div class="shadow shadow-lg p-3 rounded bg-success-subtle">
            <div class="col">
                <div class="col" style="border: 1px solid green; border-radius: 5px;">
                    <div id="myChart" style="width: 100%; height: 280px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- table row -->
<div class="row mt-3 p-3">
    <div class="shadow shadow-lg p-5 rounded bg-light-subtle">
        <h1>Account Log</h1>
        <table id="myTable" class="table table-bordered text-center table-hover">
            <thead class="table-success">
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                    <th scope="col">Time</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>

            <tbody class="table-light">
                <?php
                $account_logQuery  = "SELECT * FROM account_log ORDER BY log_date ASC";
                $account_logResult = mysqli_query($conn, $account_logQuery);

                if ($account_logResult->num_rows > 0) {
                    while ($account_log = $account_logResult->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $account_log['user_name'] ?></td>
                            <td><?= $account_log['user_type'] ?></td>
                            <td><?= $account_log['user_action'] ?></td>
                            <td><?= $account_log['log_time'] ?></td>
                            <td><?= $account_log['log_date'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>

        </table>
    </div>
</div>

<!-- google chart js -->
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    /* chart script dito */
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Livestock Type', 'Quantity'],
            <?php
            foreach ($data as $row) {
                echo "['{$row[0]}', {$row[1]}],";
            }
            ?>
        ]);

        var options = {
            title: 'Livestock Data',
            hAxis: {
                title: 'Livestock Type'
            },
            vAxis: {
                title: 'Quantity'
            },
            bars: 'vertical'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('myChart'));

        chart.draw(data, options);
    }
</script>