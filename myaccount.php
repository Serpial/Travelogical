<!DOCTYPE html>
<?php
?>

<html>
<head>

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

<div id="content-wrapper">

    <h2 id="accounts-header" style="grid-row-start:2;grid-row-end:3;grid-column-start:2;grid-column-end:3;">Your
        Account</h2>

    <p id="accounts-subheader" style="grid-row-start:3;grid-row-end:4;grid-column-start:2;grid-column-end:3;">Below is a
        summary of all the journeys you've saved with us. You can save a journey on the site using the "save" button
        after you've had your information calculated.</p>

    <table id="routes-table" style="grid-row-start:4;grid-row-end:5;grid-column-start:2;grid-column-end:3;">

        <tr>
            <th style="width:55%;">Journey</th>
            <th style="width:20%;">Cost</th>
            <th style="width:20%;">Emissions</th>
            <th style="width:5%;"></th>
        </tr>
        <?php if (isset($_SESSION['userID'])) {
            include 'connectDB.php';
            $starts = array();
            $ends = array();
            $emissions = array();
            $costs = array();
            $userID = $_SESSION['userID'];
            $getSQL = "SELECT * FROM users WHERE user_id = '$userID'";
            $getResult = $conn->query($getSQL);
            $row = $getResult->fetch_assoc();
            $curJourneys = $row['journeys'];
            while ($curJourneys != "") {
                array_push($starts, strstr($curJourneys, ':', true));
                $curJourneys = strstr($curJourneys, ':');
                $curJourneys = substr($curJourneys, 1);
                array_push($ends, strstr($curJourneys, ':', true));
                $curJourneys = strstr($curJourneys, ':');
                $curJourneys = substr($curJourneys, 1);
                array_push($costs, strstr($curJourneys, ':', true));
                $curJourneys = strstr($curJourneys, ':');
                $curJourneys = substr($curJourneys, 1);
                array_push($emissions, strstr($curJourneys, ';', true));
                $curJourneys = strstr($curJourneys, ';');
                $curJourneys = substr($curJourneys, 1);
            }
            for ($i = 0; $i < sizeof($starts); $i = $i + 1) {
                $j = sizeof($starts) - $i - 1;?>
                <tr>
                    <td><?php echo $starts[$j] . " to " . $ends[$j]; ?></td>
                    <td><?php echo "£" . number_format($costs[$j], 2) ?></td>
                    <td><?php echo number_format($emissions[$j], 0) . "kg" ?></td>
                </tr>
            <?php }
            if (sizeof($starts) < 10) {
                for ($i = sizeof($starts); $i < 10; $i = $i + 1) { ?>
                    <tr>
                        <td> -</td>
                        <td> -</td>
                        <td> -</td>
                    </tr>
                <?php }
            }
        }?>


    </table>

</div>

<footer>

    <div id="footer-container">
        <p>Map data/API ©2018 Google | Website and functionality created by Cameron Gemmell, Paul Hutchison, David
            McFadyen, Heather Thorburn, Ross Williamson for the Web Applications Development (CS312) Class, University
            of Strathclyde</p>
    </div>

</footer>

</body>

</html>
