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
    <form action="search_bar.php" method="GET">
      <input type="text" id="search-input" name="search" placeholder="Rechercher...">
      <button type="submit" name="submit">Rechercher</button>
    </form>
    <a href="genre.php">Genres</a>
    <span></span>
    <?php require_once('profilePic.php');
    echo displayAccount() ?>
  </div>
</body>
</html>