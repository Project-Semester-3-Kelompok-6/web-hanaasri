<?php

session_start();
if(isset($_SESSION['id']) && isset($_SESSION['email'])) {
?>
<!DOCTYPE html>
<html>
        <head>
            <title>Dashboard</title>
        </head>
        <body>
            <h1>asep</h1>
        </body>
</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>