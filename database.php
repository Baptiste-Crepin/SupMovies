<?php
function connect(): PDO
{
  require('credentials.php');
  try {
    return new PDO(
      $dbHost,
      $dbUser,
      $dbPass,
    );
  } catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }
}

function userExist(string $username): bool
{
  try {
    $db = connect();
    $sql = 'SELECT * FROM users WHERE username = :username';
    $usersStatement = $db->prepare($sql);
    $usersStatement->execute([
      'username' => $username,
    ]);

    $user = $usersStatement->fetchAll();

    if ($user == null) {
      throw new Exception('User not found');
      return false;
    }

    return true;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
}

function userPassword(string $username, string $password): bool
{
  if (!userExist($username)) {
    return false;
  }

  try {
    $db = connect();
    $sql = 'SELECT password FROM users WHERE username = :username';
    $usersStatement = $db->prepare($sql);

    $usersStatement->execute([
      'username' => $username,
    ]);

    $user = $usersStatement->fetchAll();
    $hash = $user[0][0];

    if (!password_verify($password, $hash)) {
      throw new Exception('Wrong password');
    }

    return true;
  } catch (\Exception $e) {
    echo $e->getMessage();
    return false;
  }
}


function insertUser(string $username, string $password): bool
{
  try {
    $db = connect();
    $sql = "INSERT INTO users(username,password) VALUES(:username, :password)";
    $usersStatement = $db->prepare($sql);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $usersStatement->execute([
      "username" => $username,
      "password" => $hash,
    ]);

    $usersStatement->fetchAll();

    return true;
  } catch (Exception $e) {
    if ($e->getCode() == 23000) {
      echo "User already exists";
    } else {
      echo $e->getMessage();
    }
    return false;
  }
}

function getTitle($name)
{
    try {
        $db = connect();
        $sql = 'SELECT original_title FROM movies WHERE original_title LIKE '%$name%'';
        $original_tittle_statement = $db->prepare($sql);
        $original_tittle_statement->execute();
        $original_title = $original_tittle_statement->fetchAll();
        return ($original_title);
    } catch (Exception $e) {
        die($e);
    }
}

function getActor($name)
{
    try {
        $db = connect();
        $sql = 'SELECT actors FROM movies WHERE original_title LIKE '%$name%'';
        $actor_statement = $db->prepare($sql);
        $actor_statement->execute();
        $actor = $actor_statement->fetchAll();
        return ($actor);
    } catch (Exception $e) {
        die($e);
    }
}

function  getDirector($name)
{
    try {
        $db = connect();
        $sql = 'SELECT director FROM movies WHERE original_title LIKE '%$name%'';
        $director_statement = $db->prepare($sql);
        $director_statement->execute();
        $director = $director_statement->fetchAll();
        return ($director);
    } catch (Exception $e) {
        die($e);
    }
}

function getReleaseDate($name)
{
    try {
        $db = connect();
        $sql = 'SELECT release_date FROM movies WHERE original_title LIKE '%$name%'';
        $release_date_statement = $db->prepare($sql);
        $release_date_statement->execute();
        $release_date = $release_date_statement->fetchAll();
        return ($release_date);
    } catch (Exception $e) {
        die($e);
    }
}
?>