<?php

session_start();
if ($_SESSION['userID']!=null); {
    header ("Location: index.php");
}

$code = "";
$code = $_GET['code'];
require 'connectDB.php';
$sql = "SELECT * FROM users WHERE reset = '$code'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    $row = $result->fetch_assoc();
    if ($row['reset_expiry'] < time()) {
        $expiredSQL = "UPDATE users SET reset = NULL, reset_expiry = NULL WHERE reset = '$code'";
        $conn->query($expiredSQL);
        header("Location: forgot.php?error=true");
        exit();
    }
} else {
    header("Location: forgot.php?error=true");
    exit();
}

if (isset($_POST['reset-submit'])) {
    $password = $_POST['password'];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $resetSQL = "UPDATE users SET hashed_pass = '$hashedPass', reset = NULL WHERE reset = '$code'";
    $resetResult = $conn->query($resetSQL);
    header("Location: final_assignment/index.php?acc=reset");
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>CAR</title>

    <link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="stylesheets/car-global.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-header.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-login.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-footer.css"/>
    <link type="text/css" rel="stylesheet" href="stylesheets/car-reactive.css"/>

    <script src="https://kit.fontawesome.com/08b9c3aade.js" crossorigin="anonymous"></script>

    <script src="formValidation.js"></script>

    <script type="text/javascript">
        function validatePassword() {
            var password = document.forms["login-wrapper"]["password"].value;

            if (password === '' || password == null) {
                alert("\nPlease enter a new password.");
                return false;
            } else if (password.length < 8) {
                alert("\nYour password must be at least 8 characters.");
                return false;
            }
        }
    </script>

</head>

<body>


<header style="">
    <?php
    if (empty($_SESSION['userID'])) { ?>
        <a href="login.php" class="header-right">log in</a>
    <?php } else {
        ?>
        <a href="myaccount.php" class="header-right">my account</a>
        <a href="logout.php" class="header-right">log out</a>
    <?php } ?>
    <a href="index.php" class="header-left">home</a>
</header>
<br>


<div id="error-box" style="clear:both;">
    <p class="success-text">Please enter your new password. <?php echo $code ?></p>
</div>

<form id="login-wrapper" style="min-width:600px;" method="POST" onSubmit="return validatePassword()" action="">

    <div class="hspacer" style="grid-column-start:1;grid-column-end:1;grid-row-start:1;grid-row-end:10;"></div>
    <div class="hspacer" style="grid-column-start:6;grid-column-end:7;grid-row-start:1;grid-row-end:10;"></div>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:1;grid-row-end:2;"></div>

    <h1 class="form-header" style="grid-column-start:2;grid-column-end:6;grid-row-start:2;grid-row-end:3;">Reset
        your password.</h1>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:3;grid-row-end:4;"></div>


    <label class="login-smalltext" for="email"
           style="grid-column-start:2;grid-column-end:3;grid-row-start:6;grid-row-end:7;overflow:hidden;">
        new password:
    </label>

    <input class="login-input" type="password" name="password"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:6;grid-row-end:7;"/>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:7;grid-row-end:8;"></div>

    <input id="login-submit" value="Reset" name="reset-submit" type="submit"
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

