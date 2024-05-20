<?php

//----------------------------------------->> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "../config/techfestName.php";

//--------------------->> DB CONFIG
require_once '../config/configPDO.php';

//---------------------------->> SECRETS
require_once "../config/demo-Secret.php";

//---------------------------->> STARTING SESSION
session_start();

//---------------------------->> CHECKING ADMIN

if (isset($_SESSION['adminEmail']) && $_SESSION['adminType']) {
    if ($_SESSION['adminType'] == 'Administrator') {
        header('Location:adminIndex.php');

    } else {
        header('Location:adminLogin.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo $techfestName ?> | TRAP ARMY ADMINISTRATOR PANEL</title>

     <!-- Include Header Scripts then Google Recaptcha then Css file -->
    <?php include_once "../includes/headerScripts.php";?>
    <link rel="stylesheet" href="css/adminLogin.css">
    <link rel="stylesheet" href="../css/common.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<body class="mb-5">


    <?php

try {

    if (isset($_POST['login'])) {

        if (isset($_POST['g-recaptcha-response'])) {

            $secretKey = $recaptchaSecretKey;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $response = json_decode($verifyResponse);

            if ($response->success) {

                $adminUserName = $_POST['email'];
                $adminType = $_POST['adminType'];
                $adminPassword = $_POST['password'];

                if (!filter_var($adminUserName, FILTER_VALIDATE_EMAIL)):
                    echo '<script>Swal.fire({
							icon: "warning",
							title: "Warning",
							text: "Invalid Admin Username format",
						})</script>';
                    return;
                endif;

                if (empty($adminType)):
                    echo '<script>Swal.fire({
							icon: "warning",
							title: "Warning",
							text: "Please Select Proper Admin Type,
						})</script>';
                    return;
                endif;

                if (empty($adminType)):
                    echo '<script>Swal.fire({
							icon: "warning",
						    title: "Warning",
							text: "Please Select Proper Admin Type,
						})</script>';
                    return;
                endif;

                if (empty($adminPassword)):
                    echo '<script>Swal.fire({
							icon: "warning",
							title: "Warning",
							text: "Admin Password Field Cannot Be Empty,
					})</script>';
                    return;
                endif;

                # Removing White Spaces
                $adminUserName = trim($_POST['email']);
                $adminType = trim($_POST['adminType']);
                $adminPassword = trim($_POST['password']);

                # Avoid XSS Attack
                $adminUserName = htmlspecialchars($_POST['email']);
                $adminType = htmlspecialchars($_POST['adminType']);
                $adminPassword = htmlspecialchars($_POST['password']);

                # Sql Query
                $sql = "SELECT adminPassword FROM admin_information WHERE admin_information.email  = :adminUserName
                AND admin_information.adminType = :adminType";

                # Preparing Query
                $result = $conn->prepare($sql);

                # Binding Values
                $result->bindValue(":adminUserName", $adminUserName);
                $result->bindValue(":adminType", $adminType);

                # Executing Value
                $result->execute();

                if ($result) {

                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    if ($row === false) {
                        echo "No rows found";
                    } else {
                        $password = $row['adminPassword'];
                    }

                    # Password Verification

                    if (password_verify($adminPassword, $password) && ($adminType === "Administrator")) {
                        $_SESSION['adminEmail'] = $adminUserName;
                        $_SESSION['adminType'] = $adminType;
                        header('Location:adminIndex.php');

                    } else {
                        echo "<script>Swal.fire({
                                icon: 'error',
                                title: 'Unable to Login',
                                text: 'Please Check Your Credential or Check Your User Role'
                            })</script>";
                    }

                } else {
                    echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something Went Wrong'
                        })</script>";
                }

            } else {
                echo "<script>Swal.fire({
                        icon: 'warning',
                        title: 'Google Recaptcha Error',
                        text: 'Please fill Google Recaptcha Properly'
                    })</script>";
            }

        } else {
            echo "<script>Swal.fire({
                        icon: 'warning',
                        title: 'Google Recaptcha Error',
                        text: 'Please fill Google Recaptcha Properly'
                    })</script>";

        }

    }

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
# Development Purpose Error Only
    echo "Error " . $e->getMessage();
}

?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><?php echo $techfestName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="../register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="../login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="adminLogin.php">Admin Login</a>
                </li>
            </ul>
        </div>
    </nav>


    <main class="container">
        <div class="row">
            <section class="col-md-6 offset-md-3">

                <div class="card shadow px-4 py-2">
                    <h2 class="text-center text-uppercase mt-4 font-time">Admin Login</h2>

                   <hr/>

                    <form action="" method="post">

                        <div class="text-center mb-3">
                            <span class="text-warning"><i class="fa fa-users fa-5x"></i></span>
                        </div>

                        <div class="form-group mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <select class="custom-select" name="adminType">
                                <option selected disabled>Choose Admin Type</option>
                                <option value="Administrator">Administrator</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Admin Password" required autocomplete="off">
                        </div>

                        <div class="text-center my-2">
                            <div class="g-recaptcha text-center"
                                data-sitekey= <?php echo $recaptchaSiteKey; ?>></div>
                        </div>

                        <div class="form-group">
                            <a href="../forgotPassword.php" class="text-danger font-weight-bold">Forgot your
                                password?</a>
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary btn-block rounded-pill mt-3" type="submit"
                                class="form-control" name="login" id="login" value="Login">
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </main>

    <!--Include Footer Scripts-->
    <?php include_once "../includes/footerScripts.php"?>

    <!--Close DB Connection-->
    <?php $conn = null;?>

</body>

</html>