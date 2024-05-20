<?php


require_once "config/techfestName.php";

require_once "config/configPDO.php";

require_once "./config/demo-Secret.php";

session_start();

?>

<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- First HeaderScripts, then AOS Animation, then Google Recaptcha, then Register.css -->
  <?php include_once "includes/headerScripts.php"; ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" href="css/register.css">

  <title><?php echo $techfestName ?> | REGISTRATION</title>

</head>

<body>


  <?php

  function swalError($msg)
  {
    echo "<script>
            Swal.fire({ icon: 'error', title: 'Error', text: '$msg' })
          </script>";
    exit;
  }

  function xss_filter_trim($param)
  {
    return trim(htmlspecialchars($param));
  }

  $login = "login.php";

  if (isset($_POST['submit'])) {

    try {

      if (isset($_POST['g-recaptcha-response'])) {

        $secretKey = $recaptchaSecretKey;
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
        $response = json_decode($verifyResponse);

        if (!$response->success) {
          swalError('Please fill Google Recaptcha');
        }

        $userName = $_POST['userName'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $mobileNumber = $_POST['mobileNumber'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];

        if (empty($userName)) {
          swalError('Please Enter Username');
        }

        if (empty($firstName)) {
          swalError('Please Enter First Name.');
        }

        if (empty($lastName)) {
          swalError('Please Enter Last Name');
        }

        if (empty($mobileNumber)) {
          swalError('Please Enter Mobile Number');
        }

        if (strlen($mobileNumber) !== 10) {
          swalError('Please Enter Proper Mobile Number');
        }

        if (empty($password)) {
          swalError('Password Cannot be empty');
        }

        if (!preg_match('/[A-Z]/', $password)) {
          swalError('Password must contain at least one Uppercase Letter (A-Z).');
        }

        if (!preg_match('/[a-z]/', $password)) {
          swalError('Password must contain at least one Lowercase Letter (a-z).');
        }

        if (!preg_match('/[0-9]/', $password)) {
          swalError('Password must contain at least one number (0-9).');
        }

        if (strlen($password) < 8) {
          swalError('Password length must be atleast 8 Characters');
        }

        if ($password !== $confirm_password) {
          swalError('Password and Confirm Password are different');
        }

        $userName = xss_filter_trim($_POST['userName']);
        $firstName = xss_filter_trim($_POST['firstName']);
        $lastName = xss_filter_trim($_POST['lastName']);
        $mobileNumber = xss_filter_trim($_POST['mobileNumber']);
        $password = xss_filter_trim($_POST['password']);
        $confirm_password = xss_filter_trim($_POST['confirmPassword']);

        # Set Expiery Time for Token
        $tokenDate = date("Y-m-d H:i:s");
        $tokenDateMain = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($tokenDate)));

        $token = bin2hex(random_bytes(15));

        $hashPass = password_hash($password, PASSWORD_BCRYPT);
        $hashConPass = password_hash($confirm_password, PASSWORD_BCRYPT);

        $sql1 = "SELECT * FROM user_information WHERE user_information.email = :userName";

        $result1 = $conn->prepare($sql1);

        $result1->bindValue(":userName", $userName);

        $result1->execute();

        if ($result1->rowCount() >  0) {
          echo "<script>Swal.fire({
                    icon: 'warning',
                    title: 'Account is Already Exist',
                    text: 'You are already registerd with $techfestName, Login to Continue',
                    footer: '<a href = $login >Go to the Login Page</a>'
                  })</script>";
          exit;
        }

        # Query
        $sql = "INSERT INTO user_information(email, firstName, lastName,
                mobileNumber, password, tokenDate, token)
                VALUES (:userName, :firstName, :lastName, :mobileNumber,
                :hashPass, :tokenDateMain, :token )";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Values
        $result->bindValue(":userName", $userName);
        $result->bindValue(":firstName", $firstName);
        $result->bindValue(":lastName", $lastName);
        $result->bindValue(":mobileNumber", $mobileNumber);
        $result->bindValue(":hashPass", $hashPass);
        $result->bindValue(":tokenDateMain", $tokenDateMain);
        $result->bindValue(":token", $token);

        # Executing Query
        $result->execute();

        if (!$result) {
          echo '<script>Swal.fire({
              icon: "error",
              title: "Eror",
              text: "Something Went Wrong",
              footer: "<a href = ' . $login . ' >Go to the Login Page</a>"
          })</script>';
          exit;
        }

        echo "<script>Swal.fire({
                icon: 'success',
                title: 'Activate Your Account',
                text: 'Check Your Email for activate your account',
                footer: '<a href = $login >Go to the Login Page</a>'
            })</script>";

        /* PHP MAILER CODE */
        include_once "./emailCode/emailRegister.php";

        if (!$mail->send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
          exit;
        }

        echo "<h5 class='text-center alert alert-warning col-md-6 offset-md-3' role='alert' >Check Your Email.</h5>";
        exit;
      }
    } catch (PDOException $e) {
      echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
      # Development Purpose Error Only
      echo "Error " . $e->getMessage();
    }
  }
  ?>


  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $techfestName ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" href="Admin/adminLogin.php">Admin Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="container mt-4">

    <h2 class="text-center mx-auto font-time text-uppercase">User Registration</h2>
    <h6 class="alert alert-danger text-center font-sans">Note: 1) Following details will be used
      for your Certificate Generation so please provide proper details.</h6>

    <hr>

    <h5 class="font-sans text-center">Already have an account? <a href="login.php"> Please Login here</a></h5>

    <div class="row">

      <section class="col-md-6 offset-md-3">

        <form action="" method="post" id="userRegisterForm">


          <!------------------------------ First Step ----------------------------------->

          <div id="firstStep" class="my-5 steps-div">

            <h4 class="text-uppercase font-time  breadcrumb">Personal Details</h4>

            <div class="form-group">
              <label for="userName">Enter Your Username</label>
              <input type="email" class="form-control" name="userName" id="userName" placeholder="Email">
            </div>

            <div class="form-group">
              <label for="firstName">First Name</label>
              <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name">
            </div>

            <div class="form-group">
              <label for="lastName">Last Name</label>
              <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name">
            </div>


            <div class="form-group">
              <label for="mobileNumber">Mobile Number</label>
              <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" placeholder="Mobile Number">
            </div>

            <button type="button" class="btn btn-primary" id="firstStepButton">Continue</button>

          </div>


          <!------------------------------ Second Step ----------------------------------->

          <div id="secondStep" class="my-5 steps-div">

            <h4 class="text-uppercase font-time breadcrumb">Password Details</h4>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
              <small class="text-danger">Password should Contain atleast 8 Character, Minimum one uppercase letter,
                Minimum one lowercase letter,
                minimum one number, Minimum one special character. </small>
            </div>


            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" autocomplete="off" placeholder="Confirm Password">
            </div>

            <div class="text-center my-2">
              <div class="g-recaptcha text-center" data-sitekey=<?php echo $recaptchaSiteKey; ?>></div>
            </div>

            <button class="btn btn-secondary" id="secondStepButtonBack" type="button">Back</button>

            <input type="submit" name="submit" class="btn btn-primary" value="Register Here">

          </div>


        </form>
      </section>
    </div>
  </main>

  <!-- Include Footer Script -->
  <?php include_once "includes/footerScripts.php"; ?>

  <!--Javascript -->
  <script src="js/register.js"></script>

  <script>
    $(document).ready(function() {
      $("#firstStepButton").click(function() {
        $(".steps-div").hide();
        $("#secondStep").show();
      })

      $("#secondStepButtonBack").click(function() {
        $(".steps-div").hide();
        $("#firstStep").show();
        
      })

      $("#secondStepButtonContinue").click(function() {
        $(".steps-div").hide();
        $("#thirdStep").show();
      })

      $("#thirdStepButton").click(function() {
        $(".steps-div").hide();
        $("#secondStep").show();
      })

    })
  </script>

  <!-- Close Database Connection -->
  <?php $conn = null; ?>

</body>

</html>