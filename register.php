<!DOCTYPE html>
<?php
$errorArray = array();
$userEmail = $userPass = $userName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connectDB.php';
    $userEmail = $_POST['email'];
    $userPass = $_POST['password'];
    $userName = $_POST['name'];

    if (empty($userEmail) || empty($userPass) || empty($userName)) {
        array_push($errorArray, "You must enter all required fields.");
    } else {
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            array_push($errorArray, "Please enter a valid e-mail address.");
        }
        if (!strpos(trim($userName), ' ')) {
            array_push($errorArray, "Please enter your full (First and Last) name.");
        }
        if (strlen($userPass) < 8) {
            array_push($errorArray, "Your password should be at least 8 characters long");
        }
        $checkSQL = "SELECT * FROM users WHERE email = '$userEmail'";
        $result = $conn->query($checkSQL);
        if (mysqli_num_rows($result) > 0 && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            array_push($errorArray, "E-mail already in use.");
        }
    }
}

if (isset($_POST['register-submit']) && sizeof($errorArray) == 0) {
    $hashedPass = password_hash($userPass, PASSWORD_DEFAULT);
    $newSQL = "INSERT INTO users (email, user_name, hashed_pass) VALUES ('$userEmail','$userName','$hashedPass')";
    $result = $conn->query($newSQL);
    header("Location: index.php?acc=created");
}
?>

<html><head>

<title>CAR</title>

<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet"> 
<link type="text/css" rel="stylesheet" href="stylesheets/car-global.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-header.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-login.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-footer.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-reactive.css"/>

<script src="https://kit.fontawesome.com/08b9c3aade.js" crossorigin="anonymous"></script>

<script src="formValidation.js"></script></head>
<style>

#register-wrapper
{

min-width:400px;
min-height:300px;
width:60vw;
height:47vh;

margin-left:auto;
margin-right:auto;

display:grid;
grid-template-columns: 10% 20% 20% 20% 20% 10%;
grid-template-rows: 8% 17% 4% 10% 4% 10% 4% 10% 8% 14% 11%;
	
}


</style>

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

<div id="error-box" style="clear:both;"><?php if (sizeof($errorArray) > 0) { ?><p class="error-text">Please resolve the following errors: <br>
            <?php
            for ($i = 0; $i < count($errorArray); $i++) {
                echo $errorArray[$i] . "<br>";
            } ?></p> <?php } ?> </div>

<form id="register-wrapper" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<div class="hspacer" style="grid-column-start:1;grid-column-end:1;grid-row-start:1;grid-row-end:11;"></div>
<div class="hspacer" style="grid-column-start:6;grid-column-end:7;grid-row-start:1;grid-row-end:11;"></div>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:1;grid-row-end:2;"></div>

<h1 class="form-header" style="grid-column-start:2;grid-column-end:3;grid-row-start:2;grid-row-end:3;margin-top:8%">Register</h1>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:3;grid-row-end:4;"></div>

<label class="login-smalltext" for="name" style="grid-column-start:2;grid-column-end:3;grid-row-start:4;grid-row-end:5;overflow:hidden;">
Name
</label>

    <input class="login-input" type="text" name="name" value="<?php echo $userName; ?>"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:4;grid-row-end:5;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:5;grid-row-end:6;"></div>

<label class="login-smalltext" for="email" style="grid-column-start:2;grid-column-end:3;grid-row-start:6;grid-row-end:7;overflow:hidden;">
e-Mail Address
</label>

    <input class="login-input" type="text" name="email" value="<?php echo $userEmail; ?>"
           style="grid-column-start:3;grid-column-end:6;grid-row-start:6;grid-row-end:7;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:7;grid-row-end:8;"></div>

<label class="login-smalltext" for="password" style="grid-column-start:2;grid-column-end:3;grid-row-start:8;grid-row-end:9;">
Password
</label>

<input class="login-input" type="password" name="password" style="grid-column-start:3;grid-column-end:6;grid-row-start:8;grid-row-end:9;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:9;grid-row-end:10;"></div>

<input id="login-submit" value="Register" name="register-submit" type="submit" style="grid-column-start:5;grid-column-end:7;grid-row-start:10;grid-row-end:11;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:11;grid-row-end:12;"></div>

</form>


<footer>

<div id="footer-container">
<p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Paul Hutchison, David McFadyen, Heather Thorburn, Ross Williamson for the Web Applications Development (CS312) Class, University of Strathclyde</p>
</div>

</footer>

</body></html>
