<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">


<?php

require_once("./header.php");

require_once("./database.php");
require_once("./movieCard.php");

$currentPage = 0;
if (isset($_GET['page'])) $currentPage = $_GET['page'] - 1;

echo '<main>';

// createTrailerCard('release_date');
// createTrailerCard('popularity');
// createTrailerCard('vote_average');

if ($currentPage == 0) {
  echo <<<HTML
    <div selector>
      <label for="option1">New</label>
      <input type="radio" id="option1" name="options" onclick="showDiv('0')" checked>
      <label for="option2">Highest Rated</label>
      <input type="radio" id="option2" name="options" onclick="showDiv('1')">
      <label for="option3">Popular</label>
      <input type="radio" id="option3" name="options" onclick="showDiv('2')">
      <label for="option3">Vote</label>
      <input type="radio" id="option3" name="options" onclick="showDiv('3')">
    </div>
    HTML;
  echo $newMovies = createMovieCardGroup('New Movies', 'release_date', 10);
  echo $highestRated = createMovieCardGroup('Highest Rated Movies', 'vote_average', 10);
  echo $popularMovies = createMovieCardGroup('Popular Movies', 'popularity', 10);
  echo $voteCount = createMovieCardGroup('Highest vote count', 'vote_count', 10);
}




echo createMovieCardGroup('Page ' . $currentPage + 1, 'release_date', 20, $currentPage);


echo pageSwap($currentPage);
echo '</main>';

?>

<script>
  function showDiv(index) {
    const movieGroups = document.getElementsByClassName('movie-group');
    for (let i = 0; i < movieGroups.length - 1; i++) {
      movieGroups[i].style.display = 'none';
    }
    movieGroups[index].style.display = 'block';
  }

  showDiv(0)
</script>