<?php
function connect(): PDO
{
  require('credentials.php');
  // this code is just here so that the tests can run on the local machine
  $localIP = '127.0.0.1'; // baptiste's local IP
  if ($_SERVER['SERVER_ADDR'] === $localIP) {
    $connection = connectLocalDb();
    if ($connection) return $connection;
  }
  try {
    return connectOnline();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

function connectOnline(): PDO
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
    echo $e->getMessage();
  }
}

function connectLocalDb(): PDO | null
{
  require('credentials.php');
  try {
    return new PDO(
      "mysql:host=$localHost;dbname=$localName",
      $localUser,
      $localPass
    );
  } catch (Exception $e) {
    return null;
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

function updateEmail(string $username, string $email): bool
{
  try {
    $db = connect();
    $sql = "UPDATE users SET email = :email WHERE username = :username";
    $usersStatement = $db->prepare($sql);

    $usersStatement->execute([
      "username" => $username,
      "email" => $email,
    ]);

    $usersStatement->fetchAll();

    return true;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
}

function getEmail(string $username)
{
  try {
    $db = connect();
    $sql = 'SELECT email FROM users WHERE username = :username';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'username' => $username,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart[0]['email']);
  } catch (Exception $e) {
    die($e);
  }
}
function getTitle($name)
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies WHERE title LIKE :name LIMIT 25';
    $title_statement = $db->prepare($sql);
    $title_statement->execute([
      'name' => '%' . $name . '%',
    ]);
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function getTitleById($id)
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies WHERE id = :id';
    $title_statement = $db->prepare($sql);
    $title_statement->execute([
      'id' => $id,
    ]);
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function  getIdByTitle($title)
{
  try {
    $db = connect();
    $sql = 'SELECT id FROM movies WHERE title = :title';
    $title_statement = $db->prepare($sql);
    $title_statement->execute([
      'title' => $title,
    ]);
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function getBestAverage()
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies ORDER BY vote_average DESC LIMIT 15';
    $title_statement = $db->prepare($sql);
    $title_statement->execute();
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function getNewest()
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies ORDER BY release_date DESC LIMIT 15';
    $title_statement = $db->prepare($sql);
    $title_statement->execute();
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function getLastest()
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies ORDER BY release_date ASC LIMIT 15';
    $title_statement = $db->prepare($sql);
    $title_statement->execute();
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}

function getFilmByDirector($name)
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies WHERE director LIKE :name LIMIT 15';
    $title_statement = $db->prepare($sql);
    $title_statement->execute([
      'name' => '%' . $name . '%',
    ]);
    $title = $title_statement->fetchAll();
    return ($title);
  } catch (Exception $e) {
    die($e);
  }
}


function getId($title)
{
  try {
    $db = connect();
    $sql = 'SELECT id FROM movies WHERE title = :title';
    $id_statement = $db->prepare($sql);
    $id_statement->execute([
      'title' => $title,
    ]);
    $id = $id_statement->fetchAll();
    if (count($id) == 0) {
      throw new Exception("No movie found");
    };
    return ($id);
  } catch (Exception $e) {
    if ($e->getMessage() == "No movie found") {
      echo '<h2>Sorry, this film is not available</h2>';
      return;
    } else {
      echo $e->getMessage();
      die($e);
    }
  }
}

function getFilmsByGenre($genre)
{
  try {
    $db = connect();
    $sql = 'SELECT title FROM movies WHERE genre_ids LIKE :genre LIMIT 15';
    $genre_statement = $db->prepare($sql);
    $genre_statement->execute([
      'genre' => '%' . $genre . '%',
    ]);
    $genre = $genre_statement->fetchAll();
    return ($genre);
  } catch (Exception $e) {
    die($e);
  }
}


function getPosterFromId($id)
{
  try {
    $db = connect();
    $sql = 'SELECT poster_path FROM movies WHERE id = :id';
    $poster_statement = $db->prepare($sql);
    $poster_statement->execute([
      'id' => $id,
    ]);
    $poster = $poster_statement->fetchAll();
    return ($poster);
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

function getInfosFilmFromId($id, $infos)
{
  try {

    $db = connect();
    $sql = 'SELECT ' . implode(',', $infos) . ' FROM movies WHERE id = :id';
    $cart_statement = $db->prepare($sql);
    $cart_statement->bindValue(':offset', $infos, PDO::PARAM_INT);
    $cart_statement->execute([
      'id' => $id,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart[0]);
  } catch (Exception $e) {
    die($e);
  }
}

function getQuantityFromId($owner, $id)
{
  try {
    $db = connect();
    $sql = 'SELECT quantity FROM cart_values WHERE owner = :owner and value = :id';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'id' => $id,
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

function addEntry($owner, $value, $quantity = 1)
{
  try {
    $db = connect();
    $sql = 'INSERT INTO cart_values(owner, value, quantity) VALUES(:owner, :value, :quantity)';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
      'value' => $value,
      'quantity' => $quantity,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    if ($e->getCode() == 23000) {
      setQuantity($owner, $value, $quantity);
    }
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

function deleteWholeCart($owner)
{
  try {
    $db = connect();
    $sql = 'DELETE FROM cart_values WHERE owner = :owner';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}

function addCartToHistory($owner, $value)
{
  try {
    $db = connect();
    $sql = 'INSERT INTO cart_history (owner, value) VALUES(:owner, :value)';
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

function getCartHistory($owner)
{
  try {
    $db = connect();
    $sql = 'SELECT value, timestamp FROM cart_history where owner = :owner ORDER BY timestamp DESC LIMIT 5;';
    $cart_statement = $db->prepare($sql);
    $cart_statement->execute([
      'owner' => $owner,
    ]);
    $cart = $cart_statement->fetchAll();
    return ($cart);
  } catch (Exception $e) {
    die($e);
  }
}
