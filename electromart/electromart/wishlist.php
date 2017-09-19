<?php
// set the header
// product catalog goes here
require_once('includes/connection.php');
session_start();
$page_title="Electromart || User";
include('includes/header.php');

// set carousel here
include('includes/carousel.html');



?>

<div class="container">
<div id="content" class="row">
<div class=" col-md-3 sidebar " >
	<div id="sidebar">
		<h3>Categories</h3>
		<section>
		<?php 
            // query categories from database
		try{ 
	$sql = 'SELECT categoryID, categoryName 
      FROM categories, products
      WHERE products.productcategoryID = categories.categoryID
      ORDER BY categories.categoryName ASC';
      $s=$pdo->prepare($sql);
      $s->execute();
      $row=$s->fetch();
}catch(PDOException $e){
      echo 'Error querying db'.$e->getMessage();
}
echo "<ul>";
while ($row=$s->fetch()) {
			echo "	<li><a href=\"product_category.php?categoryID=".urlencode($row['categoryID'])."&categoryName=".urlencode($row['categoryName'])."\">{$row['categoryName']}</a></li>
			";
}
 echo "</ul>";
		?>
			
		</section>
	</div>
    <br>
	<div id="sidebar" class="nav">
	    <h5 class="text-center"><span class="glyphicon glyphicon-user"></span> My Account</h5><hr>	
		<h6><a href="shopping-cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart <span class="badge">0</span></a></h6>
		<h6><a href="wishlist.php"><span class="glyphicon glyphicon-bell"></span> Wishlist <span class="badge">0</span></a></h6>
		<h6><a href="change_password.php"><span class="glyphicon glyphicon-refresh"></span> Change password</a></h6>
		<h6><a href="#"><span class="glyphicon glyphicon-list"></span> Order History</a></h6>
		<h6><a href="#"><span class="glyphicon glyphicon-newsletter"></span> Subcribe to Newsletter</a></h6>	
	</div>
</div>
<div id="product_tray" class=" col-md-9  main">
<div  class="row">


<?php


// Here comes the wishlist

// Check if the form has been submitted (to update the cart):
 if (isset($_POST['submitted'])) {

 // Change any quantities:
 foreach ($_POST['quantity'] as $k => $v) {

 // Must be integers!
 $pid = (int) $k;
 $quantity = (int) $v;

 if ( $quantity == 0 ) { // Delete.
 unset ($_SESSION['wishlist'][$pid]);
 } 
 
 } // End of FOREACH.
 } // End of SUBMITTED IF.

 // Display the cart if it's not empty...
 if (!empty($_SESSION['wishlist'])) {

 // Retrieve all of the information for the prints in the cart:
 require_once ('includes/connection.php');
 
 try{
 	$sql = 'SELECT productID, productName, productPrice, productImage
 	        FROM products
            WHERE products.productID  
            IN (';
            foreach ($_SESSION['wishlist'] as $pid => $value) 
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

 <h2>'.$_SESSION['firstname'].'\'s Wishlist</h2>
 <form action="#" method="post">
 <div class="table-responsive">
 <table width="100%" class="table table-bordered" >
 <tr>

 <td align="center" width="30%"><b>Product Image</b></td>

 <td align="center" width="20%"><b>Product Name</b></td>

<td align="center" width="20%"><b>Price</b></td>


<td width="20%"  align="center" ><b> Update Cart</b></td>
 </tr>
 ';

 // Print each item...
 $total = 0; // Total cost of the order.
 while ($result = $s->fetch()) {

 // Calculate the total and subtotals.
 // Print the row.
 echo "\t<tr>

<td align=\"center\" width=\"30%\">

<div><img class=\"img-responsive\" src=\"show_image.php?image={$result['productID']}&name=" . urlencode($result['productImage']) . "\" width=\"200px\" height=\"100px\"
 alt=\"{$result['productName']}\" /></div>

</td>
 
 <td align=\"center\">{$result['productName']}</td>

  <td align=\"center\">&#8358;".number_format($_SESSION['wishlist'][$result['productID']]['price'], 2)."</td>

<form method=\"post\" action=\"wishlist.php\">
<input type=\"hidden\" name=\"quantity[{$result['productID']}]\" value=\"0\">
<td align=\"center\"><button class=\"btn btn-danger\" type=\"submit\" name=\"delete\"><span class=\"glyphicon glyphicon-trash\"></span></button>
<input type=\"hidden\" name=\"submitted\">
</form></td>

</tr>\n";

 } // End of the WHILE loop.

 
 // Print the footer, close the table, and the form.
 echo '
 </table>
 </div>
 <hr>
 ';

 } else {
 echo '<div class="container">
       <div id="product_spec">
       <div class="alert alert-warning" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><p>Your wishlist is currently
           empty.</p></div>
  
</div>
</div>
';
 }


?>
<!--Validates the form-->
 


</div>
</div>
</div>	
</div>


<!-- End of featured products-->

<!--Features starts here-->
<div id="feature_row" class="container-fluid">
<div class="container">
	<div  class="row">
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<p class="text-center"><img class="img-circle img-responsive " src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">Browse Our Catalogue</h2>
			<p>We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p></p>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<p class="text-center"><img  class="img-circle img-responsive " src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">Special Product Order</h2>
			<p>We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p></p>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<p class="text-center"><img class="img-circle img-responsive " src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">FAQs</h2>
			<p>We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p></p>
		</div>
	</div>		
	</div>
	</div>
</div>

<!-- Social links-->
<div id="soc" class="container-fluid">
	<div class="container">
	<div id="soc" class="row">
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
				<ul>
					<a href="" id="soc_button" class="btn btn-default"><li class="fa fa-facebook fa-fw"></li></a>
				</ul>
			</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
				<ul>
					<a href="" id="soc_button" class="btn btn-default"><li class="fa fa-instagram fa-fw"></li></a>
				</ul>
			</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
			    <ul>
					<a href="" id="soc_button"  class="btn btn-default"><li class="fa fa-snapchat fa-fw"></li></a>
				</ul>
			</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
				<ul>
					<a href="" id="soc_button"  class="btn btn-default"><li  class="fa fa-whatsapp fa-fw"></li></a>
				</ul>
			</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
				<ul>
					<a href="" id="soc_button"  class="btn btn-default"> <li  class="fa fa-twitter fa-fw"></li></a>
				</ul>
			</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
			<p class="text-center">
				<ul>
					<a href="" id="soc_button"  class="btn btn-default"><li  class="fa fa-pinterest fa-fw"></li></a>
				</ul>
			</p>
		</div>
    </div>
	</div>
</div>
<!--End of Social links-->

<?php 
// set the footer here
include('includes/footer.html');
?>