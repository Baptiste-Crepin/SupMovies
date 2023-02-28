<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>La Communauté de l'Anneau - Vente de films</title>  <!-- Rajouter "<?php echo $title[0][0]; ?>" pour afficher le titre du film -->
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        color: #333;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }

      h1 {
        font-size: 24px;
        margin-bottom: 20px;
      }

      .product {
        display: flex;
        flex-wrap: wrap;
      }

      .product-image {
        flex-basis: 40%;
        margin-right: 20px;
      }

      .product-image img {
        display: block;
        width: 100%;
        height: auto;
        margin-bottom: 10px;
      }

      .product-details {
        flex-basis: 60%;
      }

      .product-title {
        font-size: 28px;
        margin-bottom: 10px;
      }

      .product-description {
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 20px;
      }

      .product-price {
        font-size: 24px;
        margin-bottom: 20px;
      }

      button.add-to-cart {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>La Communauté de l'Anneau</h1>
      <div class="product">
        <div class="product-image">
          <img src="https://www.example.com/lotr-1.jpg" alt="Affiche de La Communauté de l'Anneau">
        </div>
        <div class="product-details">
          <h2 class="product-title">La Communauté de l'Anneau</h2>
          <p class="product-description">Frodon le hobbit hérite d'un anneau. Il doit alors faire équipe avec huit compagnons pour détruire l'anneau en le jetant dans les flammes de la montagne du Destin.</p>
          <p class="product-price">19,99 €</p>
          <button class="add-to-cart">Ajouter au panier</button>
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