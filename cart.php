<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
<link href="./assets/styles/cart.css" media="all" rel="stylesheet" type="text/css">
<?php
require_once("./header.php");
require_once('./cartInfos.php');
require_once("./movieCard.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  updateInfos();
}

function getHistory($owner)
{
  $historyCart = getCartHistory($owner);
  if (count($historyCart) == 0) return;
  $cartHistory = '<div class="history">';
  $cartHistory .= '<h2>History</h2>';
  $IDArray = [];
  foreach ($historyCart as $entryInfo) {
    array_push($IDArray, $entryInfo['value']);
    $movieIdList = explode(',', $entryInfo['value']);
    $infos = ['title', 'price', 'poster_path', 'vote_average'];
    if (count($movieIdList) > 0) {
      $cartHistory .= '<h2>' . $entryInfo['timestamp'] . '</h2>';
      $cartHistory .= '<div class="history-card">';
      foreach ($movieIdList as $id) {
        $filmInfos = getInfosFilmFromId($id, $infos);
        $historyFilmList[$id] = [
          'id' => $id,
          'title' => $filmInfos['title'],
          'price' => $filmInfos['price'],
          'poster' => $filmInfos['poster_path'],
          'voteAverage' => $filmInfos['vote_average'],
        ];
        $cartHistory .= createMovieCard($historyFilmList[$id]);
      }
      $cartHistory .= '</div>';
    }
  }
  $cartHistory .= '</div>';
  return $cartHistory;
}

$cartHistory = getHistory($owner);

if (count($filmList) == 0) {
  echo '<h2>Your cart is empty</h2>';
  echo $cartHistory;
  return;
}

$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);

echo '<main>';
displayFilmList($filmList);
displaySummary($totalPrice, $totalQuantity);
echo '</main>';

echo $cartHistory;
require_once('./footer.php')

?>