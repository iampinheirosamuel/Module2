<?php
// set the header
include('includes/header.php');

 // Set the page title and include the HTML header:
 $page_title = 'Registration Page';


// set carousel here
include('includes/carousel.html');

// product catalog goes here
require_once('includes/connection.php');

if (isset($_SESSION['firstname'])) {
 
 echo "<h1>Welcome, {$_SESSION['firstname']}!";
 
 }
 
 echo '</h1>';
?>
<!--User domain-->

<div class="container">

<?php
// Default query for this page:
try{ 
	$sql = 'SELECT 
      productName, productPrice, productLongDesc, productID, categoryID, categoryName, productImage 
      FROM products, categories
      WHERE products.productcategoryID = categories.categoryID
      ORDER BY categories.categoryName ASC';
      $s=$pdo->prepare($sql);
      $s->execute();
      $row=$s->fetch();
}catch(PDOException $e){
      echo 'Error querying db'.$e->getMessage();
}



 // Display all the prints, linked to URLs:
 while ($row = $s->fetch()) {

 // Display each record:

 echo " <div class=\"mycards\">
<div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-4\">
<div class= \"card\">
<div class=\"cart_img\"><a href=\"index/product.php?pid={$row['productID']}\" ><img id=\"cart_img\" class=\"card-img-top img-responsive visible-xs visible-sm visible-md visible-lg\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" 
 alt=\"{$row['productName']}\" /></a></div>
<div class= \"card-block\" >
<h4 class= \"card-title\"><a href=\"index/product.php?pid={$row['productID']}\" >{$row['productName']}</a></h4>
</div>
<ul class= \"list-group list-group-flush\" >
<li class= \"list-group-item\" id=\"productdesc\">{$row['productLongDesc']}</li>
<li class= \"list-group-item\" >Price: \${$row['productPrice']} </li>
</ul>
<div class= \"card-block-btn\" >
<a id=\"cart_btn\" href= \"#\" class= \"btn  \" > Order Now! <span class=\"glyphicon glyphicon-shopping-cart\"</a>
<a id=\"wishlist_btn\" href= \"#\" class= \"btn  \" > Add to Wishlist <span class=\"glyphicon glyphicon-bell\"></span> </a>
</div>
</div>
</div>
</div>  ";

 } // End of while loop.

?>

</div>

<!-- End of featured products-->

<!--Features starts here-->
<div id="feature_row" class="container-fluid">
	<div  class="row">
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<img class="img-circle" src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">Browse Our Catalogue</h2>
			<p class="text-center">We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<img class="img-circle" src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">Special Product Order</h2>
			<p class="text-center">We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div id="features">
			<img class="img-circle" src="images/01.jpg" alt="Generic placeholder image" >
			<h2 class="text-center">FAQs</h2>
			<p class="text-center">We have a rich collection electronics at our warehouses around Nigeria. Find your gadgets at affordable prices!</p>
			<p class="text-center"><a class="btn btn-primary" href="#" role="button">View Detials &raquo;</a></p>
		</div>
	</div>		
	</div>
</div>

<br>
<br>
<?php 
// set the footer here
include('includes/footer.html');
?>