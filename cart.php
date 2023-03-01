<?php
require_once('index.php');
require_once('database.php');

$owner = $_SESSION['username'];
if (!isset($owner)) {
  header('Location: ./login.php');
  exit();
}

$cart = getUserCart($owner);
$filmList = getFilmArray($owner, $cart);
if (count($filmList) == 0) {
  echo '<h2>Your cart is empty</h2>';
  return;
}
$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);
displayFilmList($filmList);
displaySummary($totalPrice, $totalQuantity);


function getFilmArray($owner, $cart)
{
  $filmList = [];
  foreach ($cart as $film) {
    $filmId = $film[0];

    $filmTitle = getTitleFromId($filmId)[0][0];
    $filmPrice = getFilmPrice($filmId)[0][0];
    $filmPoster = getPosterFromId($filmId)[0][0];
    $filmQuantity = getQuantityFromId($owner, $filmId)[0][0];

    if (isset($_GET['delete']) && $filmId == $_GET['id'] && $_GET['delete'] == 'true') continue;
    if (isset($_GET['id']) && $filmId == $_GET['id']) $filmQuantity = $_GET['quantity'];

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

function changeQuantity()
{
  $owner = $_SESSION['username'];

  if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    removeEntry($owner, $_GET['id']);
  }
  if (isset($_GET['quantity']) or !empty($_GET['quantity'])) {
    setQuantity($owner, $_GET['id'], $_GET['quantity']);
  }
}


function displayFilmList($filmList)
{
  echo '<main>';
  echo '<table class="cartContent">';
  foreach ($filmList as $film) {
    echo '<tr class="filmCard">';
    echo '<td>';
    echo '<h3>' . $film['title'] . '</h3>';
    echo '<p>' . $film['price'] . ' €</p>';
    echo '<div class="informations">';
    echo '<form class="amount" method="get" action="cart.php">';
    echo '<input type="hidden" name="id", value="' . $film['id'] . '">';

    echo '<input type="number" min="1" max="100" name="quantity", value="' . $film['quantity'] . '">';
    echo '<p>' . $film['quantity'] . '</p>';

    echo '</form>';

    echo  '<p>Movies</p>';
    if ($film['quantity'] > 1) {
      echo '<p> ' . $film['quantity'] * $film['price'] . ' €</p>';
    }
    echo '</div>';
    echo '<form class="amount" method="get" action="cart.php">';
    echo '<input type="hidden" name="id", value="' . $film['id'] . '">';

    echo '<button type="submit" name="delete" value="true" onclick="window.location.reload(true);">';
    echo '<img class="icons"  src="./assets/icons/trash-solid.svg">';
    echo '</button>';

    echo '</form>';

    echo '</td><td>';
    echo '<img class="poster" src="https://image.tmdb.org/t/p/original' . $film['poster'] . '">';
    echo '</td></tr>';
  }
  echo '</table>';
}

function displaySummary($totalPrice, $totalQuantity)
{
  $shipingPrice = $totalQuantity * 0.27;
  echo '<div id="summary" class="filmCard">';
  echo '<div class="summary-price">';
  echo '<p>' . $totalQuantity . ' Movies</p>';
  echo '<h3 class="title">' . $totalPrice . ' €</h5>';
  echo '</div>';
  echo '<div class="summary-price">';
  echo '<p> Shipping </p> <h3>' . $shipingPrice . ' €</h3>';
  echo '</div>';
  echo '<h3 id="totalPrice"> Total ' . $totalPrice + $shipingPrice . ' €</h3>';
  echo '<button>Go to checkout</button>';
  echo '</div>';
  echo '</main>';
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  changeQuantity();
}
?>

<style>
  main {
    display: flex;
    gap: 2rem;
    width: 90%;
  }

  .cartContent {
    width: 70%;
    border-collapse: collapse;
  }

  .informations {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
  }

  .informations p {
    margin: 0;
  }

  .summary-price {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }

  h3 {
    text-align: center;
    margin: 0;
  }

  #summary {
    width: 30%;
    height: fit-content;
    flex-direction: column;
    gap: 0;
    position: sticky;
    top: 2rem;
  }

  #summary button {
    padding: .5rem .3rem;
    width: 80%;
    margin: .3rem;
    border-radius: 50px;
    border: none;
    font-size: 1.4rem;
    font-weight: bold;
    background-color: #FFA500;
    color: #FFF;
    transition: 0.3s ease-in-out;
  }

  #summary button:hover {
    background-color: #FF6347;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.7);
  }

  #summary #totalPrice {
    font-size: 1.5rem;
    margin-top: 1.5rem;
  }

  .amount {
    gap: 1em;
    display: flex;
    flex-direction: row;
    margin: 0;
    justify-content: center;
    align-items: center;
  }

  .filmCard {
    position: relative;
    display: flex;
    align-items: center;
    height: 30vh;
    margin: 1rem 0;
    padding: 1rem;
    background: #008080;
    border: 10px solid;
    gap: 1rem;
  }

  td:nth-child(1) {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: space-evenly;
    width: 80%;
    height: 100%;
  }

  .icons {
    height: 1.5em;
  }

  .poster {
    aspect-ratio: 2/3;
    border-radius: 10px;
    border: solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  }
</style>