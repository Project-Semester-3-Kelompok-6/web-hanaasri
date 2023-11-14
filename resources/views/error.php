<?php
$errors = [
    404 => 'Not Found',
    403 => 'Forbidden',
    419 => 'Page Expired',
];

$code = isset($_GET['code']) ? (int)$_GET['code'] : 404; // Mengambil kode dari parameter URL
$message = $errors[$code] ?? 'Error';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $code; ?> <?php echo $message; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            min-width: 100vh;
            justify-content: center;
            align-items: center;
            gap: 1em;
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>
<body>
    <h1><?php echo $code; ?></h1>
    |
    <h1><?php echo $message; ?></h1>
</body>
</html>
