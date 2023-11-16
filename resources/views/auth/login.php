<?php
require('database.php');
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['txt_email']);
    $pass = mysqli_real_escape_string($conn, $_POST['txt_pass']);

    if (!empty(trim($email)) && !empty(trim($pass))) {
        // Pilih data berdasarkan email dari database
        $query = "SELECT * FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);

        if ($num != 0) {
            $row = mysqli_fetch_array($result);
            $passVal = $row['user_password'];

            if ($email == $row['Email'] && $passVal == $pass) {
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['Email'] = $email;
                $_SESSION['Nama'] = $row['Nama'];
                $_SESSION['Role'] = $row['Role'];
                $_SESSION['DevisiID'] = $row['DevisiID'];
                $Nama = $_SESSION['Nama'];
                header("Location: recources/views/dashboard/index.html");
                exit();
            
            } else {
                $error = 'Email atau password salah!!';
                header('Location: login.php?error=' . urlencode($error));
            }
        } else {
            $error = 'User tidak ditemukan!!';
            header('Location: login.php?error=' . urlencode($error));
        }
    } else {
        $error = 'Data tidak boleh kosong !!!';
        header('Location: login.php?error=' . urlencode($error));
    }
} elseif (isset($_POST['register'])) {
    header('Location: register.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid p-0 h-100">
            <div class="row h-100">
                <div class="col-md-8 d-none d-sm-block" id="inpo">
                    <div class="row-cols-1 h-100 d-flex flex-column justify-content-center align-items-center" id="background">
                        <div class="col-md-6 text-center h-75" id="logo">
                            <img src="css/img/logo.png" class="img-fluid" alt="Logo Hana Asri">
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="css/img/ig&whatsapp.png" class="img-fluid" alt="IG: wm.hanaasri WA: 0812-5219-9599">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-0 m-0 rounded-start-5 justify-content-center align-items-center rounded-start-5" id="fbackground">
                    <div class="d-flex justify-content-center align-items-center" id="form">
                        <form method="POST" action="login.php" style="width: 23rem;">
                            <h1 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">WM. <br> Hana Asri</h1>
                            <?php if(isset($_GET['error'])) { ?>
                            <p class="error"> <?php echo $_GET['error']; ?></p>
                            <?php } ?>  
                            <div class="form-outline mb-4">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                            </div>
                            <div class="pt-1 mb-4">
                                <button type="submit" class="btn btn-dark btn-lg btn-block w-100">Login</button>
                            </div>
                            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="lupapassword.php">Forgot password?</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>