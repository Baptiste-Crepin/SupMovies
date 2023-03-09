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

<body>
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
</body>

</html>

<?php
require_once('database.php');
echo "test";

if (isset($_GET["submit"])) {
  echo "test2";
  $res = $_GET["search"];
  $film = getTitle($res);
  $id = getId($res);
  
  ?>

  <br><br><br>
  <table>
    <tr>
      <th>Name</th>
      <th>Description</th>
    </tr>

    <?php
      foreach ($film as $f) {
        echo "<tr>";
        echo "<td><a href=\"film.php?name_film=" . $f[0] . "\">" . $f[0] . "</a></td>";
        echo "</tr>";
      }
    ?>

  </table>
<?php
}
?>
