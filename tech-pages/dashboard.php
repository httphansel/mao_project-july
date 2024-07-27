<h2>DASHBOARD</h2>
<div class="row g-3">
    <!-- task col -->
    <div class="col">
        <div class="shadow shadow-lg p-3">
            <div class="row">
                <h2 class="text-center">Your Tasks</h2>
                <div class="border-bottom my-2"></div>
                <table class="table table-bordered table-hover text-center" id="taskTable">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Task Description</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                        $cluster_id = $_SESSION['cluster_id'];
                        $taskQuery = "SELECT * FROM technician_task WHERE cluster_id = '$cluster_id' AND task_status = 0";
                        $taskQueryResult = mysqli_query($conn, $taskQuery);

                        if ($taskQueryResult->num_rows > 0) {
                            while ($task = $taskQueryResult->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $task['task_name'] ?></td>
                                    <td><?= $task['task_desc'] ?></td>
                                    <td><?= $task['task_date'] ?></td>
                                    <td class="fw-bold">
                                        <?php
                                        $dueDate = $task['task_date'];
                                        $currentDate = date('Y-m-d');
                                        if (strtotime($currentDate) > strtotime($dueDate)) {
                                        ?>
                                            <a href="" class="nav-link text-danger">
                                                Task Expired
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="" class="nav-link text-primary" data-bs-toggle="modal" data-bs-target="#taskDoneModal<?= $task['task_id'] ?>">
                                                Mark as done
                                            </a>
                                            <!-- task confirmation modal -->
                                            <div class="modal fade" id="taskDoneModal<?= $task['task_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <i class="fa-solid fa-circle-check fs-1 text-success"></i><br>
                                                            Mark Task as Done?
                                                            <div class="row">
                                                                <div class="col">
                                                                    <a href="tech-function/function.php?task_id=<?= $task['task_id'] ?>" name="taskDoneBtn" class="btn btn-outline-success mt-2">Yes</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </td>
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
    <!-- chart col -->
    <div class="col-4">
        <div class="shadow shadow-lg p-3 bg-success-subtle">
            <h3 class="text-center">Registered Livestock Chart</h3>
            <div class="card bg-light p-3 mb-3" id="bar_chart_div" style="width: 100%; height: 300px;"></div>
        </div>
    </div>
</div>

<!-- chartjs script -->
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