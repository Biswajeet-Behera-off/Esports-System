<?php
require_once "config/techfestName.php";
require_once "config/configPDO.php";
require_once "./config/demo-Secret.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $techfestName ?> | REACTIVATE USER ACCOUNT</title>
    <?php include_once "includes/headerScripts.php"; ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <?php
    try {
        if (isset($_POST['reactivate'])) {
            if (isset($_POST['g-recaptcha-response'])) {
                $secretKey = $recaptchaSecretKey;
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $response = json_decode($verifyResponse);
                if (!$response->success) {
                    echo "<script>Swal.fire({
                        icon: 'warning',
                        title: 'Captcha Error',
                        text: 'Please fill Captcha'
                    })</script>";
                } else {
                    $email = htmlspecialchars($_POST['email']);
                    $sql = "SELECT * FROM user_information WHERE email = :email";
                    $result = $conn->prepare($sql);
                    $result->bindValue(":email", $email);
                    $result->execute();
                    if ($result->rowCount() === 0) {
                        echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No such email present in the database to reactivate your account'
                        })</script>";
                    } else {
                        $token = bin2hex(random_bytes(15));
                        $sql = "UPDATE user_information SET token = :token WHERE email = :email";
                        $result = $conn->prepare($sql);
                        $result->bindValue(":token", $token);
                        $result->bindValue(":email", $email);
                        $result->execute();
                        if ($result) {
                            include_once "./emailCode/emailDisableAccount.php";
                            if (!$mail->send()) {
                                echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Email could not be sent. Please try again later.'
                                })</script>";
                            } else {
                                echo "<script>Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Email Sent'
                                })</script>";
                            }
                        }
                    }
                }
            } else {
                echo "<script>Swal.fire({
                    icon: 'warning',
                    title: 'Captcha Error',
                    text: 'Please fill Captcha'
                })</script>";
            }
        }

        if (isset($_GET['token'])) {
            $token = htmlspecialchars($_GET['token']);
            $sql = "UPDATE user_information SET status = :active WHERE token = :token";
            $result = $conn->prepare($sql);
            $result->bindValue(":active", "active");
            $result->bindValue(":token", $token);
            $result->execute();
            if ($result) {
                echo "<script>Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Your account is successfully reactivated. We are happy to see you again.'
                })</script>";
            }
        }
    } catch (PDOException $e) {
        echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
        echo "Error " . $e->getMessage();
    }
    ?>

    <?php include_once "includes/navbar.php"; ?>

    <main class="container">
        <div class="row">
            <div class="col-md-6 my-5 offset-md-3">
                <h1 class="font-time text-center">Activate Your Disabled Account</h1>
                <h5 class="text-center my-3">To activate your disabled account, please enter your email address below and check your email inbox. Then, click on the link sent to your email to reactivate your account.</h5>

                <form action="" method="post">
                    <div class="form-group mt-2">
                        <label>Enter Your Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="text-center my-2">
                        <div class="g-recaptcha text-center" data-sitekey=<?php echo $recaptchaSiteKey; ?>></div>
                    </div>

                    <input type="submit" name="reactivate" value="Submit" class="btn btn-primary btn-block rounded-pill">
                    <h6 class="mt-3"><a href="login.php">Click Here for Login Page</a></h6>
                </form>
            </div>
        </div>
    </main>

    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/footerScripts.php"; ?>
    <?php $conn = null; ?>
</body>

</html>
