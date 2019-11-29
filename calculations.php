<?php
  function convertMetres($distance) {
    $distance*=0.000621371;
    return $distance;    
  }
  
  function convertKM($distance) {
    $distance *= 0.621371;
    return $distance;
  }
  
  function calculateEmissions($distance, $engineType, $engineSize) {
    $distance = convertKM($distance);
    $emissions = 0;
    switch($engineSize) {
      case "1-1.9":
        if($engineType === "petrol") {
          $emissions = 139.00*$distance;
        }
        else if ($engineType === "diesel") {
          $emissions = 109.00*$distance;
        }
        else {
          $emissions = 52.55*$distance;                     
        }
        break;
        
      case "2-2.9":
        if($engineType === "petrol") {
          $emissions = 230*$distance;
        }
        else if ($engineType === "diesel") {
          $emissions = 232*$distance;
        }
        else {
          $emissions = 52.55*$distance;        
        }
        break;
      case "3-3.9":
        if($engineType === "petrol") {
          $emissions = 242*$distance;
        }
        else if ($engineType === "diesel") {
          $emissions = 294*$distance;
        }
        else {
          $emissions = 52.55*$distance;
        }
        break;
        
      case "4-4.9":
        if($engineType === "petrol") {
          $emissions = 307*$distance;
        }
        else if ($engineType === "diesel") {
          $emissions = 270*$distance;
        }
        else {
          $emissions = 52.55*$distance;           
        }
        break;
      case "5+":
        if($engineType === "petrol") {
          $emissions = 338.00*$distance;
        }
        else if ($engineType === "diesel") {
          $emissions = 298.00*$distance;
        }
        else {
          $emissions = 52.55*$distance;         
        }
        break;
        
      default:
        $emissions = -420.69;
        break;        
    }      
    return $emissions/1000;
  }
  
  function calculatePrice($engineSize, $engineType, $distance) {
    $distance = convertMetres($distance);
    switch($engineSize) {
      case "1-1.9":
        if($engineType === "petrol") {
          $journeyCost = 12.45*$distance;
        }
        else if ($engineType === "diesel") {
          $journeyCost = 8.71*$distance;
        }
        else {
          $journeyCost = 4.33*$distance;                      
        }
        break;
        
      case "2-2.9":
        if($engineType === "petrol") {
          $journeyCost = 19.81*$distance;
        }
        else if ($engineType === "diesel") {
          $journeyCost = 18.69*$distance;
        }
        else {
          $journeyCost = 4.33*$distance;         
        }
        break;
      case "3-3.9":
        if($engineType === "petrol") {
          $journeyCost = 20.8*$distance;
        }
        else if ($engineType === "diesel") {
          $journeyCost = 23.63*$distance;
        }
        else {
          $journeyCost = 4.33*$distance;
        }
        break;
        
      case "4-4.9":
        if($engineType === "petrol") {
          $journeyCost = 27.66*$distance;
        }
        else if ($engineType === "diesel") {
          $journeyCost = 21.66*$distance;
        }
        else {
          $journeyCost = 4.33*$distance;     
        }
        break;
      case "5+":
        if($engineType === "petrol") {
          $journeyCost = 30.54*$distance;
        }
        else if ($engineType === "diesel") {
          $journeyCost = 24*$distance;
        }
        else {
          $journeyCost = 4.33*$distance;          
        }
        break;
        
      default:
        $journeyCost = -420.69;
        break;        
    }

    return $journeyCost;
  }
  
  function yearlyPrice($journeyCost) {
    $yearlyCost = 240*$journeyCost;
    return $yearlyCost;
    
  }
  
  function annualEmissions($emissions) {
    $annualDamage = 240*$emissions;
    return $annualDamage;
  }
  
  function poundsPence($cost) {
    $cost = number_format($cost);
    return $cost;  
  }

  function saveRoute($start, $end, $cost, $emissions) {

  }
  
  
?>    