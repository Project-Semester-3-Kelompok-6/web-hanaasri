<?php

    $host ='localhost';
    $username = 'root';
    $password = '';
    $database = 'wm_hanaasri';

    $conn = mysqli_connect ($host, $username, $password, $database);

    if(!$conn){
        echo "Connection Failed";
    }

?>