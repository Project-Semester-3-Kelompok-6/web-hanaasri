<?php
header("Content-Type: application/json");

include '../../../database.php';

$request_method = $_SERVER['REQUEST_METHOD'];

// Periksa apakah 'action' sudah diatur
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($request_method) {
        case 'GET':
            // Mengambil data
            if ($action == 'dashboard_info') {
                // Calculate total employees
                $queryTotalEmployees = "SELECT COUNT(*) AS total_employees FROM users";
                $resultTotalEmployees = $conn->query($queryTotalEmployees);
                $totalEmployees = $resultTotalEmployees->fetch_assoc()['total_employees'];

                // Calculate total tasks for today
                $today = date('Y-m-d');
                $queryTotalTasksToday = "SELECT COUNT(*) AS total_tasks_today FROM job WHERE tanggal = '$today'";
                $resultTotalTasksToday = $conn->query($queryTotalTasksToday);
                $totalTasksToday = $resultTotalTasksToday->fetch_assoc()['total_tasks_today'];
                
                // Get the latest tasks
                $queryLatestTasks = "SELECT job.*, users.Nama
                                     FROM job
                                     INNER JOIN users ON job.KaryawanID = users.UserID
                                     WHERE DATE(job.Tanggal) = CURDATE()";
                $resultLatestTasks = $conn->query($queryLatestTasks);
                $latestTasks = $resultLatestTasks->fetch_all(MYSQLI_ASSOC);

                // Prepare the response
                $response = array(
                    "total_employees" => $totalEmployees,
                    "total_tasks_today" => $totalTasksToday,
                    "latest_tasks" => $latestTasks
                );

                echo json_encode($response);
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "Invalid 'action' parameter"));
            }
            break;

        default:
            // Metode HTTP tidak didukung
            http_response_code(405);
            echo json_encode(array("error" => "Method not allowed"));
            break;
    }
} else {
    // Jika 'action' tidak diatur
    http_response_code(400);
    echo json_encode(array("error" => "'action' parameter is missing"));
}

$conn->close();
?>
