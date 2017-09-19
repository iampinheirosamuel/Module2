<?php // view product from the  catalogue
// product catalog goes here
require_once('includes/connection.php');

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

 // Start the HTML page:

 $page_title = $row['productName'];

?>

<div class="container">
<div id="content" class="row">
<div id="product_spec" class="col-sm-8 col-md-8">

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

          
 					<div class="input-group">
 						<label>Quantity</label>
 						<input type="text" name="quantity" value="" class="form-control"  aria-describedby="entryHelp">
		                
 					</div><br>
 					
 					<button id="button"  data-backdrop="static" data-toggle="modal" data-target="#login" data-whatever="@mdo" href="" class="btn btn-primary">Add to Cart <span class="glyphicon glyphicon-shopping-cart
          "></span></button>
                
            <hr>
                 
 				<button id="button"  data-backdrop="static" data-toggle="modal" data-target="#login" data-whatever="@mdo" href="" class="btn btn-primary">Add to Wish-list <span class="glyphicon glyphicon-bell
          "></span></a></button>
                
		</section>
		<br>
	</div>
</div>

</div>
</div>




<div class="container">
  

<div id="modal" class="bd-example">
  
  <div class="modal" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Register Here!</h4>
        </div>
        <div id="modalbody" class="modal-body">
        
  <div class="form">
   <form method="post" action="index.php">
    <fieldset class="fieldset"> <h1>Register with Us</h1><br></fieldset>
  <div class="form-group">
    <label for="InputFirstName">
      First name
    </label>
    <input type="text" name="firstname" class="form-control"  aria-describedby="entryHelp" placeholder="Enter your first name" required>
    <small id="entryHelp" class="form-text text-muted">We'll refer to you by your first name.</small>
  </div>
  
  <div class="form-group">
    <label for="InputLastName">
      Surname
    </label>
    <input type="text" name="lastname" class="form-control"  aria-describedby="entryHelp" placeholder="Enter your surname" required>
  </div>

  <div class="form-group">
    <label for="InputEmail">
      Email address
    </label>
    <input type="email" name="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter your email address" required>
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
    
    <div class="form-group">
    <label for="InputTel">
      Telephone
    </label>
    <input type="tel" name="telephone" class="form-control"  aria-describedby="entryHelp" placeholder="" required>
    
  </div>

  <div class="form-group">
    <label for="InputAddress">
      Address
    </label>
    <textarea type="text" name="address" class="form-control" id="InputLastName" aria-describedby="entryHelp" placeholder="Enter your address..." required></textarea>
  </div>

  <div class="form-group">
    <label for="InputCity">
      City/Town
    </label>
    <input type="text" name="city" class="form-control" id="InputCity" aria-describedby="entryHelp" placeholder="">
    
  </div>

  <div class="form-group">
    <label for="InputState">
      State/Province
    </label>
    <input type="text" name="state" class="form-control" id="InputState" aria-describedby="entryHelp" placeholder="">
    
  </div>

  <div class="form-group">
    <label for="InputCountry">
      Country
    </label>
    <select name="country" class="form-control" id="InputCountry">
      <option >
        Please select a country...
      </option>
      <option value="Nigeria">
        Nigeria
      </option>
      <option value="Others">
        Others
      </option>
      
    </select>
    
  </div>

  <div class="form-group">
    <label for="InputPassword">
      Password
    </label>
    <input type="Password" name="password" class="form-control" id="InputPassword" aria-describedby="entryHelp" placeholder="Enter your password">
    <small id="entryHelp" class="form-text text-muted">Use special characters to strengthen password.</small>
  </div>

     <button id="button" type="submit" name="submit"  class="btn btn-primary">Submit</button>
    <input type="hidden" name="submitted" value="TRUE" />
   </form>
  </div>
  <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Send message</button> -->
        </div>
        </div>
        
      </div>
    </div>
  </div>
</div>


</div>



<div id="modal" class="bd-example">
  
  <div class="modal" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h1 class="modal-title" id="exampleModalLabel">User Login</h1>
        </div>
        <div id="modalbody" class="modal-body">
        
  <div class="form">
   <form method="post" action="login.php">
    <fieldset class="fieldset"> <h5>Enter your login credentials</h5><br></fieldset>

  <div class="input-group">
    <span class="input-group-addon"><li class="fa fa-envelope-o fa-fw"></li></span>
    <input type="email" name="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter your email address" required>
  </div>
 <br>
  <div class="input-group">
    <span class="input-group-addon"><li class="fa fa-key fa-fw"></li></span>
    <input type="Password" name="password" class="form-control" id="InputPassword" aria-describedby="entryHelp" placeholder="Enter your password">
  </div>
<br>
<div class="form-inline">
    
    <button id="button" type="submit" name="submit" class="btn btn-primary"></li>login</button>
  </div>
     
    <input type="hidden" name="submitted" value="TRUE" />
   </form>
  </div>
  <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Send message</button> -->

          <p class="text-center">Or<br>
          <span>Login Using</span>
         <button class="btn btn-default"><li class="fa fa-facebook"></li> </button></p>
          <hline><br>
         <a id="button" class="btn btn-primary" href="password_reset.php">Forgot your password?</a><br>
        

         
        </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

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