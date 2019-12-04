<!DOCTYPE html>
<?php 
require_once "mapsServerside.php";
require_once "calculations.php";
require "connectDB.php";

$submitted = isset($_POST['submit-button']);
$to_input=$from_input=$fueltype=$enginetype="";

if ($submitted===true)
{

extract($_POST);

// Fuel type: $fueltype = "diesel", "petrol" or "electric"
// Engine size: $enginetype = int 1.1 - 5+

// GET LOCATION DATA THROUGH TOO
    if ($to_input!="" && $from_input!="")
{
  $places = [
    grabPlaceID(filter_var($from_input, FILTER_SANITIZE_STRING)),
    grabPlaceID(filter_var($to_input, FILTER_SANITIZE_STRING))
  ];

  $coords = [
    getLongAndLat(htmlspecialchars($places[0])),
    getLongAndLat(htmlspecialchars($places[1]))
  ];

  $names = getPlaceNames($places[0], $places[1]);
  $distance = getDistance($places[0], $places[1]);
  $cycleTime = getTimeCycle($places[0], $places[1]);
  
  // Just in case the car can't 
  if ($distance[1] === 0) {
    $submitted = false;
  }
} else
{
    $submitted = false;
}
}
?>

<html><head>

<title>Home - Travelogical</title>

<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet"> 
<link type="text/css" rel="stylesheet" href="stylesheets/car-global.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-header.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-form.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-result.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-footer.css"/>
<link type="text/css" rel="stylesheet" href="stylesheets/car-reactive.css"/>

<script src="https://kit.fontawesome.com/08b9c3aade.js" crossorigin="anonymous"></script>

<script src="formValidation.js"></script>
<script src="dynamicUtils.js"></script>

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

<?php if (isset($_GET['acc'])) {
    $acc = $_GET['acc']; ?>
    <div id="error-box" style="clear:both;"><p class="success-text">
            <?php if ($acc == "reset") { ?>
                Password successfully changed. Please log in.
            <?php } else if ($acc == "created") { ?>
                Account successfully created. Please log in. <?php } ?>
        </p>
    </div>
<?php } ?>


<form id="content-wrapper" method="post" onsubmit="return(validateMainForm());">
<div class="vspacer" style="grid-row-start:1;"></div>

<input type="text" <?php if ($submitted === true) {echo 'placeholder="'.$names[0].'" disabled';} else {echo 'placeholder="here"';} ?> class="location-input" id="from-input" name="from_input"/>

<div id="todescriptor">
<p>to</p>
<i class="fas fa-arrow-right"></i>
</div>

<input type="text" <?php if ($submitted === true) {echo 'placeholder="'.$names[1].'" disabled';} else {echo 'placeholder="here"';} ?> class="location-input" id="to-input" name="to_input"/>

<div class="hspacer" style="grid-column-start:1;"></div>

<div id="map-view">


</div>

<div class="hspacer" style="grid-column-start:3;"></div>

<div id="info-form">

<?php // First Header
if ($submitted === true)
{
echo '<p style="grid-column-start:1;grid-column-end:4;grid-row-start:2;grid-row-end:3;"><span class="bold">Your Carbon Footprint</span></p>';
}
else
{
echo '<p style="grid-column-start:1;grid-column-end:4;grid-row-start:2;grid-row-end:3;">What size of engine do you have?</p>';	
}
?>

<?php // First content

$commuteEmissions = 0;
$annualEmissions = 0;
if ($submitted === true)
{
$commuteEmissions = calculateEmissions($distance[1], $fueltype, $enginetype);
$annualEmissions = annualEmissions($commuteEmissions);
$annualEmissions = numberCommas($annualEmissions);
echo '
<div class="result-smalltext" style="grid-column-start:1;grid-column-end:4;grid-row-start:3;grid-row-end:4;">

<p>Your commute creates around '.$commuteEmissions.' kilograms of carbon dioxide. 
In a year, that\'s approximately '.$annualEmissions.' kilograms of carbon dioxide. Too much.</p>

</div>';

}
else
{
echo '
<div class="radio-container-container" style="grid-column-start:1;grid-column-end:4;grid-row-start:3;grid-row-end:4;">
<label class="radio-container">
  <input type="radio" name="enginetype" value="1-1.9">
  <div class="radio-custom">1-1.9 Litres</div>
</label>

<label class="radio-container">
  <input type="radio" name="enginetype" value="2-2.9">
  <div class="radio-custom">2-2.9 Litres</div>
</label>

<label class="radio-container">
  <input type="radio" name="enginetype" value="3-3.9">
  <div class="radio-custom">3-3.9 Litres</div>
</label>

<label class="radio-container">
  <input type="radio" name="enginetype" value="4-4.9">
  <div class="radio-custom">4-4.9 Litres</div>
</label>

<label class="radio-container">
  <input type="radio" name="enginetype" value="5+">
  <div class="radio-custom">5+ <br>Litres</div>
</label>
</div>
';
}
?>

<?php // Second header
if ($submitted===true)
{
echo '<p style="grid-column-start:1;grid-column-end:4;grid-row-start:4;grid-row-end:5;"><span class="bold">Your Money</span></p>';
}
else
{
echo '<p style="grid-column-start:1;grid-column-end:4;grid-row-start:4;grid-row-end:5;">Which type of fuel do you use?</p>';
}
?>

<?php // Second content
$commuteCost = 0;
$annualCost = 0;

if ($submitted===true)
{
$commuteCost = calculatePrice($enginetype, $fueltype, $distance[1]);
$annualCost = yearlyPrice($commuteCost);
$annualCost = numberCommas($annualCost);
echo '<div class="result-smalltext" style="grid-column-start:1;grid-column-end:4;grid-row-start:5;grid-row-end:6;">

<p>Your commute is costing you around £'.$commuteCost.' every day. That is approximately £'.$annualCost.' every year,
just for work. You could use that somewhere else.</p>

</div>';
}
else
{
echo '<div class="radio-container-container" style="grid-column-start:2;grid-column-end:4;grid-row-start:5;grid-row-end:6;">
<label class="radio-container">
  <input type="radio" name="fueltype" value="petrol">
  <div class="radio-custom">Petrol</div>
</label>

<label class="radio-container">
  <input type="radio" name="fueltype" value="diesel">
  <div class="radio-custom">Diesel</div>
</label>

<label class="radio-container">
  <input type="radio" name="fueltype" value="electric">
  <div class="radio-custom">Electric</div>
</label>
</div>';
}
?>

<?php // Final element
if ($submitted === true)
{
echo '<h1 class="result-bigtext" style="grid-column-start:1;grid-column-end:4;grid-row-start:7;grid-row-end:8;">It would only take '.(floor($cycleTime/60)).' minutes to cycle.</h1>';
}
else
{
echo '<input id="form-submit" type="submit" name="submit-button" value="Go" style="grid-column-start:1;grid-column-end:4;grid-row-start:7;grid-row-end:8;"/>';
}
?>

</div>

<div class="hspacer" style="grid-column-start:5;"></div>

<div class="vspacer" style="grid-row-start:3;"></div>

<?php 

if ($submitted===true)
{
    if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $getSQL = "SELECT * FROM users WHERE user_id = '$userID'";
            $getResult = $conn->query($getSQL);
            $row = $getResult->fetch_assoc();
            $curJourneys = $row['journeys'];
            $curJourneys .= $names[0] . ":" . $names[1] . ":" . $commuteCost . ":" . $commuteEmissions . ";";
            $sql = "UPDATE users SET journeys = '$curJourneys' WHERE user_id = '$userID'";
            $curResult = $conn->query($sql);
        }
echo '<div id="map-controls" style="grid-row-start:5;grid-row-end:6;grid-column-start:2;grid-column-end:3;">
<a href="index.php" id="back-link"><p>back</p></a>
<div class="vspacer" style="grid-row-start:5;grid-column-start:3;clear:both;"></div>';
}
else
{
echo '<div class="vspacer" style="grid-row-start:5;"></div>';
}

?>

</form>

<br>

<?php if ($submitted===false)
{
echo '<div id="instructions" class="closed">
<a href="javascript:hideInstructions()"><h3 id="instructions-title">Instructions <i id="instructions-arrow" class="far fa-plus-square"></i></a></h3>
<br>
<p id="instructions-text">Tell us about your commute at the top of the page (where you come from and where you go), then describe your car (your engine size and fuel type) and we\'ll give you some insight into your impact on the planet and what you can do about it.</p>

</div>';
}
?>
<br>
<footer>

<div id="footer-container">
<p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Ross Williamson, Paul Hutchison, David McFadyen and Heather Thorburn for the Web Applications Development (CS312) Class, University of Strathclyde</p>
</div>

</footer>

</body>

<script>
  var place1 = <?php echo (isset($coords)? $coords[0]: "null")?>;
  var place2 = <?php echo (isset($coords)? $coords[1]: "null")?>;
  var distance = <?php if (isset($coords)) {
      echo json_encode($distance);
    } else {
      echo "null";
    } 
  ?>;
</script>
<script src="mapsClient.js" type='text/javascript'></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqQzNsSyFNG1PIAgBYUwRKT8POFFxBv0c&callback=initMap"
    async defer></script>

</html>
