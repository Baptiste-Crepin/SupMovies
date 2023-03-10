<?php
require_once("./header.php");

function getFilmArray($owner, $cart)
{
  $filmList = [];
  foreach ($cart as $film) {
    $filmId = $film[0];
    $infos = ['title', 'price', 'poster_path'];
    $filmInfos = getInfosFilmFromId($filmId, $infos);
    $filmTitle = $filmInfos['title'];
    $filmPrice = $filmInfos['price'];
    $filmPoster = $filmInfos['poster_path'];
    $filmQuantity = getQuantityFromId($owner, $filmId)[0][0];

    if (isset($_GET['delete']) && $filmId == $_GET['id'] && $_GET['delete'] == 'true') continue;
    if (isset($_GET['id']) && $filmId == $_GET['id'] && isset($_GET['quantity'])) {
      $filmQuantity = $_GET['quantity'];
    }

    $filmList[$filmId] = [
      'id' => $filmId,
      'title' => $filmTitle,
      'price' => $filmPrice,
      'poster' => $filmPoster,
      'quantity' => $filmQuantity,
    ];
  };
  return $filmList;
}


function getTotalQuantity($filmList)
{
  $totalQuantity = 0;
  foreach ($filmList as $film) {
    $totalQuantity += $film['quantity'];
  }
  return $totalQuantity;
}

function getTotalPrice($filmList)
{
  $totalPrice = 0;
  foreach ($filmList as $film) {
    $totalPrice += $film['price'] * $film['quantity'];
  }
  return $totalPrice;
}

function updateInfos()
{
  $owner = $_SESSION['username'];
  if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    removeEntry($owner, $_GET['id']);
  }
  if (isset($_GET['quantity']) || !empty($_GET['quantity'])) {
    setQuantity($owner, $_GET['id'], $_GET['quantity']);
  }
}

function displayFilmList($filmList)
{
  $output = <<<HTML
  <table class="cartContent">
  HTML;
  foreach ($filmList as $film) {
    $output .= <<<HTML
    <tr class="filmCard">
      <td>
        <h3> {$film['title']} </h3>
        <p> {$film['price']} €</p>
        <div class="informations">
          <form class="amount" method="get" action="cart.php">
            <input type="hidden" name="id", value=" {$film['id']} ">
            <select class="quantitySelector" name="quantity" onchange="this.form.submit();">
              <option value="defaultQuantity" selected>{$film['quantity']}</option>
      
    HTML;
    for ($i = 1; $i <= 99; $i++) {
      if ($i == $film['quantity']) continue;
      $output .= <<<HTML
              <option value="{$i}">{$i}</option>
              HTML;
    }

    $output .= <<<HTML
                </select>
              <p>Movies</p>
    HTML;

    if ($film['quantity'] > 1) {
      $bunchPrice = $film['quantity'] * $film['price'];
      $output .= <<<HTML
              <p> {$bunchPrice} €</p>
      HTML;
    }


    $output .= <<<HTML
            <button class="deleteButton" type="submit" name="delete" value="true">
            <!-- <button class="deleteButton" type="submit" name="delete" value="true" onclick="window.location.reload(true);"> -->
              <img class="icons" draggable="false" src="./assets/icons/trash-solid.svg">
            </button>
          </form>
        </div>
      </td>
      <td>
        <img class="poster" src="https://image.tmdb.org/t/p/original{$film['poster']}">
      </td>
    </tr>
    HTML;
  }
  $output .= <<<HTML
  </table>
  HTML;
  echo $output;
}

function getShippingPrice($totalQuantity)
{
  return $totalQuantity * 0.27;
}


function displaySummary($totalPrice, $totalQuantity)
{
  $shipingPrice = getShippingPrice($totalQuantity);
  $TotalOrderPrice = $totalPrice + $shipingPrice;
  $output = <<<HTML
  <div id="summary" class="filmCard">
    <div class="summary-price">
      <p> {$totalQuantity} Movies</p>
      <h3 class="title"> {$totalPrice} €</h5>
    </div>
    <div class="summary-price">
      <p>Shipping</p> <h3> {$shipingPrice} €</h3>
    </div>
    <h3 id="totalPrice"> Total {$TotalOrderPrice} €</h3>
    <a href="./checkout.php"><button>Go to checkout</button></a>
  </div>
  HTML;
  echo $output;
}

$owner = $_SESSION['username'];
if (!isset($owner)) {
  header('Location: ./login.php');
  exit();
}

require_once('./database.php');
$cart = getUserCart($owner);
$filmList = getFilmArray($owner, $cart);
