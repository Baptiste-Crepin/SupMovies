<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
  <title>SupMovies</title>
</head>

</html>

<?php
require_once('./header.php');
require_once('database.php');

if (isset($_GET["submit"])) {
  $res = $_GET["search"];
  $film = getTitle($res);
  $id = [];
  foreach ($film as $filmTitle) {
    array_push($id, getId($filmTitle[0]));
  }
?>


  <?php
  if (count($film) == 0) {
    echo '<h1> No results for \'' . $res . '\'</h1>';
    return;
  }
  require_once('./movieCard.php');
  if ($res != "") {
    echo '<h1>Results for \'' . $res . '\' :</h1>';
  }

  echo '<div class="movie-list">';
  foreach ($film as $f) {
    $id = getId($f[0])[0][0];
    $infos = getInfosFilmFromId($id, ['title', 'poster_path', 'price', 'vote_average']);
    $movie = [
      'id' => $id,
      'title' => $infos['title'],
      'poster' => $infos['poster_path'],
      'price' => $infos['price'],
      'voteAverage' => $infos['vote_average'],
    ];
    echo createMovieCard($movie);
  }
  echo '</div>';
  ?>

<?php
}
if (isset($_GET["submit_director"])) {
  if (empty($_GET["search"])) {
    echo "<h2>Please enter a director name</h2>";
    return;
  }

  $res = $_GET["search"];
  $film = getFilmByDirector($res);
?>


<?php
  if (count($film) == 0) {
    echo '<h1> No results for \'' . $res . '\'</h1>';
    return;
  }
  require_once('./movieCard.php');
  if ($res != "") {
  }

  require_once('./movieCard.php');
  echo '<h1>Search by director results for \'' . $res . '\'</h1>';
  echo '<div class="movie-list">';
  foreach ($film as $f) {
    $id = getId($f[0])[0][0];
    $infos = getInfosFilmFromId($id, ['title', 'poster_path', 'price', 'vote_average', 'director']);
    $movie = [
      'id' => $id,
      'title' => $infos['title'],
      'poster' => $infos['poster_path'],
      'price' => $infos['price'],
      'voteAverage' => $infos['vote_average'],
    ];
    echo '<div class="movie-director">';
    echo '<h3>' . $infos['director'] . '</h3>';
    echo createMovieCard($movie);
    echo '</div>';
  }
  echo '</div>';
}
?>

<style>
  .movie-list {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    justify-content: center;
  }

  .movie-card {
    width: 13rem;
    height: auto;
  }
</style>