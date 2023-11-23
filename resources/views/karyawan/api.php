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
            // Contoh: api.php?action=get_users
            if ($action == 'get_users') {
                if (isset($_GET['status'])) {
                    $status = $_GET['status'];

                    $query = "SELECT users.*, devisi.NamaDevisi
                              FROM users
                              INNER JOIN devisi ON users.DevisiID = devisi.DevisiID
                              WHERE users.Status = $status";

                    $result = $conn->query($query);

                    if ($result) {
                        $users = $result->fetch_all(MYSQLI_ASSOC);
                        echo json_encode($users);
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Error retrieving data"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "'status' parameter is missing"));
                }
            }
            break;
            // Tambahkan endpoint untuk mendapatkan data devisi
            if ($action == 'get_devisi') {
                $query = "SELECT * FROM devisi";
                $result = $conn->query($query);
            
                if ($result) {
                    $devisi = $result->fetch_all(MYSQLI_ASSOC);
                    echo json_encode($devisi);
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error retrieving devisi data"));
                }
            }
            break;

            if ($action == 'get_user_detail') {
                if (isset($_GET['id'])) {
                    $userId = $_GET['id'];

                    $query = "SELECT users.*, devisi.NamaDevisi
                      FROM users
                      INNER JOIN devisi ON users.DevisiID = devisi.DevisiID
                      WHERE users.UserID = $userId";

                    $result = $conn->query($query);

                    if ($result) {
                        $userDetail = $result->fetch_assoc();
                        echo json_encode($userDetail);
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Error retrieving user details"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "'id' parameter is missing"));
                }
            }
            break;


        case 'POST':  //belum
            // Tambahkan endpoint untuk menambahkan data user
            if ($action == 'add_user') {
                $nama = $_POST['nama'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $divisiID = $_POST['divisiID'];
                $role = 'Karyawan';
                $status = 'Karyawan Tetap';

                $query = "INSERT INTO users (Nama, Email, Password, DevisiID, Role, Status)
              VALUES ('$nama', '$email', '$password', '$divisiID', '$role', '$status')";

                if ($conn->query($query)) {
                    echo json_encode(array("message" => "User added successfully"));
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error adding user"));
                }
            }
            break;

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
