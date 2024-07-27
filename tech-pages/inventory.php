<h2><?= $cluster_id ?> INVENTORY</h2>

<div class="row g-3">
    <!-- distribute to farmers buttons -->
    <div class="col-4">
        <div class="shadow p-5">
            <!-- request item button -->
            <button class="btn btn-outline-success p-3 w-100 fw-bold mb-2" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#requestItemModal">
                <i class="fa-solid fa-bell-concierge"></i> Request Item
            </button>
            <!-- request item modal -->
            <div class="modal fade" id="requestItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h2>Request an Item</h2>
                            <div class="border-bottom my-2"></div>
                            <form action="tech-function/function.php" method="post" class="px-3 mt-2">
                                <div class="row g-1">
                                    <div class="col-10">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="item_name">
                                                <option selected>Available Items</option>
                                                <option></option>
                                                <?php
                                                $adminInventoryQuery = "SELECT * FROM inventory WHERE item_quantity != 0";
                                                $adminInventoryResult = mysqli_query($conn, $adminInventoryQuery);

                                                if ($adminInventoryResult->num_rows > 0) {
                                                    while ($items = $adminInventoryResult->fetch_assoc()) {
                                                        $item_name = $items['item_name'];
                                                        $item_quantity = $items['item_quantity'];
                                                ?>
                                                        <option value="<?= $item_name ?>"><?= $item_name ?> || On Stock: <?= $item_quantity ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingSelect">ITEM NAME</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingPassword" placeholder="Password" name="item_quantity" required>
                                            <label for="floatingPassword">Quantity</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-success px-3 float-end w-25 ms-auto fw-bold" style="border-radius: 0;" name="requestItemBtn">Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- distribute button -->
            <button class="btn btn-success p-3 w-100 fw-bold mb-2" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#distributeModal">
                <i class="fa-solid fa-square-up-right"></i> Distribute Item
            </button>
            <!-- distribute to  farmer modal -->
            <div class="modal fade" id="distributeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="text-center">Distribute Item to Farmer</h3>
                            <div class="border-bottom my-2"></div>
                            <form action="" method="post">
                                <div class="row g-2 mb-2">
                                    <div class="col-9">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="item_name" required>
                                                <option selected>Select Item to Distribute</option>
                                                <option value=""></option>
                                                <?php
                                                $itemOption = "SELECT * FROM tech_inventory WHERE cluster_id = '$cluster_id' AND distribution_status = 'Approved' ";
                                                $itemOptionResult = mysqli_query($conn, $itemOption);

                                                if ($itemOptionResult->num_rows > 0) {
                                                    while ($items = $itemOptionResult->fetch_assoc()) {
                                                ?>
                                                        <option value="<?= $items['item_name'] ?>"><?= $items['item_name'] ?> | On Stock: <?= $items['item_quantity'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingSelect">INVENTORY ITEMS</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingPassword" placeholder="Password" name="item_quantity" required>
                                            <label for="floatingPassword">QUANTITY</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="farmer_code" required>
                                                <option selected>Select Farmer</option>
                                                <option value=""></option>
                                                <?php
                                                    $farmerOption = "SELECT f.farmer_code, f.farmer_fname, f.farmer_lname, f.barangay as farmer_brgy, c.cluster_id, c.barangay as cluster_brgy
                                                    FROM farmer f
                                                    JOIN cluster c
                                                    ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                                                    WHERE cluster_id = '$cluster_id' ";
                                                    $farmerOptionResult = mysqli_query($conn, $farmerOption);

                                                    if($farmerOptionResult->num_rows>0){
                                                        while($farmers = $farmerOptionResult->fetch_assoc()){
                                                            $farmerName = $farmers['farmer_fname']. " " .$farmers['farmer_lname'];
                                                ?>
                                                        <option value="<?= $farmers['farmer_code'] ?>"><?= $farmers['farmer_code'] ?>: <?= $farmerName ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingSelect">FARMER</label>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom my-2"></div>
        <!-- requested item / pending items table -->
        <div class="shadow p-2 mt-2 bg-secondary-subtle">
            <h5>Requested Items</h5>
            <table class="table table-hover table-bordered" id="myTable">
                <thead class="table-danger">
                    <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Req. Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <?php
                    $requestedItems = "SELECT * FROM tech_inventory WHERE cluster_id = '$cluster_id' AND distribution_status = 'Requested'";
                    $requestedItemsResult = mysqli_query($conn, $requestedItems);

                    if ($requestedItemsResult->num_rows > 0) {
                        while ($requested = $requestedItemsResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $requested['item_name'] ?></td>
                                <td><?= $requested['distribution_date'] ?></td>
                                <td class="text-warning fw-bold">Pending</td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- inventory table -->
    <div class="col w-100">
        <div class="shadow shadow-lg p-3">
            <h3 class="text-center"><?= $cluster_id ?> INVENTORY</h3>
            <div class="border-bottom my-2 bg-primary"></div>
            <table class="table table-hover table-bordered" id="medicineTbl">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Variety</th>
                        <th scope="col">Category</th>
                        <th scope="col">On Stock</th>
                        <th scope="col">Qty. Type</th>
                        <th scope="col">Dist. Date</th>
                        <th scope="col">Exp. Date</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <?php
                    $techInventoryQuery = "SELECT ti.item_name, ti.item_quantity, ti.distribution_date, i.item_name, i.item_variety, i.item_category, i.quantity_type, i.exp_date
                        FROM tech_inventory ti
                        JOIN inventory i ON ti.item_name = i.item_name
                        WHERE cluster_id = '$cluster_id' AND distribution_status = 'Approved' ";
                    $techInventoryResult = mysqli_query($conn, $techInventoryQuery);

                    if ($techInventoryResult->num_rows > 0) {
                        while ($techInventory = $techInventoryResult->fetch_assoc()) {
                            $category = $techInventory['item_category'];
                    ?>
                            <tr>
                                <td><?= $techInventory['item_name'] ?></td>
                                <td><?= $techInventory['item_variety'] ?></td>
                                <?php
                                if ($category == 'Crop Seed') {
                                ?>
                                    <td><?= $category ?> <i class="fa-solid fa-leaf text-success"></i></td>
                                <?php
                                } elseif ($category == 'Crop Fertilizer') {
                                ?>
                                    <td><?= $category ?> <i class="fa-brands fa-pagelines text-secondary"></i></td>
                                <?php
                                } elseif ($category == 'Animal Medicine') {
                                ?>
                                    <td><?= $category ?> <i class="fa-solid fa-capsules text-warning"></i></td>
                                <?php
                                }
                                ?>
                                <td><?= $techInventory['item_quantity'] ?></td>
                                <td><?= $techInventory['quantity_type'] ?></td>
                                <td><?= $techInventory['distribution_date'] ?></td>
                                <td><?= $techInventory['exp_date'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="shadow shadow-lg p-3 mt-4">
            <h3 class="text-center">ITEM DISTRIBUTION HISTORY</h3>
            <div class="border-bottom my-2 bg-primary"></div>
            <table class="table table-hover table-bordered" id="fertilizerTbl">
                <thead class="table-warning">
                    <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Farmer Code</th>
                        <th scope="col">Barangay</th>
                        <th scope="col">Dist. Date</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <?php
                    $distHistoryQuery = "SELECT di.item_name, di.item_quantity, di.date_distributed, di.farmer_code, f.farmer_code, f.barangay as farmers_barangay, i.item_category, c.cluster_id, c.barangay as cluster_barangay
                    FROM distributed_item di
                    JOIN inventory i ON di.item_name = i.item_name
                    JOIN farmer f ON di.farmer_code = f.farmer_code
                    JOIN cluster c ON FIND_IN_SET(f.barangay, REPLACE(REPLACE(c.barangay, '\r', ''), '\n', ',')) > 0
                    WHERE cluster_id = '$cluster_id' ";
                    $distHistoryResult = mysqli_query($conn, $distHistoryQuery);

                    if ($distHistoryResult->num_rows > 0) {
                        while ($distHistory = $distHistoryResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $distHistory['item_name'] ?></td>
                                <td><?= $distHistory['item_category'] ?></td>
                                <td><?= $distHistory['item_quantity'] ?></td>
                                <td><?= $distHistory['farmer_code'] ?></td>
                                <td><?= $distHistory['farmers_barangay'] ?></td>
                                <td><?= $distHistory['date_distributed'] ?></td>
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