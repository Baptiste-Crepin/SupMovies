<!DOCTYPE html>
<html>
  <head>
    <title>Résultats de recherche de films</title>
    <link rel="stylesheet" href="asssets/styles/search_bar.css">
  </head>
  <body>
    <div class="container">
      <h1>Réuslt for</h1>        <!-- Rajouter "<?php echo $title[0][0]; ?>" pour afficher le titre du film -->
      <form>
        <input type="text" placeholder="Rechercher un film...">
        <button type="submit">Rechercher</button>
      </form>
      <div class="results">
        <div class="result">
            <a href="moviePres.php">
                <img src="https://via.placeholder.com/150x225.png?text=Poster+du+film" alt="Poster du film">
            </a>
          <div class="details">
            <h2>Title :</h2>                   <!--  Get le reste via les variable quand la db fonctionne -->
            <p>Release date :</p>
            <p>Director</p>
            <p>Actor : </p>
            <p>Summary :</p>
            <button action="moviePres.php">Buy</button>                <!-- Lien pour le panier -->
          </div>
        </div>
        <div class="result">
            <a href="moviePres.php">
                <img src="https://via.placeholder.com/150x225.png?text=Poster+du+film" alt="Poster du film">
            </a>
          <div class="details">
            <h2>Title :</h2>
            <p>Release date :</p>
            <p>Director</p>
            <p>Actor : </p>
            <p>Summary :</p>
            <button>Buy</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<!-- <?php
require_once('./database.php');

$name = 'The Lord of the Rings: The Fellowship of the Ring';
$title = getTitle($name);
$actor = getActor($name);
$director = getDirector($name);
$release_date = getReleaseDate($name);

?> -->