<?php
function createMovieCard($movie)
{
  echo '<div class="movie-card">';
  echo '<img class="poster" src="https://image.tmdb.org/t/p/original' . $movie['poster'] . '">';
  echo '<h3 class="movie-title , flex">' . $movie['title'] . '</h3>';
  echo '<div class="movie-infos">';
  echo '<div class="flex">';
  echo '<p>' . $movie['voteAverage'] . '</p>';
  echo '<img class="icons" id="vote" src="./assets/icons/star-solid.svg">';
  echo '</div>';
  echo '<div class="flex">';
  echo '<p>' . $movie['price'] . '</p>';
  echo '<img class="icons" src="./assets/icons/euro-sign-solid.svg">';
  echo '</div>';
  echo '</div>';
  echo '</div>';
}

function createMovieCardGroup($movieList, $title)
{
  echo '<section class="movie-group" id="' . $title . '">';
  echo '<h2 class="title">' . $title . '</h2>';
  echo '<div class="movie-card-group">';
  foreach ($movieList as $movie) {
    createMovieCard($movie);
  }
  echo '</div>';
  echo '</section>';
}
?>
<style>
  #Page\ 1 :nth-child(2) {
    flex-wrap: wrap;
  }

  #Page\ 1 :nth-child(2) .poster {
    width: 30vh;
  }

  .movie-group {
    background-color: #bdc3c7;
    padding: 1rem;
    margin-bottom: 1rem;
    color: #222;
    width: 80%;
  }

  .movie-card-group {
    display: flex;
    gap: 1rem;
    justify-content: center;
    background-color: #7f8c8d;
    padding: 1rem;
  }

  .movie-card {
    position: relative;
    display: flex;
    align-items: center;
    width: min-content;
    background: #95a5a6;
    flex-direction: column;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
  }

  .movie-title {
    margin: 0 1rem;
    height: 8vh;
  }

  .title {
    color: #222;
  }

  .movie-infos {
    margin: 0 1rem;
    height: 8vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: .4rem;
  }

  .flex {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
  }

  .flex p {
    margin: 0 .3rem;
  }

  .movie-card h3 {
    font-size: .9rem;
    text-align: center;
  }

  .poster {
    aspect-ratio: 2/3;
    width: 12vw;
    height: auto;
  }

  .icons {
    height: 1.5em;
    filter: invert(9%) sepia(6%) saturate(15%) hue-rotate(319deg) brightness(91%) contrast(87%);
  }

  #vote {
    filter: invert(83%) sepia(40%) saturate(7030%) hue-rotate(1deg) brightness(106%) contrast(106%)
  }
</style>