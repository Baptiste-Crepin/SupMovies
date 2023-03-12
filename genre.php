<!DOCTYPE html>
<link href="./assets/styles/Genre.css" media="all" rel="stylesheet" type="text/css">
<?php

require_once("./header.php");
require_once("./database.php");

?>
<body>
<div id="test">
<div id="Category">
    <h3>GENRES</h3>
    <table id="Panel_category">
    <tr>
    <td>
    <a   href="genre.php?">Latest</a>
    </td>
    <td>
    <a  href="">Newest</a>
    </td>
    <td>
    <a  href="genre.php?popular">Popular</a>
    </td>
    </tr>
    <tr >
    <td>
    <a  href="genre.php?genre_id=12" >Adventure</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=14" >Fantasy</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=10770" >TV movie</a>
    </td>
    </tr>
    <tr>
    <td>
    <a  href="genre.php?genre_id=16" >Animation</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=18" >Drama</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=27" >Horror</a>
    </td>
    </tr>
    <tr>
    <td>
    <a   href="genre.php?genre_id=28">Action</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=35" >Comedy</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=36" >History</a>
    </td>
    </tr>
    <tr>
    <td>
    <a   href="genre.php?genre_id=37">Western</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=53" >Thriller</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=80" >Crime</a>
    </td>
    </tr>
    <tr>
    <td>
    <a  href="genre.php?genre_id=99" >Documentary</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=878" >Science fiction</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=9648" >Mystery</a>
    </td>
    </tr>
    <tr>
    <td>
    <a  href="genre.php?genre_id=10402" >Music</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=10749" >Romance</a>
    </td>
    <td>
    <a  href="genre.php?genre_id=10751" >Familly</a>
    </td>
    </tr>
    <tr>
    <td>
    <a  href="genre.php?genre_id=10752" >War</a>
    </td>
    </tr>
    </table>
</div>

<div id="films">
    <?php 
    if (isset($_GET["genre_id"])) {
        $genre_id = $_GET["genre_id"];
        $title = getFilmsByGenre($genre_id);
        foreach (array_slice($title, 0, 15) as $title) {
            $id = getId($title[0]);
            $price =  getFilmPrice($id[0][0]);
            $price = $price[0][0];
            $poster = getPosterFromId($id[0][0]);
            echo "<div class='film'><a href='film.php?name_film=$title[0]'>";
            echo '<img class="poster" src="https://image.tmdb.org/t/p/original' . $poster[0][0] . '" alt="film poster">';
            echo "<h3>$title[0]</h3></a>";
            echo "<p>$price €</p>";

            echo "</a>";
            echo "</div>";
        }
    }
    ?>
</div>
</div>

</body>