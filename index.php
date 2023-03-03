<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
<?php

require_once("./header.php");

require_once("./database.php");
require_once("./movieCard.php");

$currentPage = 1;
if (isset($_GET['page'])) $currentPage = $_GET['page'] - 1;

echo '<main>';
// createTrailerCard('release_date');
// createTrailerCard('popularity');
// createTrailerCard('vote_average');

echo createMovieCardGroup('New Movies', 'release_date');
echo createMovieCardGroup('Popular Movies', 'popularity');
echo createMovieCardGroup('Highest Rated Movies', 'vote_average');
echo createMovieCardGroup('Page ' . $currentPage + 1, 'release_date', 20, $currentPage);


echo pageSwap($currentPage);
echo '</main>';
