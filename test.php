<?php
$actor = "[22226, 19034, 1674162, 221192, 1160, 3392, 74541, 1532, 1410478, 83854]";

// Supprimer les crochets et séparer les éléments par des virgules
$actor = str_replace(['[', ']'], '', $actor);
$actor = explode(',', $actor);

// Supprimer les espaces en début et fin de chaque élément
$actor = array_map('trim', $actor);

// Diviser le tableau en sous-tableaux de taille 1
$actor = array_chunk($actor, 1);

// Afficher le tableau résultant
echo $actor[1];

?>