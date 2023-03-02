<?php

require_once("./header.php");

require_once("./database.php");
require_once("./movieCard.php");

$filmList = getFilmArray1('popularity');
createMovieCardGroup($filmList, 'Popular Movies');
$filmList = getFilmArray1('release_date');
createMovieCardGroup($filmList, 'New Movies');
$filmList = getFilmArray1('vote_average');
createMovieCardGroup($filmList, 'Highest Rated Movies');
$filmList = getFilmArray1('release_date', 20);
createMovieCardGroup($filmList, 'Page 1');



function getFilmArray1($order, $limit = 5)
{
  $filmList = [];
  $MovieList = getMoviePack($order, $limit);
  foreach ($MovieList as $film) {
    $filmId = $film[0];
    $filmList[$filmId] = [
      'id' => $filmId,
      'title' => $film['title'],
      'poster' => $film['poster_path'],
      'price' => $film['price'],
      'voteAverage' => $film['vote_average'],
    ];
  };
  return $filmList;
};
