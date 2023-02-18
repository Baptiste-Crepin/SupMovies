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
  try {
    if (!userExist($username)) {
      return false;
    }

    // TODO: check password with crypting

    $db = connect();
    $sql = 'SELECT username FROM users WHERE username = :username AND password = :password';
    $usersStatement = $db->prepare($sql);
    $usersStatement->execute([
      'username' => $username,
      'password' => $password,
    ]);

    $user = $usersStatement->fetchAll();

    if ($user == null) {
      throw new Exception('Wrong password');
    }

    return true;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
}


function insertUser(string $username, string $password): void
{
  try {
    $db = connect();
    $sql = "INSERT INTO users(username,password) VALUES(:username, :password)";
    $usersStatement = $db->prepare($sql);
    //TODO: password crypting
    $usersStatement->execute([
      "username" => $username,
      "password" => $password,
    ]);

    $users = $usersStatement->fetchAll();
  } catch (Exception $e) {
    if ($e->getCode() == 23000) {
      echo "User already exists";
    } else {
      echo $e->getMessage();
    }
  }
}
