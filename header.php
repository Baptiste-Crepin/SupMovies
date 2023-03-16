<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>SupMovies</title>
  <link href="./assets/styles/header.css" media="all" rel="stylesheet" type="text/css">
  <link rel="icon" type="image/svg+xml" href="./assets/icons/clapperboard-solid.svg">
</head>

<body>
  <div id="header">
    <a href="./">
      <h1>SupMovies</h1>
    </a>
    <form class="search-bar" action="search_bar.php" method="GET">
      <div class="search-bar">
        <input type="text" id="search-input" name="search" placeholder="search...">
        <button class="button primary-button" type="submit" name="submit"><img class="search" src="./assets/icons/magnifying-glass-solid.svg"></button>
      </div>
      <div>
        <a class="genre" href="genre.php"><button class="button secondary-button" type="button">Genre</button></a>
        <button class="button secondary-button" type="submit" name="submit_director">Search by director</button>
      </div>
    </form>
    <?php require_once('profilePic.php');
    echo displayAccount() ?>
  </div>
</body>

</html>