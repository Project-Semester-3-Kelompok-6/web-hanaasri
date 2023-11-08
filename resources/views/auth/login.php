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
                                <label class="form-label" for="form2Example18">Email address</label>
                                <input type="email" id="form2Example18" name="email" class="form-control form-control-lg" />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form2Example28">Password</label>
                                <input type="password" id="form2Example28" name="password" class="form-control form-control-lg" />
                            </div>
                            <div class="pt-1 mb-4">
                                <button type="submit" class="btn btn-dark btn-lg btn-block w-100">Login</button>
                            </div>
                            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="forgotPassword.php">Forgot password?</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
