<?php // view product from the  catalogue
// product catalog goes here
require_once('includes/connection.php');
// Start the HTML page:
session_start();
include ('includes/header.php');
?>

<?php // check for product id

if (isset($_GET['pid']) && is_numeric($_GET['pid']) ) { // Make sure there's a print ID!

 $pid = (int) $_GET['pid'];

 // Get the print info:
 
 try{ 
   $sql = 'SELECT productName, productLongDesc, productPrice, productImage, productID, productCategoryID, categoryID, categoryName 
       FROM products, categories
       WHERE categories.categoryID = products.productCategoryID AND
       products.productID = :pid';
       $s=$pdo->prepare($sql);
       $s->bindvalue(':pid',$pid);
       $s->execute();
      
   }catch(PDOException $e){
      echo 'Error querying db' .$e->getMessage();   }
     $row=$s->fetch();
 if (count($row)>0) { // Good go!

 // Fetch the information:
$page_title = $row['productName'];
 

 
?>

<div class="container">
<div id="content" class="row">
<div id="product_spec" class="col-sm-8 col-md-8">




<?php

// add_cart =========================================================================

 if(!empty($_POST['quantity'])){

  
 // This page adds prints to the shopping cart.

 // Set the page title and include the HTML header:
 $quantity = $_POST['quantity'];

 if (isset ($_GET['pid']) && is_numeric($_GET['pid']) ) { // Check for a print ID.

 $pid = $_GET['pid'];

 // Check if the cart already contains one of these prints;
 
 // If so, increment the quantity:
 if (isset($_SESSION['cart'][$pid])) {

 $_SESSION['cart'][$pid]['quantity']+= $_POST['quantity']; // Add another.
 // Display a message.
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <p><strong>('.$_SESSION['cart'][$pid]['quantity'].') </strong>'.$row['productName'].' (s) has been added to your <a href=\'view_cart.php\'>shopping cart</a>.</p></div>';

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
           <p><strong>'.$quantity. '</strong> - '.$name. '(s) has been added to your <a href=\'view_cart.php\'>shopping cart</a>.</p></div>';

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










			<div id="product_image" class="thumbnail"  ><?php if ($image = @getimagesize("uploads/$pid")) {
 echo 
 "<img src=\"show_image.php?image=$pid&name=" .
urlencode($row['productImage']) . "\" $image[3]
 alt=\"{$row['productName']}\" />\n";
 } else {
 echo "No
image available";
 }
}
}
else {
	echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><p>Page Not Found</p></div>';
}
?>
 </div>
 <div class="desc">
 	<div class="panel-group" id="accordion">
 		<div class="panel panel-default">
 		<div class="panel-heading">
 			<h4 class="panel-title"><a href="#Description" data-parent="#accordion" data-toggle="collapse">Product Description</a></h4>
 		</div>
 		<div id="Description" class="panel-collapse collapse in">
 			<div class="panel-body">
 				<?php echo "{$row['productLongDesc']}"; ?>
 				Hey there we're having some php ish here... wanna help out?
 			</div>
 		</div>
 	</div>
    
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h4 class="panel-title"><a href="#Reviews" data-parent="#accordion" data-toggle="collapse">Reviews</a></h4>
 		</div>
 		<div id="Reviews" class="panel-collapse collapse">
 			<div class="panel-body">
 			<div class="reviews">
 				<?php if (isset($_POST['submit'])) {
 					# code...
 					echo "<section>
                     <h5>{$_POST['review']}</h5><br>
                     <p>By: {$_POST['name']}</p>
 					</section><br><br>";
 				} ?>
 			</div>
 			<h3>Write your review for this product</h3>
 				<form method="post" action="#Reviews">
 					<div class="input-group">
 						<label>Your Name</label>
 						<input type="text" name="name" class="form-control"  aria-describedby="entryHelp" placeholder="Enter your name" required>
		                
 					</div><br>
 					<div class="input-group">
 					    <label>Your Review</label>
 						<textarea type="text" name="review" class="form-control"  aria-describedby="entryHelp" placeholder="..." required>
		                </textarea>
 					</div><br>
 					<input type="submit" name="submit" class="btn btn-primary" value="Submit">
 				</form>
 			</div>
 		</div>
 	</div>
 </div>
 </div>
 </div>
<div id="product_req" class="col-sm-3  col-md-3">
<div id="nav">
	<h3><?php echo "{$row['productName']}"; ?></h3>
	<hr>
		<section>
			
          <div class="tag">
            <p>Selling Price <span class="glyphicon glyphicon-tag"></span> : <?php echo "<strong> &#8358;".number_format($row['productPrice'],2)."</strong>"; ?></p>
          </div><br>

          <form method="post" action="<?php echo "product.php?pid={$row['productID']}"; ?>">
 					<div class="input-group">
 						<label>Quantity</label>
 						<input type="text" name="quantity" value="" class="form-control"  aria-describedby="entryHelp">
		                
 					</div><br>
 					
 					<button id="button" type="submit" class="btn btn-primary">Add to Cart <span class="glyphicon glyphicon-shopping-cart
          "></span></button>
                <input type="hidden" name="submitted">
 				</form><hr>
                 <form action="" method="post" >
 				<button id="button" type="submit" name="wishlist" class="btn btn-primary">Add to Wish-list <span class="glyphicon glyphicon-bell
          "></span></a></button>
                 </form>
		</section>
		<br>
	</div>
</div>

</div>
</div>

<?php 

if(isset($_POST['wishlist']))  
 // This page adds products to the wishlist.

 // Set the page title and include the HTML header:
 $mywishlist = $_POST['wishlist'];

 if (isset ($_GET['pid']) && is_numeric($_GET['pid']) ) { // Check for a print ID.

 $pid = $_GET['pid'];
 
  // New product to the wishlist.

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

 $_SESSION['wishlist'][$pid] = array('productName' => $name, 'price'=> $price);

 } else { // Not a valid print ID.
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><div>This
page has been accessed in
error!</div></div>'; }

  // End of isset($_SESSION['cart'][$pid] conditional.

  } else { // No print ID.
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><div>This
page has been accessed in
error!</div></div>';
 }

 
  // end of add to wishlist ==================================================================
?>

<!-- Social links-->
<div id="soc" class="container-fluid">
	<div class="container">
	<div class="row">
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
// Complete the page:
 include ('includes/footer.html');

 ?>