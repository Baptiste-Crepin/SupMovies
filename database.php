<?php
function connect(): PDO
{
  require('credentials.php');
  try {
    // throw new Exception('Hostinger database error');
    return new PDO(
      $dbHost,
      $dbUser,
      $dbPass,
    );
  } catch (Exception $e) {
    // try to connect to local database if hostinger is down for the tests;
    // return connectLocalDb($e);
    echo $e->getMessage();
  }
}
function connectLocalDb($onlineExecption = null): PDO
{
  require('credentials.php');
  try {
    return new PDO(
      "mysql:host=$localHost;dbname=$localName",
      $localUser,
      $localPass
    );
  } catch (Exception $e) {
    if ($onlineExecption == null) {
      die('Local database error : ' . $e->getMessage());
    }
    die('Hostinger database error : ' . $onlineExecption->getMessage() .
      '<br>' .
      'Local database error : ' . $e->getMessage());
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
    }

    return true;
  } catch (Exception $e) {
    die("<h3 class='error'>" . $e->getMessage() . "</h3>");
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
    die("<h3 class='error'>" . $e->getMessage() . "</h3>");
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
      echo "<p class='error'>User already exists</p>";
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
    $sql = 'SELECT original_title FROM movies WHERE original_title LIKE "%' . $name . '%"';
    $original_tittle_statement = $db->prepare($sql);
    $original_tittle_statement->execute();
    $original_title = $original_tittle_statement->fetchAll();
    return ($original_title);
  } catch (Exception $e) {
    die($e);
  }
}

function getTitleById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT original_title FROM movies WHERE id = :id';
    $original_tittle_statement = $db->prepare($sql);
    $original_tittle_statement->execute([
      'id' => $id,
    ]);
    $original_title = $original_tittle_statement->fetchAll();
    return ($original_title);
  } catch (Exception $e) {
    die($e);
  }
}

function getActorById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT actors FROM movies WHERE id = :id';
    $actor_statement = $db->prepare($sql);
    $actor_statement->execute([
      'id' => $id,
    ]);
    $actor = $actor_statement->fetchAll();
    return ($actor);
  } catch (Exception $e) {
    die($e);
  }
}

function getDirectorById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT director FROM movies WHERE id = :id';
    $director_statement = $db->prepare($sql);
    $director_statement->execute([
      'id' => $id,
    ]);
    $director = $director_statement->fetchAll();
    return ($director);
  } catch (Exception $e) {
    die($e);
  }
}

function getRealeseDateById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT release_date FROM movies WHERE id = :id';
    $year_statement = $db->prepare($sql);
    $year_statement->execute([
      'id' => $id,
    ]);
    $year = $year_statement->fetchAll();
    return ($year);
  } catch (Exception $e) {
    die($e);
  }
}


function getOverviewById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT overview FROM movies WHERE id = :id';
    $plot_statement = $db->prepare($sql);
    $plot_statement->execute([
      'id' => $id,
    ]);
    $plot = $plot_statement->fetchAll();
    return ($plot);
  } catch (Exception $e) {
    die($e);
  }
}

function getRatingById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT vote_average FROM movies WHERE id = :id';
    $rating_statement = $db->prepare($sql);
    $rating_statement->execute([
      'id' => $id,
    ]);
    $rating = $rating_statement->fetchAll();
    return ($rating);
  } catch (Exception $e) {
    die($e);
  }
}

function getIdByTitle($title)
{
  try {
    $db = connect();
    $sql = 'SELECT id FROM movies WHERE original_title LIKE "%' . $title . '%"';
    $id_statement = $db->prepare($sql);
    $id_statement->execute();
    $id = $id_statement->fetchAll();
    return ($id);
  } catch (Exception $e) {
    die($e);
  }
}


function getId($name)
{
  try {
    $db = connect();
    $sql = 'SELECT id FROM movies WHERE original_title LIKE "%' . $name . '%"';
    $id_statement = $db->prepare($sql);
    $id_statement->execute();
    $id = $id_statement->fetchAll();
    return ($id);
  } catch (Exception $e) {
    die($e);
  }
}

function getActor($name)
{
  try {
    $db = connect();
    $sql = 'SELECT actors FROM movies WHERE original_title LIKE ' % $name % '';
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
    $sql = 'SELECT director FROM movies WHERE original_title LIKE ' % $name % '';
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
    $sql = 'SELECT release_date FROM movies WHERE original_title LIKE ' % $name % '';
    $release_date_statement = $db->prepare($sql);
    $release_date_statement->execute();
    $release_date = $release_date_statement->fetchAll();
    return ($release_date);
  } catch (Exception $e) {
    die($e);
  }
}

function getFilmPrice($id)
{
  try {
    $db = connect();
    $sql = 'SELECT price FROM movies WHERE id = :id';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'id' => $id,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getMoviePack($order, $limit = 20, $offset = 0)
{
  try {
    $db = connect();
    $sql = 'SELECT * FROM movies ORDER BY ' . $order . ' DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getTitleFromId($id)
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies WHERE id = :id';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'id' => $id,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getPosterFromId($id)
{
  try {
    $db = connect();
    $sql = 'SELECT poster_path FROM movies WHERE id = :id';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'id' => $id,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getQuantityFromId($owner, $value)
{
  try {
    $db = connect();
    $sql = 'SELECT quantity FROM cart_values WHERE owner = :owner and value = :value';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'value' => $value,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getUserCart($username)
{
  try {
    $db = connect();
    $sql = 'SELECT value FROM cart_values WHERE owner = :owner';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $username,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function removeEntry($owner, $value)
{
  try {
    $db = connect();
    $sql = 'DELETE FROM cart_values WHERE owner = :owner and value = :value';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'value' => $value,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function addEntry($owner, $value)
{
  try {
    $db = connect();
    $sql = 'INSERT INTO cart_values(owner, value) VALUES(:owner, :value)';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'value' => $value,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function setQuantity($owner, $value, $quantity)
{
  try {
    $db = connect();
    $sql = 'UPDATE cart_values SET quantity = :quantity WHERE owner = :owner AND value = :value';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'value' => $value,
      'quantity' => $quantity,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function getLastPage($rowPerPage)
{
  try {
    $db = connect();
    $sql = 'SELECT CEIL(COUNT(*) / ?) AS last_page FROM movies';

    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([$rowPerPage]);
    $cart = $cart_statement->fetchAll();
    return ($cart[0][0]);
  } catch (Exception $e) {
    die($e);
  }
}
