<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">


<?php

require_once("./header.php");

require_once("./database.php");
require_once("./movieCard.php");

$currentPage = 0;
if (isset($_GET['page'])) $currentPage = $_GET['page'] - 1;

echo '<main>';

if ($currentPage == 0) {
  echo <<<HTML
    <div class="selector">
      <label for="option1">New</label>
      <input type="radio" class='film-selector' id="option1" name="options" onclick="showDiv('0')" checked>
      <label for="option2">Highest Rated</label>
      <input type="radio" class='film-selector' id="option2" name="options" onclick="showDiv('1')">
      <label for="option3">Popular</label>
      <input type="radio" class='film-selector' id="option3" name="options" onclick="showDiv('2')">
      <label for="option4">Vote</label>
      <input type="radio" class='film-selector' id="option4" name="options" onclick="showDiv('3')">
    </div>
    HTML;
  $limit = 5;
  echo $newMovies = createCarrousel('New Movies', 'release_date', $limit, 0, $carrousel = true);
  echo $highestRated = createCarrousel('Highest Rated Movies', 'vote_average', $limit, 0, $carrousel = true);
  echo $popularMovies = createCarrousel('Popular Movies', 'popularity', $limit, 0, $carrousel = true);
  echo $voteCount = createCarrousel('Highest vote count', 'vote_count', $limit, 0, $carrousel = true);
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
    cardGroup = document.getElementsByClassName('movie-carrousel-group')[index].childNodes
    backdropImg = cardGroup[0].childNodes[1].childNodes[1].defaultValue
    let backdrop = 'https://image.tmdb.org/t/p/original' + backdropImg;
    document.documentElement.style.setProperty('--bg-image', 'url(' + backdrop + ')');
  }

  showDiv(0)

  function caroussel() {
    nbCarrousel = document.getElementsByClassName('movie-carrousel-group')
    for (let carrousel = 0; carrousel < nbCarrousel.length; carrousel++) {
      let cardGroup = document.getElementsByClassName('movie-carrousel-group')[carrousel].childNodes;

      for (let i = 0; i < cardGroup.length - 1; i++) cardGroup[i].style.display = 'none'

      cardGroup[0].style.display = 'flex'
    }
    cardGroup = document.getElementsByClassName('movie-carrousel-group')[0].childNodes
    backdropImg = cardGroup[0].childNodes[1].childNodes[1].defaultValue
    let backdrop = 'https://image.tmdb.org/t/p/original' + backdropImg;
    document.documentElement.style.setProperty('--bg-image', 'url(' + backdrop + ')');
    console.log(backdrop)
  }

  function CurrentCarrousel() {
    currentCarrousel = document.getElementsByClassName('selector')[0].childNodes
    inputID = 0
    for (let i = 0; i < currentCarrousel.length; i++) {
      if (currentCarrousel[i].tagName == 'INPUT') {
        inputID++
        if (currentCarrousel[i].checked) {
          return inputID
        }
      }
    }
  }

  function nextCard() {
    currentCarrousel = CurrentCarrousel()
    let cardGroup = document.getElementsByClassName('movie-carrousel-group')[currentCarrousel - 1].childNodes

    for (let i = 0; i < cardGroup.length - 2; i++) {
      if (cardGroup[i].style.display == 'flex') {
        cardGroup[i].style.display = 'none'
        cardGroup[i + 1].style.display = 'flex'
        backdropImg = cardGroup[i + 1].childNodes[1].childNodes[1].defaultValue
        let backdrop = 'https://image.tmdb.org/t/p/original' + backdropImg;
        document.documentElement.style.setProperty('--bg-image', 'url(' + backdrop + ')');
        return
      }
    }
  }

  function previousCard() {
    currentCarrousel = CurrentCarrousel()
    let cardGroup = document.getElementsByClassName('movie-carrousel-group')[currentCarrousel - 1].childNodes;
    console.log(cardGroup);
    for (let i = 0; i < cardGroup.length - 1; i++) {
      if (cardGroup[i].style.display == 'flex') {
        if (i == 0) return;
        cardGroup[i].style.display = 'none'
        cardGroup[i - 1].style.display = 'flex'
        backdropImg = cardGroup[i - 1].childNodes[1].childNodes[1].defaultValue
        let backdrop = 'https://image.tmdb.org/t/p/original' + backdropImg;
        document.documentElement.style.setProperty('--bg-image', 'url(' + backdrop + ')');
        return
      }
    }
  }


  setInterval(nextCard, 15000);
  caroussel()
</script>