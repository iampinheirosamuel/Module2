<?php # Script 16.9 - logout.php
 // This is the logout page for the site.


 $page_title = 'Logout';
 

 // If no first_name session variable exists, redirect the user:
 
 if (!isset($_SESSION['first_name'])) {
 // Define the URL.
 ob_end_clean(); // Delete the buffer.
 header("Location: index.php");
 exit(); // Quit the script.

 } else { // Log out the user.

 $_SESSION = array(); // Destroy the variables.
  unset($_SESSION['cart']);  // empty the cart
 session_destroy(); // Destroy the session itself.
 
 setcookie (session_name(), '', time()-100); // Destroy the cookie.
 unset($_SESSION['cart']);  // empty the cart
 }
header("Location: index.php");
 // Print a customized message:
 echo '<h3>You are now logged out.</h3>';

 include ('includes/footer.php');
 ?>