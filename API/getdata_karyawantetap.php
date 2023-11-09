<?php

require_once "../app/databases/database.php";
$query = "SELECT users.*, devisi.NamaDevisi
FROM users
INNER JOIN devisi ON users.DevisiID = devisi.DevisiID;
";

$sql = mysqli_query($conn, $query);

if ($sql) {
    $result = array();
    while ($row = mysqli_fetch_array($sql)) {    
        array_push($result, array(
            'ID' => $row['UserID'],
            'Nama' => $row['Nama'],
            'Email' => $row['Email'],
            'Password' => $row['Password'],
            'Role' => $row['Role'],
            'Status' => $row['Status'],
            'Nama Devisi' => $row['NamaDevisi']
        ));
    }

    echo json_encode( $result );
}

?>