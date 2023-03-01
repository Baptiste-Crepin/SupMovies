<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>SupMovies</title>
  <link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="header">
    <a href="./">
      <h1>SupMovies</h1>
    </a>
    <form action="search_bar.php" method="POST">
      <input type="text" id="search-input" placeholder="Rechercher...">
      <button type="submit">Rechercher</button>
    </form>
    <span></span>
    <div id="account">
      <?php require_once('profilePic.php'); ?>
      </ul>
    </div>
  </div>
</body>

</html>