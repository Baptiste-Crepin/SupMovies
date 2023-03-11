<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>SupMovies</title>
  <!-- <link href="./assets/styles/header.css" media="all" rel="stylesheet" type="text/css"> -->
</head>
<!-- <body>
  <div id="header">
    <a href="./">
      <h1>SupMovies</h1>
    </a>
    <form method="post">
      <input type="text" name="search">
      <input type="submit" name="submit">
    </form>
    <span></span>
  </div>
</body> -->

</html>

<?php
require_once('./header.php');
require_once('database.php');

if (isset($_GET["submit"])) {
  $res = $_GET["search"];
  $film = getTitle($res);
  $id = getId($res);

?>


  <?php
  require_once('./movieCard.php');
  echo '<h1>Resultats de la recherche pour \'' . $res . '\'</h1>';
  echo '<div class="movie-list">';
  foreach ($film as $f) {
    $a = getIdByTitle($f[0])[0][0];
    $infos = getInfosFilmFromId($a, ['title', 'poster_path', 'price', 'vote_average']);
    $movie = [
      'id' => $a,
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
?>

<style>
  .movie-list {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
  }

  .movie-card {
    width: 13rem;
    height: auto;
  }
</style>