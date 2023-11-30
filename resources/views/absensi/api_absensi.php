<?php
header("Content-Type: application/json");

include '../../../database.php';

$request_method = $_SERVER['REQUEST_METHOD'];

// Periksa apakah 'action' sudah diatur
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($request_method) {
        case 'GET':
            // Mengambil data absensi hari ini
            if ($action == 'get_absensi') {
                $current_date = date("Y-m-d");
                $query = "SELECT absensi.*, users.Nama, devisi.NamaDevisi
                FROM absensi
                INNER JOIN users ON absensi.KaryawanID = users.UserID
                INNER JOIN devisi ON users.UserID = devisi.DevisiID
                WHERE Tanggal = '$current_date'
                ORDER BY Tanggal DESC";

                $result = $conn->query($query);

                if ($result) {
                    echo json_encode($devisi);
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error retrieving data absensi terbaru"));
                }
                break;
            }

        case 'POST':
            // API Tambah Data
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
                break;
            }

        case 'DELETE':
            // Menghapus data
            // Contoh: api.php?action=delete_user&id=1
            if ($action == 'delete_user') {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $query = "DELETE FROM users WHERE UserID=$id";
                    if ($conn->query($query)) {
                        echo json_encode(array("message" => "User deleted successfully"));
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Error deleting user"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "'id' parameter is missing"));
                }
            }
            break;

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