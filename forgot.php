<!DOCTYPE html>
<?php

if (isset($_GET['error'])) {
    $prevError = $_GET['error'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userEmail = $emailErr = "";
    $userEmail = $_POST['email'];


    if (empty($userEmail)) {
        $emailErr = "Please enter your e-mail address.";
    } else if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Please enter a valid e-mail address";
    }
}


if (isset($_POST['forgot-submit']) && empty($emailErr)) {
    require 'connectDB.php';
    $findSQL = "SELECT * FROM users WHERE email = '$userEmail'";
    $findResult = $conn->query($findSQL);
    if (mysqli_num_rows($findResult) > 0) {
        $code = bin2hex(random_bytes(8));
        $link = "https://devweb2019.cis.strath.ac.uk/~gtb17118/final_assignment/reset.php?code=$code";
        $row = $findResult->fetch_assoc();
        $name = $row['user_name'];
        $message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>Dear $name, </p>
<p>Following a request to reset you password, please click the link below to reset your password: <br>
<a href = '$link'>Reset Now </a><br><p>
</p>This link will expire one hour from when requested.</p>
<p>If you did not request this, please contact us.</p>
<p>Kind regards,<br>
Team Travelogical</p> 
</body>
</html>
";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Travelogical' . "\r\n";

        mail($userEmail, "Travelogical Password Reset", $message, $headers);
        $expiry = time() + 3600;
        $sql = "UPDATE users SET reset = '$code', reset_expiry = '$expiry' WHERE email = '$userEmail'";
        $result = $conn->query($sql);
    }
}


?>

<html>
<head>

    <title>Forgotten Password - Travelogical</title>

    <link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="stylesheets/car-global.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-header.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-login.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-footer.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-reactive.css"/>

    <script src="https://kit.fontawesome.com/08b9c3aade.js" crossorigin="anonymous"></script>

    <script src="formValidation.js"></script>

</head>

<body>

<header style="">
    <?php session_start();
    if (empty($_SESSION['userID'])) { ?>
        <a href="login.php" class="header-right">log in</a>
    <?php } else { ?>
        <a href="myaccount.php" class="header-right">my account</a>
        <a href="logout.php" class="header-right">log out</a>
    <?php } ?>
    <a href="index.php" class="header-left">home</a>
</header>
<br>

<div id="error-box" style="clear:both;">
    <?php
    if (isset($_GET['error']) && $prevError == true) { ?>
        <p class="error-text">Error resetting your password. It may have expired. Please try sending another
            link.</p> <?php
    }
    if (isset($emailErr)) {
    if (empty($emailErr)) { ?>
        <p class="success-text">If we find an account associated with that e-Mail address, you should receive a
            message shortly with instructions. Ensure you check your spam.</p>
    <?php } else { ?>
    <p class="error-text">Please resolve the following errors: <br> <?php echo $emailErr;
        }
        } ?>
    </p>
</div>

<form id="login-wrapper" style="min-width:600px;" method="POST" action="<?php echo substr($_SERVER["PHP_SELF"],1); ?>">

    <div class="hspacer" style="grid-column-start:1;grid-column-end:1;grid-row-start:1;grid-row-end:10;"></div>
    <div class="hspacer" style="grid-column-start:6;grid-column-end:7;grid-row-start:1;grid-row-end:10;"></div>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:1;grid-row-end:2;"></div>

    <h1 class="form-header" style="grid-column-start:2;grid-column-end:6;grid-row-start:2;grid-row-end:3;">Forgot Your
        Password</h1>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:3;grid-row-end:4;"></div>

    <p style="grid-column-start:2;grid-column-end:6;grid-row-start:4;grid-row-end:5;">Enter your e-Mail address and we
        will send you instructions for resetting your password.</p>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:5;grid-row-end:6;"></div>

    <label class="login-smalltext" for="email"
           style="grid-column-start:2;grid-column-end:3;grid-row-start:6;grid-row-end:7;overflow:hidden;">
        e-Mail Address
    </label>

    <input class="login-input" type="text" name="email"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:6;grid-row-end:7;"/>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:7;grid-row-end:8;"></div>

    <input id="login-submit" value="Request" name="login-submit" type="submit"
           style="grid-column-start:5;grid-column-end:7;grid-row-start:8;grid-row-end:9;"/>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:9;grid-row-end:10;"></div>

</form>


<footer>

    <div id="footer-container">
        <p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Paul Hutchison, David
            McFadyen, Heather Thorburn, Ross Williamson for the Web Applications Development (CS312) Class, University
            of Strathclyde</p>
    </div>

</footer>

</body>
</html>
