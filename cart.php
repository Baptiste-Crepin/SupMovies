<?php
require_once('index.php');
require_once('database.php');

if (!isset($_SESSION['username'])) {
  header('Location: ./login.php');
  exit();
}

$cart = getUserCart($_SESSION['username']);
$filmList = getFilmArray($cart);
$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);
displayFilmList($filmList);
displaySummary($totalPrice, $totalQuantity);



function getFilmArray($cart)
{
  $filmList = [];
  foreach ($cart as $film) {
    $filmId = $film[0];
    if (array_key_exists($filmId, $filmList)) {
      $filmList[$filmId]['quantity'] += 1;
    } else {
      $filmList[$filmId] = [
        'title' => getTitleFromId($filmId)[0][0],
        'price' => getFilmPrice($filmId)[0][0],
        'poster' => getPosterFromId($filmId)[0][0],
        'quantity' => 1
      ];
    }
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

function displayFilmList($filmList)
{
  echo '<main>';
  echo '<table class="cartContent">';
  foreach ($filmList as $film) {
    echo '<tr class="filmCard">';
    echo '<td>';
    echo '<h3>' . $film['title'] . '</h3>';
    echo '<div class="informations">';
    echo '<p>' . $film['quantity'] . ' Movie ' . $film['price'] * $film['quantity'] . ' €</p>';
    echo '</div>';
    echo '</td><td>';
    echo '<img class="poster" src="https://image.tmdb.org/t/p/original' . $film['poster'] . '">';
    echo '</td></tr>';
  }
  echo '</table>';
}

function displaySummary($totalPrice, $totalQuantity)
{
  $shipingPrice = $totalQuantity * 0.67;
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
?>

<style>
  main {
    display: flex;
    gap: 2rem;
  }

  .cartContent {
    width: 60%;
    border-collapse: collapse;
  }

  .informations {
    display: flex;
    justify-content: center;
    align-items: end;
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

  .poster {
    aspect-ratio: 2/3;
    border-radius: 10px;
    border: solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  }
</style>