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
                $id_film  = getId($title)[0][0];
                $options = ['overview', 'vote_average', 'poster_path', 'backdrop_path', 'director', 'actors', 'price'];
                $filmInfos = getInfosFilmFromId($id_film, $options);
                $actor = $filmInfos['actors'];
                $actor = str_replace(['[', ']'], '', $actor);
                $actor = explode(',', $actor);
                $actor = array_map('trim', $actor);
                $actor = array_chunk($actor, 1);
                $overview = $filmInfos['overview'];
                $rating = $filmInfos['vote_average'];
                $poster = $filmInfos['poster_path'];
                $backdrop = $filmInfos['backdrop_path'];
                $director = $filmInfos['director'];
                $price = $filmInfos['price'];
                echo '<h2>' . $title . '</h2>';
                echo '<img class="poster" src="https://image.tmdb.org/t/p/w342' . $poster . '" alt="Film poster">';
                echo '<p><strong>Réalisator:</strong> ' . $director . '</p>';
                echo '<p><strong>Actors:</strong> </p><br>';
                echo '<div class="actor-group">';
                include('./credentials.php');
                for ($i = 0; $i < 6; $i++) {
                    $tempActor = $actor[$i][0];
                    $actorURL = "https://api.themoviedb.org/3/person/$tempActor?api_key=" . $theMovieDbAPI . "&language=en-US";
                    $response = file_get_contents($actorURL);
                    $actorInfo = json_decode($response, true);
                    $actorPoster = "https://image.tmdb.org/t/p/original" . $actorInfo['profile_path'];
                    $actorName = $actorInfo['name'];
                    echo '<div class="actor-infos">';
                    echo '<img class="actor" src="' . $actorPoster . '" alt="actor picture">';
                    echo '<p class="actor-name" >' . $actorName . '</p>';
                    echo '</div>';
                }
                echo '</div>';

                echo '<p>' . $overview . '</p>';
                echo '<p><strong>Rating:</strong> ' . $rating . ' /10 </p>';
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
    <script>
        const backdrop = 'https://image.tmdb.org/t/p/original<?php echo $backdrop ?>';
        document.documentElement.style.setProperty('--bg-image', 'url(' +
            backdrop + ')');
    </script>
    <?php require_once('./footer.php'); ?>
</body>

</html><?php
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
        ?><style>
    .backdrop {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        position: absolute;
        z-index: -1;
    }
</style>