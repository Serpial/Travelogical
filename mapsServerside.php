<?php
require_once "api_key.php";

$distanceInfo = NULL;

function grabPlaceID ($place) {
    $link  = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?";
    $link .= "input=".replaceSpace($place);
    $link .= "&inputtype=textquery";
    $link .= "&key=".API_KEY;

    $placeJSON = file_get_contents($link);
    $placeInfo = json_decode($placeJSON);
    // please
    if ($placeInfo->status == "OK") {
        return $placeInfo->candidates[0]->place_id;
    } else {
        echo "placeinfo failed : ". $place;
        die();
    }    
    return null;    
}

function replaceSpace($string) {
    return str_replace (" ", "++", $string);
}

function getLongAndLat($placeID) {
    $link  = "https://maps.googleapis.com/maps/api/geocode/json?";
    $link .= "place_id=".$placeID;
    $link .= "&key=".API_KEY;

    $geocodingJSON = file_get_contents($link);
    $geocodingInfo = json_decode($geocodingJSON);
    $location = $geocodingInfo->results[0]->geometry->location;
    if ($geocodingInfo->status == "OK") {
        $locationStr = "{lat: ".$location->lat.",lng: ".$location->lng."}";
        return $locationStr;
    }
    return NULL;
}

function getTimeCycle($placeIDOne, $placeIDTwo) {
    $link  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
    $link .= '&origins=place_id:'.$placeIDOne.'&destinations=place_id:'.$placeIDTwo;
    $link .= '&mode=bicycling';
    $link .= '&key='.API_KEY;

    $sourceJSON = file_get_contents($link);
    $cycleInfo = json_decode($sourceJSON);
    $placeStatus = $cycleInfo->status;
    $routeStatus = $cycleInfo->rows[0]->elements[0]->status;

    if ($routeStatus != "ZERO_RESULTS" && $placeStatus == "OK") {
        return $cycleInfo->rows[0]->elements[0]->duration->value;
    }
    return NULL;
}

function getDistance($placeIDOne, $placeIDTwo) {
    global $distanceInfo;
    if ($distanceInfo == NULL) {
        $distanceInfo = grabDistanceInformation($placeIDOne, $placeIDTwo);
    }
    $distance = ["",0];

    if ($distanceInfo != NULL) {
        $distance = [
            $distanceInfo->rows[0]->elements[0]->distance->text,
            $distanceInfo->rows[0]->elements[0]->distance->value
        ];
    }
    return $distance;
}

function getPlaceNames($placeIDOne, $placeIDTwo) {
    global $distanceInfo;
    if ($distanceInfo == NULL) {
        $distanceInfo = grabDistanceInformation($placeIDOne, $placeIDTwo);
    }
    $names = ["", ""];

    if ($distanceInfo != NULL) {
        $names = [
            getFirstLine($distanceInfo->origin_addresses[0]),
            getFirstLine($distanceInfo->destination_addresses[0])
        ];
    }
    return $names;
}

function getFirstLine($str) {
    $ind = stripos($str, ',');
    
    if ($ind != FALSE) {
        $str = substr($str, 0, $ind);
    }
    return $str;

}

function grabDistanceInformation($placeIDOne, $placeIDTwo) {
    $link  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
    $link .= '&origins=place_id:'.$placeIDOne.'&destinations=place_id:'.$placeIDTwo;
    $link .= '&key='.API_KEY;

    $sourceJSON = file_get_contents($link);
    $tempInfo = json_decode($sourceJSON);
    $placeStatus = $tempInfo->status;
    $routeStatus = $tempInfo->rows[0]->elements[0]->status;

    if ($routeStatus != "ZERO_RESULTS" && $placeStatus == "OK") {
        return $tempInfo;
    }
    return NULL;
}
?>