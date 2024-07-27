<h2>INVENTORY</h2>

<form method="post">
    <div class="row mt-3 px-5">
        <div class="col">
            <button class="shadow shadow-lg text-start rounded p-3 pb-0 shadowBtn btn btn-link" type="submit" value="Crops" name="invBtn" style="width: 18rem; text-decoration: none;">
                <span class="inventoryBtn">
                    CROPS
                </span>
                <p class="float-end fs-3">
                    <i class="fa-solid fa-leaf text-success"></i>
                </p>
            </button>
        </div>
        <div class="col">
            <button class="shadow shadow-lg rounded text-start pb-0 p-3 shadowBtn btn btn-link" type="submit" value="Fertilizer" name="invBtn" style="width: 18rem; text-decoration: none;">
                <span class="inventoryBtn">
                    FERTILIZER
                </span>
                <p class="float-end fs-3">
                    <i class="fa-brands fa-pagelines text-success-subtle" style="color: var(--success-subtle);"></i>
                </p>
            </button>
        </div>
        <div class="col">
            <button class="shadow shadow-lg rounded text-start pb-0 p-3 shadowBtn btn btn-link" type="submit" value="Medicine" name="invBtn" style="width: 18rem; text-decoration: none;">
                <span class="inventoryBtn">
                    MEDICINE
                </span>
                <p class="float-end fs-3">
                    <i class="fa-solid fa-capsules text-warning"></i>
                </p>
            </button>
        </div>
        <div class="col">
            <button class="shadow shadow-lg rounded text-start pb-0 p-3 shadowBtn btn btn-link bg-success-subtle" type="button" style="width: 18rem; text-decoration: none;" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <span class="inventoryBtn">
                    ADD NEW ITEM
                </span>
                <p class="float-end fs-3">
                    <i class="fa-solid fa-plus-minus text-success"></i>
                </p>
            </button>
        </div>
    </div>
</form>

<!-- add item modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form action="../function/crud.php" method="post" class="g-0">
                    <div class="row">
                        <h2 class="text-success">
                            Add New Item
                        </h2>
                        <div class="border-bottom mb-3"></div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="item_name" placeholder="eg. Far">
                                <label for="floatingInput" class="fs-bold">Item Name</label>
                            </div>

                            <div class="form-floating">
                                <select class="form-select mb-3" id="floatingSelect" aria-label="Floating label select example" name="quantity_type">
                                    <option selected>Select a Quantity Type</option>
                                    <option></option>
                                    <option value="Canned">Canned</option>
                                    <option value="Bottled">Bottled</option>
                                    <option value="Bags">Bags</option>
                                </select>
                                <label for="floatingSelect">Quantity Type</label>
                            </div>
                            <div class="form-floating">
                                <select class="form-select mb-3" id="floatingSelect" aria-label="Floating label select example" name="item_category">
                                    <option selected>Select a Category</option>
                                    <option></option>
                                    <option value="Crop Fertilizer">Crop Fertilizer</option>
                                    <option value="Animal Medicine">Animal Medicine</option>
                                    <option value="Crop Seed">Crop Seed</option>
                                </select>
                                <label for="floatingSelect">Item Category</label>
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingInput" name="item_quantity" placeholder="eg. 15">
                                <label for="floatingInput" class="fs-bold">Item Quantity</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="item_variety" placeholder="eg. 15">
                                <label for="floatingInput" class="fs-bold">Variety</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingInput" name="exp_date" placeholder="eg. 15">
                                <label for="floatingInput" class="fs-bold">Expiration Date</label>
                            </div>
                            <button class="btn btn-outline-success fw-bold float-end" name="addInventoryBtn">Add Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="border-bottom my-3"></div>

<!-- table row -->
<div class="row p-4">
    <div class="shadow shadow-lg p-5 rounded">
        <?php
        if (isset($_POST['invBtn'])) {
            $item = mysqli_real_escape_string($conn, $_POST['invBtn']);

            if ($item == 'Crops') {
                $inventoryQuery = "SELECT * FROM inventory WHERE item_category = 'Crop Seed' AND item_quantity != 0 ";
            } else if ($item == 'Fertilizer') {
                $inventoryQuery = "SELECT * FROM inventory WHERE item_category = 'Crop Fertilizer' AND item_quantity != 0 ";
            } else if ($item == 'Medicine') {
                $inventoryQuery = "SELECT * FROM inventory WHERE item_category = 'Animal Medicine' AND item_quantity != 0 ";
            } else {
                echo '<p class="text-danger"> There was an error retrieving items. </p>';
            }

            $inventoryResult = mysqli_query($conn, $inventoryQuery);

            if ($inventoryResult && $inventoryResult->num_rows > 0) {
                echo '<h2>' . $item . '</h2>';
                echo '<table class="table table-bordered table-hover" id="myTable">';
                echo '<thead class="table-success text-center">
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Variety</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date Added</th>
                        <th scope="col">Expiration Date</th>
                        <th scope="col">Item Status</th>
                        <th scope="col">Action</th>
                    </tr>
                  </thead>';
                echo '<tbody class="table-light">';

                while ($inventory = $inventoryResult->fetch_assoc()) {
                    echo '<tr>
                        <td>' . htmlspecialchars($inventory['item_name']) . '</td>
                        <td>' . htmlspecialchars($inventory['item_variety']) . '</td>
                        <td>' . htmlspecialchars($inventory['item_quantity']) . '</td>
                        <td>' . htmlspecialchars($inventory['quantity_type']) . '</td>
                        <td>' . htmlspecialchars($inventory['date_added']) . '</td>
                        <td>' . htmlspecialchars($inventory['exp_date']) . '</td>
                        <td>' . htmlspecialchars($inventory['item_status']) . '</td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary p-0 px-3" data-bs-toggle="modal" data-bs-target="#editInventoryModal' . htmlspecialchars($inventory['item_id']) . '">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                      </tr>';
        ?>
                    <!-- edit item modal -->
                    <div class="modal fade" id="editInventoryModal<?= $inventory['item_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="../function/crud.php" method="post" class="g-0">
                                        <div class="row">
                                            <h2 class="text-success">
                                                Update Item Information
                                            </h2>
                                            <div class="border-bottom mb-3"></div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingInput" name="item_name" placeholder="eg. Far" value="<?= $inventory['item_name'] ?>">
                                                    <label for="floatingInput" class="fs-bold">Item Name</label>
                                                </div>
                                                <input type="hidden" name="item_id" value="<?= $inventory['item_id'] ?>">

                                                <div class="form-floating">
                                                    <select class="form-select mb-3" id="floatingSelect" aria-label="Floating label select example" name="quantity_type">
                                                        <option selected value="<?= $inventory['quantity_type'] ?>"><?= $inventory['quantity_type'] ?></option>
                                                        <option></option>
                                                        <option value="Canned">Canned</option>
                                                        <option value="Bottled">Bottled</option>
                                                        <option value="Bags">Bags</option>
                                                    </select>
                                                    <label for="floatingSelect">Quantity Type</label>
                                                </div>
                                                <div class="form-floating">
                                                    <select class="form-select mb-3" id="floatingSelect" aria-label="Floating label select example" name="item_category">
                                                        <option selected value="<?= $inventory['item_category'] ?>"><?= $inventory['item_category'] ?></option>
                                                        <option></option>
                                                        <option value="Crop Fertilizer">Crop Fertilizer</option>
                                                        <option value="Animal Medicine">Animal Medicine</option>
                                                        <option value="Crop Seed">Crop Seed</option>
                                                    </select>
                                                    <label for="floatingSelect">Item Category</label>
                                                </div>

                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="floatingInput" name="item_quantity" placeholder="eg. 15" value="<?= $inventory['item_quantity'] ?>">
                                                    <label for="floatingInput" class="fs-bold">Item Quantity</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingInput" name="item_variety" placeholder="eg. 15" value="<?= $inventory['item_variety'] ?>">
                                                    <label for="floatingInput" class="fs-bold">Variety</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="floatingInput" name="exp_date" placeholder="eg. 15" value="<?= $inventory['exp_date'] ?>">
                                                    <label for="floatingInput" class="fs-bold">Expiration Date</label>
                                                </div>
                                                <button class="btn btn-outline-success fw-bold float-end" name="updateInventoryBtn">Update Item</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="text-danger"> No items found. </p>';
            }
        }
        ?>
    </div>
</div>