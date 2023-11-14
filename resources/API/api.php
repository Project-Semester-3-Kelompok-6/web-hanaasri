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
                INNER JOIN devisi ON users.DevisiID = devisi.DevisiID
                WHERE users.Status = 'Karyawan tetap'";
                $result = $conn->query($query);

                $users = array();
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }

                echo json_encode($users);
            }
            break;

        case 'POST':
            // Menambah data
            // Contoh: api.php?action=add_user&name=John&email=john@example.com
            if ($action == 'add_user') {
                $name = $_POST['name'];
                $email = $_POST['email'];

                $query = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
                $conn->query($query);

                echo json_encode(array("message" => "User added successfully"));
            }
            break;

        case 'PUT':
            // Mengupdate data
            // Contoh: api.php?action=update_user&id=1&name=John Doe
            if ($action == 'update_user') {
                $id = $_GET['id'];
                $name = $_GET['name'];

                $query = "UPDATE users SET name='$name' WHERE id=$id";
                $conn->query($query);

                echo json_encode(array("message" => "User updated successfully"));
            }
            break;

        case 'DELETE':
            // Menghapus data
            // Contoh: api.php?action=delete_user&id=1
            if ($action == 'delete_user') {
                $id = $_GET['id'];

                $query = "DELETE FROM users WHERE id=$id";
                $conn->query($query);

                echo json_encode(array("message" => "User deleted successfully"));
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
?>
