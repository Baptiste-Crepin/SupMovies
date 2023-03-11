<?php
require_once('./cartInfos.php');
require_once('./credentials.php');

// Generate email content
$message = "<!DOCTYPE html>\n";
$message .= "<html>\n";
$message .= "<head>\n";
$message .= "<meta charset='utf-8'>\n";
$message .= "<title>Your receipt from SupMovies</title>\n";
$message .= "</head>\n";
$message .= "<body style='background-color: #f2f2f2; font-family: Arial, sans-serif;'>\n";
$message .= "<h1 style='color: #0047ab;'>Your receipt from SupMovies</h1>\n";
$message .= "<p>" . $_SESSION['username'] . "</p>\n";
$message .= "<p>Thank you for your purchase on SupMovies. Your receipt is below:</p>\n";
$message .= "<table>\n";
$message .= "<tr>\n";
$message .= "<td style='padding: 0 2rem;'>Description</td>\n";
$message .= "<td style='padding: 0 2rem;'>Quantity</td>\n";
$message .= "<td style='padding: 0 2rem;'>Unit Price</td>\n";
$message .= "<td style='padding: 0 2rem;'>Price</td>\n";
$message .= "</tr>\n";

foreach ($filmList as $film) {
  $bunchPrice = $film['price'] * $film['quantity'];
  $message .= "<tr>\n";
  $message .= "<td style='padding: 0 2rem;'>" . $film['title'] . "</td>\n";
  $message .= "<td style='padding: 0 2rem;'>" . $film['quantity'] . "</td>\n";
  $message .= "<td style='padding: 0 2rem; text-align:right;'>" . $film['price'] . " €</td>\n";
  $message .= "<td style='padding: 0 2rem; text-align:right;'>" . $bunchPrice . " €</td>\n";
  $message .= "</tr>\n";
}
$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);
$totalOrderPrice = $totalPrice + getShippingPrice($totalQuantity);
$message .= "</table>\n";
$message .= "<p> Total Price : " . $totalOrderPrice . " €</p>\n";
$message .= "</body>\n";
$message .= "</html>";


// Send email
require_once('database.php');
if (getEmail($_SESSION['username'])) {
  // Email details
  $from = "noreply@SupMovies.com";
  $to = getEmail($_SESSION['username']);
  $subject = "Your receipt from SupMovies";
  $headers = "From: " . $from . "\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

  if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
    echo (getEmail($_SESSION['username']));
  } else {
    echo "Email sending failed.";
  }
}

$MovieIdsArray = [];
foreach ($filmList as $film) {
  array_push($MovieIdsArray, $film['id']);
}
$MovieIdsArray = implode(',', $MovieIdsArray);

var_dump($MovieIdsArray);
addCartToHistory($_SESSION['username'], $MovieIdsArray);
// deleteWholeCart($_SESSION['username']);
// header('Location: ./index.php');
echo $message;
