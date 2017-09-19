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

// add_cart =========================================================================

 if(isset($_POST['quantity'])){

  
 // This page adds prints to the shopping cart.

 // Set the page title and include the HTML header:
 $quantity = $_POST['quantity'];

 if (isset ($_GET['pid']) && is_numeric($_GET['pid']) ) { // Check for a print ID.

 $pid = $_GET['pid'];

 // Check if the cart already contains one of these prints;
 
 // If so, increment the quantity:
if (empty($_POST['quantity'])) {
 	 $_SESSION['cart'][$pid]['quantity']++;
 // Display a message.
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <p><strong>('.$_SESSION['cart'][$pid]['quantity'].') </strong>'.$row['productName'].' (s) has been added to your <a href=\'view_cart.php?pid=' .urlencode($pid). '\'>shopping cart</a>.</p></div>';
 }
else if (isset($_SESSION['cart'][$pid])) {

 $_SESSION['cart'][$pid]['quantity']+= $_POST['quantity']; // Add another.
 // Display a message.
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <p><strong>('.$_SESSION['cart'][$pid]['quantity'].') </strong>'.$row['productName'].' (s) has been added to your <a href=\'view_cart.php?pid=' .urlencode($pid). '\'>shopping cart</a>.</p></div>';

 } 
  else { // New product to the cart.

 // Get the print's price from the database:
 require_once('includes/connection.php');

try{
  $sql='SELECT productPrice, productName, productImage FROM products
        WHERE products.productID = :pid';
        $s=$pdo->prepare($sql);
        $s->bindvalue(':pid',$pid);
        $s->execute();  
}catch(PDOException $e){
     echo 'Error querying db'. $e->getMessage();
}
 
  $result=$s->fetch();   
if (count($result)>0) {
  // Valid print ID.

 // Fetch the information.
 $price = $result['productPrice'];
 $name = $result['productName'];
 $image_name =$result['productImage'];
 // Add to the cart:

 $_SESSION['cart'][$pid] = array('quantity' => $quantity, 'price'=> $price);

 // Display a message:
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <p><strong>'.$quantity. '</strong> - '.$name. '(s) has been added to your <a href=\'view_cart.php?pid=' .urlencode($pid). '\'>shopping cart</a>.</p></div>';

 } else { // Not a valid print ID.
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><div>This
page has been accessed in
error!</div></div>'; }

 } // End of isset($_SESSION['cart'][$pid] conditional.

  } else { // No print ID.
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><div>This
page has been accessed in
error!</div></div>';
 }
}
 
  // end of add cart ==================================================================
?>

<?php

if(isset($_SESSION['firstname'])){

 echo "<div> <h4> Welcome, ".$_SESSION['firstname']."</h4></div>";	
}
?>
<!--Validates the form-->
 

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



 
 // Display all featured products, linked to URLs:
$i=0;
 while ($i<3 && $row=$s->fetch()) {
 // Display each record:

 echo " <div class=\"mycards\">
<div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-4\">
<div class= \"card\">
<div class=\"cart_img\"><a href=\"product.php?pid={$row['productID']}\" ><img id=\"cart_img\" class=\"card-img-top img-responsive visible-xs visible-sm visible-md visible-lg\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" 
 alt=\"{$row['productName']}\" /></a></div>
<div class= \"card-block\" >
<h4 class= \"card-title\"><a href=\"product.php?pid={$row['productID']}\" >{$row['productName']}</a></h4>
</div>
<ul class= \"list-group list-group-flush\" >
<li class= \"list-group-item\" id=\"productdesc\">{$row['productLongDesc']}</li>
<li class= \"list-group-item\" >Price: &#8358;".number_format($row['productPrice'],2)." </li>
</ul>
<div class= \"card-block-btn\" >
<a id=\"cart_btn\" href= \"product.php?pid={$row['productID']}\" class= \"btn  \" > Order Now! <span class=\"glyphicon glyphicon-shopping-cart\"</a>
<a id=\"wishlist_btn\" href= \"product.php?pid={$row['productID']}\" class= \"btn  \" > Add to Wishlist <span class=\"glyphicon glyphicon-bell\"></span> </a>
<div class=\"clearfix visible-lg-block visible-md-block\"></div>
</div>
</div>
</div>
</div>  ";
$i++;
 }
 echo '</div>



 <div class="row">';
  // End of while loop.


// Display all featured products, linked to URLs:
$i=0;
 while ($i<3 && $row=$s->fetch()) {
 // Display each record:

 echo " <div class=\"mycards\">
<div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-4\">
<div class= \"card\">
<div class=\"cart_img\"><a href=\"product.php?pid={$row['productID']}\" ><img id=\"cart_img\" class=\"card-img-top img-responsive visible-xs visible-sm visible-md visible-lg\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" 
 alt=\"{$row['productName']}\" /></a></div>
<div class= \"card-block\" >
<h4 class= \"card-title\"><a href=\"product.php?pid={$row['productID']}\" >{$row['productName']}</a></h4>
</div>
<ul class= \"list-group list-group-flush\" >
<li class= \"list-group-item\" id=\"productdesc\">{$row['productLongDesc']}</li>
<li class= \"list-group-item\" >Price: &#8358;".number_format($row['productPrice'],2)." </li>
</ul>
<div class= \"card-block-btn\" >
<a id=\"cart_btn\" href= \"product.php?pid={$row['productID']}\" class= \"btn  \" > Order Now! <span class=\"glyphicon glyphicon-shopping-cart\"</a>
<a id=\"wishlist_btn\" href= \"product.php?pid={$row['productID']}\" class= \"btn  \" > Add to Wishlist <span class=\"glyphicon glyphicon-bell\"></span> </a>
<div class=\"clearfix visible-lg-block visible-md-block\"></div>
</div>
</div>
</div>
</div>  ";
$i++;
 }
?>
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