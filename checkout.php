<?php
include('./cartInfos.php');
// Replace with your own credentials
require_once('./credentials.php');

// Generate email content
$message = <<<HTML
  <!DOCTYPE html>
  <html>
  <head>
  <meta charset='utf-8'>
  <title>Your receipt from SupMovies</title>
  </head>
  <body style='background-color: #f2f2f2; font-family: Arial, sans-serif;'>
  <h1 style='color: #0047ab;'>Your receipt from SupMovies</h1>
  <p> {$_SESSION['username']}</p>
  <p>Thank you for your purchase on SupMovies. Your receipt is below:</p>
  <table>
  <tr>
  <td style='padding: 0 2rem;'>Description</td>
  <td style='padding: 0 2rem;'>Quantity</td>
  <td style='padding: 0 2rem;'>Unit Price</td>
  <td style='padding: 0 2rem;'>Price</td>
  </tr>
HTML;

foreach ($filmList as $film) {
  $bunchPrice = $film['price'] * $film['quantity'];
  $message .= <<<HTML
  <tr>
    <td style='padding: 0 2rem;'>{$film['title']}</td>
    <td style='padding: 0 2rem;'>{$film['quantity']}</td>
    <td style='padding: 0 2rem; text-align:right;'> {$film['price']} €</td>
    <td style='padding: 0 2rem; text-align:right;'> {$bunchPrice} €</td>
  </tr>
  HTML;
}
$totalPrice = getTotalPrice($filmList);
$totalQuantity = getTotalQuantity($filmList);
$totalOrderPrice = $totalPrice + getShippingPrice($totalQuantity);
$message .= <<<HTML
  </table>
  <p> Total Price : {$totalOrderPrice} €</p>
  </body>
  </html>
HTML;


// Send email
require_once('database.php');
if (getEmail($_SESSION['username'])) {
  // Email details
  $from = "noreply@SupMovies.com";
  $to = getEmail($_SESSION['username']);
  $subject = "Your receipt from SupMovies";
  $headers = "From: " . $from . "\r";
  $headers .= "Content-Type: text/html; charset=UTF-8\r";

  if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
    echo (getEmail($_SESSION['username']));
  } else {
    echo "Email sending failed.";
  }
}


// TODO: remove all entries from the cart
deleteWholeCart($_SESSION['username']);
header('Location: ./index.php');
echo $message;
