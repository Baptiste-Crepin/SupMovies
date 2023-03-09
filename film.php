<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>Page film</title>
</head>
<body>
	<header>
		<h1>Supmovie</h1>
		<nav>
			<ul>
				<li><a href="index.php">Accueil</a></li>
				<li><a href="search_bar.php">Films</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<div class="film-details">
			<?php
			require_once('database.php');
            echo "test";
            if (isset($_GET['name_film'])) {
                $title = $_GET['name_film'];
                $id_film  = getIdByTitle($title);
                $actor = getActorById($id_film[0][0]);
                $overview = getOverviewById($id_film[0][0]);
                $rating = getRatingById($id_film[0][0]);
                $poster = getPosterFromId($id_film[0][0]);
                $director = getDirectorById($id_film[0][0]);
                $price = getFilmPrice($id_film[0][0]);
                echo '<h2>' . $title . '</h2>';
                echo '<img src="https://image.tmdb.org/t/p/original' . $poster[0][0] . '" alt="Affiche du film">';
                echo '<p><strong>Réalisateur:</strong> ' . $director[0][0] . '</p>';
                echo '<p><strong>Acteur principal:</strong> ' . $actor[0][0] . '</p>';
                echo '<p>' . $overview[0][0] . '</p>';
                echo '<p><strong>Note:</strong> ' . $rating[0][0] . '</p>';
            }
            ?>
        </div>
        <div class="film-achat">
            <h2>Acheter ce film</h2>
            <?php  echo '<p>Prix:' . $price[0][0]  . '€</p>' ?>
            <form>
                <label for="quantite">Quantité:</label>
                <input type="number" id="quantite" name="quantite" min="1" max="10" value="1">
                <br>
                <input type="submit" value="Acheter">
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Nom de la boutique de films. Tous droits réservés.</p>
    </footer>
    </body>
</html>  



<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    }
    
    img {
    max-width: 30vw;
    max-height: 35vh;
    position: absolute;
    left: 5%;
    top: 12%;

    }
    header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    }
    
    header h1 {
    margin: 0;
    }
    
    nav ul {
    margin: 0;
    padding: 0;
    list-style-type: none;
    }
    
    nav li {
    display: inline-block;
    margin-right: 20px;
    }
    
    nav a {
    color: #fff;
    text-decoration: none;
    }
    
    main {
    max-width: 800px;
    margin: 20px auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    }
    
    .film-details {
    flex-basis: 60%;
    }
    
    .film-achat {
    flex-basis: 35%;
    background-color: #eee;
    padding: 20px;
    }
    
    form {
        margin-top: 20px;
        }
        
        label {
        display: block;
        margin-bottom: 5px;
        }
        
        input[type="number"],
        input[type="text"],
        input[type="month"] {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        }
        
        input[type="submit"] {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }
        
        input[type="submit"]:hover {
        background-color: #666;
        }
        
        footer {
        background-color: #333;
        color: #fff;
        padding: 20px;
        text-align: center;
        margin-top: 20px;
        }
        
        /* Styles pour les médias mobiles */
        
        @media screen and (max-width: 768px) {
        main {
        flex-direction: column;
        }

        .film-details,

        .film-achat {
	        flex-basis: 100%;
        }

        header h1 {
            font-size: 24px;
        }

        nav li {
            display: block;
            margin-bottom: 10px;
        }

        footer p {
            font-size: 12px;
        }

}</style>
