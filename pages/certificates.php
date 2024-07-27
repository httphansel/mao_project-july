<?php
$documentDataQuery = "SELECT * FROM document_data";
$documentDataResult = mysqli_query($conn, $documentDataQuery);

if ($documentDataResult->num_rows > 0) {
    $goodStandingQuery = "SELECT * FROM document_data WHERE document_type = 'GOOD STANDING' ";
    if ($goodStandingResult = mysqli_query($conn, $goodStandingQuery)) {
        $goodStanding = mysqli_num_rows($goodStandingResult);

        $asfFreeQuery = "SELECT * FROM document_data WHERE document_type = 'ASF-FREE' ";
        if ($asfFreeResult = mysqli_query($conn, $asfFreeQuery)) {
            $asfFree = mysqli_num_rows($asfFreeResult);

            $loanFormatQuery = "SELECT * FROM document_data WHERE document_type = 'LOAN FORMAT' ";
            if ($loanFormatResult = mysqli_query($conn, $loanFormatQuery)) {
                $loanFormat = mysqli_num_rows($loanFormatResult);
            }
        }
    }
}

?>
<h2>CERTIFICATE GENERATOR</h2>

<div class="shadow shadow-lg p-3 bg-success-subtle">
    <div class="row">
        <div class="col-4 d-inline">
            <div class="shadow p-2 py-4 bg-light text-center justify-content-center align-items-center">
                <!-- good standing -->
                <button class="btn btn-outline-success px-2 w-75 mb-2 fw-bold text-start" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#goodstandingModal">
                    Certificate of Good Standing
                </button>
                <div class="modal fade" id="goodstandingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2>GOOD STANDING CERTIFICATE</h2>
                                <div class="border-bottom my-2"></div>
                                <form action="../function/generate.php" method="post">
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="document_client" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Requested by</label>
                                    </div>
                                    <div class="form-floating mx-3 mb-2">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="document_description" required></textarea>
                                        <label for="floatingTextarea" class="fw-bold">Description</label>
                                    </div>
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="barangay" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Barangay</label>
                                    </div>
                                    <button class="btn btn-success float-end w-25 me-3" style="border-radius: 0;" name="good_standingBtn">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- asf free -->
                <button class="btn btn-outline-success px-2 w-75 mb-2 fw-bold text-start" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#asfModal">
                    ASF-Free
                </button>
                <div class="modal fade" id="asfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2>ASF-FREE CERTIFICATE</h2>
                                <div class="border-bottom my-2"></div>
                                <form action="../function/generate.php" method="post">
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="document_client" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Requested by</label>
                                    </div>
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="farm_name" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Farm Name</label>
                                    </div>
                                    <button class="btn btn-success float-end w-25 me-3" style="border-radius: 0;" name="asf_freeBtn">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- loan format -->
                <button class="btn btn-outline-success px-2 w-75 mb-2 fw-bold text-start" style="border-radius: 0;" data-bs-toggle="modal" data-bs-target="#loanformatModal">
                    Loan Format
                </button>
                <div class="modal fade" id="loanformatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2>LOAN FORMAT CERTIFICATE</h2>
                                <div class="border-bottom my-2"></div>
                                <form action="../function/generate.php" method="post">
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="document_client" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Requested by</label>
                                    </div>
                                    <div class="form-floating mx-3 mb-2">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="document_description" required></textarea>
                                        <label for="floatingTextarea" class="fw-bold">Description</label>
                                    </div>
                                    <div class="form-floating mx-3 mb-2">
                                        <input type="text" class="form-control" id="floatingPassword" name="barangay" placeholder="Password" required>
                                        <label for="floatingPassword" class="fw-bold">Barangay</label>
                                    </div>
                                    <button class="btn btn-success float-end w-25 me-3" style="border-radius: 0;" name="loan_formatBtn">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- simple analytics column ito -->
        <div class="col">
            <div class="row mt-2">
                <div class="col">
                    <div class="card text-bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header fw-bold">Good Standing</div>
                        <div class="card-body">
                            <h5 class="card-title">Produced</h5>
                            <p class="card-text h1">
                                <i class="fa-solid fa-print"></i> <?= $goodStanding ?> <span class="h5">Certificates</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header fw-bold">ASF-Free</div>
                        <div class="card-body">
                            <h5 class="card-title">Produced</h5>
                            <p class="card-text h1">
                                <i class="fa-solid fa-print"></i> <?= $asfFree ?> <span class="h5">Certificates</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header fw-bold">Loan Format</div>
                        <div class="card-body">
                            <h5 class="card-title">Produced</h5>
                            <p class="card-text h1">
                                <i class="fa-solid fa-print"></i> <?= $loanFormat ?> <span class="h5">Certificates</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shadow shadow-lg mt-3 p-3">
    <div class="row">
        <h2 class="text-center">Transaction History</h2>
        <div class="col w-100">
            <table class="table table-bordered" id="fertilizerTbl">
                <thead class="table-success text-center">
                    <tr>
                        <th scope="col">Document</th>
                        <th scope="col">Client</th>
                        <th scope="col">Farm</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <!-- document history query start here -->
                    <?php
                    $documentHistoryQuery = "SELECT * FROM document_data";
                    $documentHistoryResult = mysqli_query($conn, $documentHistoryQuery);

                    if ($documentHistoryResult->num_rows > 0) {
                        while ($document = $documentHistoryResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $document['document_type'] ?></td>
                                <td><?= $document['document_client'] ?></td>
                                <td><?= $document['farm_name'] ?></td>
                                <td><?= $document['document_description'] ?></td>
                                <td><?= $document['document_date'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <!-- document history query ends here -->
                </tbody>
            </table>
        </div>
    </div>
</div>