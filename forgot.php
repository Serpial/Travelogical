<!DOCTYPE html>
<?php 



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

<script src="formValidation.js"></script>

</head>

<body>

<header style="">
<a href="logout.php" class="header-right">log out</a>
<a href="myaccount.php" class="header-right">my account</a>

<a href="index.php" class="header-left">home</a>
</header><br>

<div id="error-box" style="clear:both;"><!--<p class="success-text">If we find an account associated with that e-Mail address, you should receive a message shortly with instructions. Ensure you check your spam.</p>--></div>

<form id="login-wrapper" style="min-width:600px;" method="POST">

<div class="hspacer" style="grid-column-start:1;grid-column-end:1;grid-row-start:1;grid-row-end:10;"></div>
<div class="hspacer" style="grid-column-start:6;grid-column-end:7;grid-row-start:1;grid-row-end:10;"></div>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:1;grid-row-end:2;"></div>

<h1 class="form-header" style="grid-column-start:2;grid-column-end:6;grid-row-start:2;grid-row-end:3;">Forgot Your Password</h1>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:3;grid-row-end:4;"></div>

<p style="grid-column-start:2;grid-column-end:6;grid-row-start:4;grid-row-end:5;">Enter your e-Mail address and we will send you instructions for resetting your password.</p>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:5;grid-row-end:6;"></div>

<label class="login-smalltext" for="email" style="grid-column-start:2;grid-column-end:3;grid-row-start:6;grid-row-end:7;overflow:hidden;">
e-Mail Address
</label>

<input class="login-input" type="text" name="email" style="grid-column-start:3;grid-column-end:6;grid-row-start:6;grid-row-end:7;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:7;grid-row-end:8;"></div>

<input id="login-submit" value="Request" name="login-submit" type="submit" style="grid-column-start:5;grid-column-end:7;grid-row-start:8;grid-row-end:9;"/>

<div class="vspacer" style="grid-column-start:1;grid-column-end:7;grid-row-start:9;grid-row-end:10;"></div>

</form>


<footer>

<div id="footer-container">
<p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Paul Hutchison, David McFadyen, Heather Thorburn, Ross Williamson for the Web Applications Development (CS312) Class, University of Strathclyde</p>
</div>

</footer>

</body></html>
