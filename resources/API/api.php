<?php
header("Content-Type: application/json");

include '../../database.php';

$request_method = $_SERVER['REQUEST_METHOD'];

// Periksa apakah 'action' sudah diatur
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($request_method) {
        case 'GET':
            // Mengambil data
            // Contoh: api.php?action=get_users
            if ($action == 'get_users') {
                $query = "SELECT users.Nama AS NamaKaryawan, devisi.NamaDevisi AS NamaDevisi
                          FROM users
                          INNER JOIN devisi ON users.DevisiID = devisi.DevisiID";
                $result = $conn->query($query);

                if ($result) {
                    $users = $result->fetch_all(MYSQLI_ASSOC);
                    echo json_encode($users);
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error retrieving data"));
                }
            }
            break;

        case 'POST':
            // Menambah data
            // Contoh: api.php?action=add_user&name=John&email=john@example.com
            if ($action == 'add_user') {
                $name = $_POST['name'];
                $email = $_POST['email'];

                $query = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
                if ($conn->query($query)) {
                    echo json_encode(array("message" => "User added successfully"));
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error adding user"));
                }
            }
            break;

            // Tambahkan case untuk metode PUT, DELETE, jika diperlukan
            
        default:
            // Metode HTTP tidak didukung
            http_response_code(405);
            echo json_encode(array("message" => "Method not allowed"));
            break;
    }
} else {
    // Jika 'action' tidak diatur
    http_response_code(400);
    echo json_encode(array("message" => "'action' parameter is missing"));
}

$conn->close();
?>
