<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
<link href="./assets/styles/cart.css" media="all" rel="stylesheet" type="text/css">
<?php
require_once("./header.php");
require_once('./cartInfos.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  updateInfos();
}

if (count($filmList) == 0) {
  echo '<h2>Your cart is empty</h2>';
  return;
}

$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);

echo '<main>';
displayFilmList($filmList);
displaySummary($totalPrice, $totalQuantity);
echo '</main>';




?>