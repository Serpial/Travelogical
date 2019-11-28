<!DOCTYPE html>
<?php 


?>

<html><head>

<title>CAR</title>

<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet"> 
<link type="text/css" rel="stylesheet" href="stylesheets/car-global.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-header.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-account.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-footer.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-reactive.css"/>

<script src="https://kit.fontawesome.com/08b9c3aade.js" crossorigin="anonymous"></script>

<script src="formValidation.js"></script>
<script src="dynamicUtils.js"></script>

</head>

<body>

<header style="">
<a href="logout.php" class="header-right">log out</a>
<a href="myaccount.php" class="header-right">my account</a>

<a href="index.php" class="header-left">home</a>
</header><br>

<div id="content-wrapper">

<h2 id="accounts-header" style="grid-row-start:2;grid-row-end:3;grid-column-start:2;grid-column-end:3;">Your Account</h2>

<p id="accounts-subheader" style="grid-row-start:3;grid-row-end:4;grid-column-start:2;grid-column-end:3;">Below is a summary of all the journeys you've saved with us. You can save a journey on the site using the "save" button after you've had your information calculated.</p>

<table id="routes-table" style="grid-row-start:4;grid-row-end:5;grid-column-start:2;grid-column-end:3;">

<tr><th style="width:55%;">Journey</th><th style="width:20%;">Cost</th><th style="width:20%;">Emissions</th><th style="width:5%;"></th></tr>

<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>
<tr><td>Aaaaaaaaa to Bbbbbbbbb</td><td>£14.73</td><td>23g</td><td><a href="#delete"><div class="delete-button">X</div></a></td></tr>


</table>

</div>

<footer>

<div id="footer-container">
<p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Paul Hutchison, David McFadyen, Heather Thorburn, Ross Williamson for the Web Applications Development (CS312) Class, University of Strathclyde</p>
</div>

</footer>

</body>

</html>
