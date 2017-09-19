<?php 
 // This page displays the contents of the shopping cart.

 // Retrieve all of the information for the prints in the cart:
 require_once ('includes/connection.php');
 // Set the page title and include the HTML header:
 $page_title = 'View Your Shopping Cart';
 session_start();
 include ('includes/header.php');


 // Check if the form has been submitted (to update the cart):
 if (isset($_POST['submitted'])) {

 // Change any quantities:
 foreach ($_POST['quantity'] as $k => $v) {

 // Must be integers!
 $pid = (int) $k;
 $quantity = (int) $v;

 if ( $quantity == 0 ) { // Delete.
 unset ($_SESSION['cart'][$pid]);
 } 
 elseif ( $quantity > 0 ) { // Change quantity.
  $_SESSION['cart'][$pid]['quantity'] = $quantity;
 }

 } // End of FOREACH.
 } // End of SUBMITTED IF.

 // Display the cart if it's not empty...
 if (!empty($_SESSION['cart'])) {

 // Retrieve all of the information for the prints in the cart:
 require_once ('includes/connection.php');
 
 try{
 	$sql = 'SELECT productID, productName, productPrice, productImage
 	        FROM products
            WHERE products.productID  
            IN (';
            foreach ($_SESSION['cart'] as $pid => $value) 
            {
             $sql.= $pid . ',';
             }
           $sql = substr($sql, 0, -1) . ") ";

   $s=$pdo->query($sql);
   $s->execute();
 }catch(PDOException $e){
    echo 'Error querying db'.$e->getMessage();
 }


 // Create a form and a table:
 echo '
 <div class="container">
 <div id="product_spec">
 <h2>'.$_SESSION['firstname'].'\'s Cart</h2>
 <form action="view_cart.php" method="post">
 <div class="table-responsive">
 <table width="100%" class="table table-bordered" >
 <tr>

 <td align="center" width="30%"><b>Product Image</b></td>

 <td align="center" width="20%"><b>Product Name</b></td>

<td align="center" width="20%"><b>Price</b></td>

<td align="center" width="20%"><b>Quantity</b></td>

 <td align="right" width="20%"><b>Total Price</b></td>

<td width="20%" colspan="2" align="center" ><b> Update Cart</b></td>
 </tr>
 ';

 // Print each item...
 $total = 0; // Total cost of the order.
 while ($result = $s->fetch()) {

 // Calculate the total and subtotals.
 $subtotal = $_SESSION['cart'][$result['productID']]['quantity'] * $_SESSION['cart'][$result['productID']]['price'];
 $total += $subtotal;

 // Print the row.
 echo "\t<tr>

<td align=\"center\" width=\"30%\">

<div><img class=\"img-responsive\" src=\"show_image.php?image={$result['productID']}&name=" . urlencode($result['productImage']) . "\" width=\"200px\" height=\"100px\"
 alt=\"{$result['productName']}\" /></div>

</td>
 
 <td align=\"center\">{$result['productName']}</td>

  <td align=\"center\">&#8358;".number_format($_SESSION['cart'][$result['productID']]['price'], 2)."</td>

  <td align=\"center\"><input type=\"text\" size=\"3\" name=\"quantity[{$result['productID']}]\" value=\"{$_SESSION['cart'][$result['productID']]['quantity']}\" /></td>

<td align=\"right\">&#8358;" . number_format ($subtotal, 2) ."</td>

<td align=\"center\"><button class=\"btn btn-primary\" type=\"submit\" name=\"submit\" value=\"Change\"><span class=\"glyphicon glyphicon-refresh\"></span></button>
<input type=\"hidden\" name=\"submitted\">
</td></form>
<form method=\"post\" action=\"view_cart.php\">
<input type=\"hidden\" name=\"quantity[{$result['productID']}]\" value=\"0\">
<td><button class=\"btn btn-danger\" type=\"submit\" name=\"delete\"><span class=\"glyphicon glyphicon-trash\"></span></button>
<input type=\"hidden\" name=\"submitted\">
</form></td>

</tr>\n";

 } // End of the WHILE loop.

 
 // Print the footer, close the table, and the form.
 echo '
 </table>
 </div>
 <hr>
 <p align="right" height="40px"><b class="btn btn-primary">Total: &#8358;'. number_format($total, 2) . '</b></p>
 <p align="right" height="40px"><a href="checkout.php" id="button" class="btn btn-primary">Check Out  <span class="glyphicon glyphicon-share-alt"></span></a></p>';

 } else {
 echo '<div class="container">
       <div id="product_spec">
       <div class="alert alert-warning" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><p>Your cart is currently
           empty.</p></div>
  
</div>
</div>
';
 }


echo "
</div>
</div>";
 include ('includes/footer.html');
 ?>