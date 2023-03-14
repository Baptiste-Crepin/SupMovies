<!DOCTYPE html>
<link href="./assets/styles/movieCard.css" media="all" rel="stylesheet" type="text/css">
<?php

function getMovie($order)
{
  $response = getMoviePack($order, 1)[0];
  $filmId = $response['id'];
  $film = [
    'id' => $filmId,
    'title' => $response['title'],
    'poster' => $response['poster_path'],
    'backdrop' => $response['backdrop_path'],
    'price' => $response['price'],
    'voteAverage' => $response['vote_average'],
    'trailer' => $response['trailer'],
  ];
  return $film;
};

function getMovieArray($order, $limit = 5, $offset = 0)
{
  $movieList = [];
  $response = getMoviePack($order, $limit, $offset);
  if (count($response) == 0) return false;
  foreach ($response as $film) {
    $filmId = $film[0];
    $movieList[$filmId] = [
      'id' => $filmId,
      'title' => $film['title'],
      'poster' => $film['poster_path'],
      'backdrop' => $film['backdrop_path'],
      'price' => $film['price'],
      'voteAverage' => $film['vote_average'],
      'trailer' => $film['trailer'],
    ];
  };
  return $movieList;
};

function createMovieCard($movie)
{
  $output = <<<HTML
    <a class="movie-link" href="./film.php?name_film={$movie['title']}">
    <div class="movie-card">
    <img class="poster" draggable="false" loading="lazy" src="https://image.tmdb.org/t/p/original{$movie['poster']}">
    <h3 class="movie-title , flex">{$movie['title']}</h3>
      <div class="movie-infos">
        <div class="flex">
          <p> {$movie['voteAverage']} / 10</p>
          <div class="star-group">
    HTML;
  for ($i = 1; $i <= round($movie['voteAverage'] / 2); $i++) {
    $output .= <<<HTML
    <img class="orange vote" draggable="false" src="./assets/icons/star-solid.svg">
    HTML;
  }
  for ($i = 1; $i <= 5 - round($movie['voteAverage'] / 2); $i++) {
    $output .= <<<HTML
      <img class="vote" draggable="false" src="./assets/icons/star-solid.svg">
      HTML;
  }

  $output .= <<<HTML
              </div>
            </div>
            <div class="flex">
              <p> {$movie['price']} €</p>
            </div>
          </div>
        </div>
      </a>
    HTML;
  return $output;
}

function createCarrouselCard($movie)
{
  $output = <<<HTML
    <a class="carrousel-link" href="./film.php?name_film={$movie['title']}">
      <div class="carrousel-card">
      <input type="hidden" value ="{$movie['backdrop']}">
    <h3 class="movie-title , flex">{$movie['title']}</h3>
      <div class="movie-infos">
        <div class="flex">
          <p> {$movie['voteAverage']} / 10</p>
          <div class="star-group">
    HTML;
  for ($i = 1; $i <= round($movie['voteAverage'] / 2); $i++) {
    $output .= <<<HTML
    <img class="orange vote" draggable="false" src="./assets/icons/star-solid.svg">
    HTML;
  }
  for ($i = 1; $i <= 5 - round($movie['voteAverage'] / 2); $i++) {
    $output .= <<<HTML
      <img class="vote" draggable="false" src="./assets/icons/star-solid.svg">
      HTML;
  }

  $output .= <<<HTML
              </div>
            </div>
            <div class="flex">
              <p> {$movie['price']} €</p>
            </div>
          </div>
        </div>
      </a>
    HTML;
  return $output;
}

function createTrailerSubCard($movie)
{
  //TODO: regarder comment ajouter une vidéo youtube
  return <<<HTML
  <div class="movie-card">
    <h3 class="movie-title , flex">{$movie['title']}</h3>
    <div class="movie-infos">
      <div class="flex">
        <p>{$movie['voteAverage']} / 10</p>
        <img class="icons" draggable="false" id="vote" src="./assets/icons/star-solid.svg">
        <p>{$movie['price']} €</p>
      </div>
    </div>
  </div>
  HTML;
}

function createTrailerCard($order)
{
  $movie = getMovie($order, 1);
  return <<<HTML
   <section class="trailer">
   <img class="backdrop" draggable="false" src="https://image.tmdb.org/t/p/original{$movie['backdrop']}">
   createTrailerSubCard($movie);
   </section>
  HTML;
}

function createMovieCardGroup($title, $order, $limit = 10, $offset = 0, $carrousel = false)
{
  $offset = $offset * $limit;
  $movieList = getMovieArray($order, $limit, $offset);
  if (!$movieList) return false;
  $output = <<<HTML
      <section class="movie-group" id="{$title}">
      <h2 class="title"> {$title} </h2>
      HTML;
  if ($carrousel) {

    $output .= <<<HTML
      <div class="carrousel">
        <button onclick=previousCard()> B </button>
      HTML;
  }
  $output .= <<<HTML
      <div class="movie-card-group">
    HTML;
  foreach ($movieList as $movie) {
    $output .= createMovieCard($movie);
  }
  if ($carrousel) {
    $output .= <<<HTML
        </div>
        <button onclick=nextCard()> N </button>
      HTML;
  }
  $output .= <<<HTML
      </div>
    </section>
    HTML;
  return $output;
}


function createCarrousel($title, $order, $limit = 10, $offset = 0)
{
  $offset = $offset * $limit;
  $movieList = getMovieArray($order, $limit, $offset);
  if (!$movieList) return false;
  $output = <<<HTML
      <section class="movie-group" id="{$title}">
      <h2 class="title"> {$title} </h2>
      <div class="carrousel">
        <button onclick=previousCard()><img class="icons" src="./assets/icons/left-long-solid.svg"></button>
    HTML;

  $output .= <<<HTML
      <div class="movie-carrousel-group">
    HTML;
  foreach ($movieList as $movie) {
    $output .= createCarrouselCard($movie);
  }

  $output .= <<<HTML
        </div>
        <button onclick=nextCard()><img class="icons" src="./assets/icons/right-long-solid.svg"></button>
      </div>
    </section>
    HTML;
  return $output;
}


function pageSwap($currentPage = 1)
{
  $currentPage += 1;
  $lastPage = getLastPage(20);
  $output = <<<HTML
    <div class="page-swap">
      <a href="./index.php?page=1"><button>First page</button></a>
    HTML;
  if ($currentPage != 1) {
    for ($i = 2; $i > 0; $i--) {
      $page = $currentPage - $i;
      if ($page < 2) continue;
      $output .= <<<HTML
        <a href="./index.php?page=$page"><button>$page</button></a>
        HTML;
    }
  }
  $output .= <<<HTML
        <p>$currentPage</p>
        HTML;

  for ($i = 1; $i <= 2; $i++) {
    $page = $currentPage + $i;
    if ($page > $lastPage) continue;
    $output .= <<<HTML
      <a href="./index.php?page=$page"><button>$page</button></a>
      HTML;
  }
  $output .= <<<HTML
        <a href="./index.php?page=$lastPage"><button>Last page</button></a>
      </div>
    HTML;
  return $output;
}
