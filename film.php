<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Baptiste Crepin, Martin Pierrache">
    <link href="./assets/styles/moviePage.css" media="all" rel="stylesheet" type="text/css">
    <title>Film</title>
</head>
<?php require_once('./header.php'); ?>

<body>
    <main>
        <div class="film-details">
            <?php
            require_once('database.php');
            if (isset($_GET['name_film'])) {
                $title = $_GET['name_film'];
                $id_film  = getIdByTitle($title)[0][0];
                $actor = getActorById($id_film)[0][0];
                $overview = getOverviewById($id_film)[0][0];
                $rating = getRatingById($id_film)[0][0];
                $poster = getPosterFromId($id_film)[0][0];
                $director = getDirectorById($id_film)[0][0];
                $price = getFilmPrice($id_film)[0][0];
                echo '<h2>' . $title . '</h2>';
                echo '<img class="poster" src="https://image.tmdb.org/t/p/original' . $poster . '" alt="film poster">';
                echo '<p><strong>Réalisator:</strong> ' . $director . '</p>';
                echo '<p><strong>Actors:</strong> ' . $actor . '</p>';
                echo '<p>' . $overview . '</p>';
                echo '<p><strong>Note:</strong> ' . $rating . '</p>';
            }
            ?>
        </div>
        <div class="film-achat">
            <h2>Buy this film</h2>
            <?php echo '<p>Prix:' . $price  . '€</p>' ?>
            <!-- <form> -->
            <form method="get" action="film.php">
                <br>
                <?php if (!isset($_SESSION['username'])) {
                    echo '<a href="login.php">Login to buy</a>';
                } else {
                    echo <<<HTML
                        <input type="hidden" id="name_film" name="name_film" value="{$_GET['name_film']}">
                        <input type="hidden" id="id" name="id" value="{$id_film}">
                        <label for="quantite">Quantity:</label>
                        <input type="number" id="quantite" name="quantite" min="1" max="10" value="1">
                        <input type="submit" name="action" value="Acheter">
                    HTML;
                } ?>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 SupMovies. All rights reserved.</p>
    </footer>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['action']) || $_GET['action'] != 'Acheter') return;
    if (!isset($_GET['quantite']) || empty($_GET['quantite']) || $_GET['quantite'] == 1) {
        addEntry($_SESSION['username'], $_GET['id']);
    } else addEntry($_SESSION['username'], $_GET['id'], $_GET['quantite']);

    echo <<<HTML
    <div class='alert'>
        <a class="redirect" href="index.php"><button>Continue browsing</button></a>
        <a class="redirect" href="cart.php"><button>Go to cart</button></a>
    </div>
    HTML;
}
?>