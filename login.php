<?php
$errorArray = array();
$userEmail = $userPass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connectDB.php';
    $userEmail = $_POST['email'];
    $userPass = $_POST['password'];


    if (empty($userEmail)) {
        array_push($errorArray, "Please enter both your registered e-mail address.");
    } else if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        array_push($errorArray, "Please enter a valid e-mail address.");
    }

    if (empty($userPass)) {
        array_push($errorArray, "Please enter your password.");
    }

    if (sizeof($errorArray) == 0) {
        $sql = "SELECT * FROM users WHERE email = '$userEmail'";
        $result = $conn->query($sql);
        if (!$result) {
            array_push($errorArray, "E-mail/Password not recognised.");
        } else {
            $row = $result->fetch_assoc();
            $hashedPass = $row['hashed_pass'];
            $passwordValid = password_verify($userPass, $hashedPass);
            if ($passwordValid == false) {
                array_push($errorArray, "E-mail/Password not recognised.");
            }
        }
    }
}


if (isset($_POST['login-submit']) && sizeof($errorArray) == 0) {

    session_start();
    $_SESSION['userID'] = $row['user_id'];
    $_SESSION['userEmail'] = $row['email'];
    header("Location: index.php");
    exit();

}
?>

<!DOCTYPE html>

<html>
<head>

    <title>Login - Travelogical</title>

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


<div id="error-box" style="clear:both;"><?php if (sizeof($errorArray) > 0) { ?> <p class="error-text">Please resolve the
        following errors: <br>
        <?php
        for ($i = 0; $i < count($errorArray); $i++) {
            echo $errorArray[$i] . "<br>";
        } ?>
    </p> <?php } ?>
</div>

<form id="login-wrapper" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

    <div class="hspacer" style="grid-column-start:1;grid-column-end:1;grid-row-start:1;grid-row-end:10;"></div>
    <div class="hspacer" style="grid-column-start:6;grid-column-end:7;grid-row-start:1;grid-row-end:10;"></div>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:1;grid-row-end:2;"></div>

    <h1 class="form-header" style="grid-column-start:2;grid-column-end:3;grid-row-start:2;grid-row-end:3;">Login</h1>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:3;grid-row-end:4;"></div>

    <label class="login-smalltext" for="email"
           style="grid-column-start:2;grid-column-end:3;grid-row-start:4;grid-row-end:5;overflow:hidden;">
        e-Mail Address
    </label>

    <input class="login-input" type="text" value="<?php echo $userEmail; ?>" name="email"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:4;grid-row-end:5;"/>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:5;grid-row-end:6;"></div>

    <label class="login-smalltext" for="password" autocomplete="new-password"
           style="grid-column-start:2;grid-column-end:3;grid-row-start:6;grid-row-end:7;">
        Password
    </label>

    <input class="login-input" type="password" name="password"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:6;grid-row-end:7;"/>

    <div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:7;grid-row-end:8;"></div>

    <a href="register.php" id="register-link"
       style="grid-column-start:2;grid-column-end:3;grid-row-start:8;grid-row-end:9;">
        Register
    </a>

    <a href="forgot.php" id="forgot-link"
       style="grid-column-start:3;grid-column-end:4;grid-row-start:8;grid-row-end:9;">
        Forgot Password?
    </a>

    <input id="login-submit" value="Log In" name="login-submit" type="submit"
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
