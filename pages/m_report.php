<div class="shadow shadow-lg p-4 rounded">
    <h2 class="text-center">Monthly Report</h2>

    <div class="row">
        <div class="col-6">
            <!-- Placeholder content -->
        </div>
        <div class="col-6 float-end justify-content-end align-items-end text-end">
            <h4>Select Date to Generate Data</h4>
            <form action="" method="post">
                <div class="row float-end mt-2 gx-2">
                    <div class="col">
                        <input type="date" class="form-control" name="dateFrom">
                    </div>
                    <div class="col mt-2">
                        <p class="fw-bold">-</p>
                    </div>
                    <div class="col">
                        <input type="date" class="form-control mb-2" name="dateTo">
                        <button class="btn btn-outline-success float-end" name="generateDataBtn">Generate</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="border-bottom my-3"></div>

<div class="row">
    <div class="col p-3">
        <?php
        if (isset($_POST['generateDataBtn'])) {
            $startDate = mysqli_real_escape_string($conn, $_POST['dateFrom']);
            $endDate = mysqli_real_escape_string($conn, $_POST['dateTo']);

            $monthReportQuery = "SELECT
                                    'Register Farmer' AS description, f.farmer_code AS item_id, CONCAT(f.farmer_fname, ' ', f.farmer_mname, ' ', f.farmer_lname) AS item_name, f.reg_date AS item_date
                                FROM farmer f
                                WHERE f.reg_date BETWEEN '$startDate' AND '$endDate'
                                UNION ALL
                                SELECT
                                    'Added Item in Inventory' AS description, i.item_id, i.item_name, i.date_added
                                FROM inventory i
                                WHERE i.date_added BETWEEN '$startDate' AND '$endDate'
                                UNION ALL
                                SELECT
                                    'Registered Livestock' AS description, ls.livestock_id, ls.livestock_type, ls.reg_date
                                FROM livestock ls
                                WHERE ls.reg_date BETWEEN '$startDate' AND '$endDate'
                                UNION ALL
                                SELECT
                                    'Registered Pet' AS description, p.pet_id, CONCAT(p.pet_name, ' - ', p.pet_breed) AS item_name, p.reg_date
                                FROM pet p
                                WHERE p.reg_date BETWEEN '$startDate' AND '$endDate'
                                UNION ALL
                                SELECT
                                    'Item Distributed' AS description, id.distribution_id, CONCAT(id.item_name, ' - ', id.item_quantity) AS item_name, id.distribution_date
                                FROM tech_inventory id
                                WHERE id.distribution_date BETWEEN '$startDate' AND '$endDate'
                                UNION ALL
                                SELECT
                                    'Generated Document' AS description, dd.document_id, CONCAT(dd.document_type, ' - ', dd.document_client) AS item_name, dd.document_date
                                FROM document_data dd
                                WHERE dd.document_date BETWEEN '$startDate' AND '$endDate'";

            $monthReportResult = mysqli_query($conn, $monthReportQuery);

            if ($monthReportResult->num_rows > 0) {
        ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">Description</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($monthReport = $monthReportResult->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $monthReport['description'] ?></td>
                                <td><?= $monthReport['item_id'] ?></td>
                                <td><?= $monthReport['item_name'] ?></td>
                                <td><?= $monthReport['item_date'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Excel export button -->
                <form method="post" action="../function/generate.php">
                    <input type="hidden" name="startDate" value="<?= $startDate ?>">
                    <input type="hidden" name="endDate" value="<?= $endDate ?>">
                    <button type="submit" name="generateExcelBtn" class="btn btn-success">Export to Excel</button>
                </form>
        <?php
            } else {
                echo '<p class="text-center">No data found for the selected date range.</p>';
            }
        }
        ?>
    </div>
</div>

        
    </div>
</div>
