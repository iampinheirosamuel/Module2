<?php # Script 16.10 - forgot_password.php
 // This page allows a user to reset their password, if forgotten.
session_start();
 $page_title = 'Change Password';
 include ('includes/header.php');
 include('includes/connection.php');
// If no first_name session variable exists, redirect the user:
 if (!isset($_SESSION['firstname'])) {

 ob_end_clean(); // Delete the buffer.
  header("Location: index.php");
  exit(); // Quit the script.
 }
 ?>
 <div class="container">
<div id="content" class="row">
<div id="sidebar" class="col-sm-3 col-md-2 sidebar" class="hidden-xs hidden-sm">
  <div id="nav">
  <h3>Select Here!</h3>
    <section>
      <ul>
        <li>Category</li>
      </ul>
    </section>
  </div>
</div>
<div id="product_tray" class="col-sm-8  col-md-9  main">
<div class="row">
<?php 


 if (isset($_POST['submit'])) {

 // Check for a new password and match against the confirmed password:
 if (preg_match ('/^(\w){4,20}$/', $_POST['password1']) ) {

 if ($_POST['password1'] == $_POST['password2']) {
 $pass = $_POST['password1'];
 } else {
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yuck!!</strong><p>Your password
did not match the confirmed
password!</p></div>';
 }
 } else {
  echo '<div class="alert alert-" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Oops!</strong><p>Please enter a
valid password!</p></div>';
 }

 

 if(isset($pass)){
    
    try{
      $sql='UPDATE users SET userPassword = :hashed_password
      WHERE userID = :user'
      ;

      $s=$pdo->prepare($sql);
      $s->bindvalue(':hashed_password',sha1($pass));
      $s->bindvalue(':user',$_SESSION['userID']);
      $s->execute();
    }  
    catch(PDOException $e){
       echo'Error updating db'.$e->getMessage();
    } 
    echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Success!</strong><p>Your password has been changed successfully.</p></div>';
    
 } else{
  echo '<div class="alert alert-warning" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Oops!</strong><p>Your password
was not changed. Make sure your new
password is different than the
current password. Contact the system
administrator if you think an error
occurred.</p></div>';
 }
}
 ?>


<?php

if(isset($_SESSION['firstname'])){

 echo "<div><h1>Change Password</h1></div><hr>";  
}
?>

<div class="form">
   <form method="post" action="change_password.php">
    <fieldset class="fieldset"> <h5>You can change your password here:</h5><br></fieldset>

  <div class="input-group">
    <span class="input-group-addon"><li class="fa fa-key fa-fw"></li></span>
    <input type="password" name="password1" class="form-control"  aria-describedby="emailHelp" placeholder="Enter your new password" required>
  </div>
 <br>
  <div class="input-group">
    <span class="input-group-addon"><li class="fa fa-key fa-fw"></li></span>
    <input type="password" name="password2" class="form-control"  aria-describedby="emailHelp" placeholder="Confirm your new password" required>
  </div>
<br>
<div class="form-inline">
    
    <button type="submit" width="100%" name="submit" class="btn btn-primary">Change Password</button>
  </div>
     
    <input type="hidden" name="submitted" value="TRUE" />
   </form>
  </div>
 <hr> 

<!--Validates the form-->
<h2>Featured Products</h2> 
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
<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">
<div class= \"card\">
<div class=\"cart_img\"><a href=\"product.php?pid={$row['productID']}\" ><img id=\"cart_img\" class=\"card-img-top img-responsive visible-xs visible-sm visible-md visible-lg\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" 
 alt=\"{$row['productName']}\" /></a></div>
<div class= \"card-block\" >
<h4 class= \"card-title\"><a href=\"product.php?pid={$row['productID']}\" >{$row['productName']}</a></h4>
</div>
<ul class= \"list-group list-group-flush\" >
<li class= \"list-group-item\" id=\"productdesc\">{$row['productLongDesc']}</li>
<li class= \"list-group-item\" >Price: \${$row['productPrice']} </li>
</ul>
<div class= \"card-block-btn\" >
<a id=\"cart_btn\" href= \"#\" class= \"btn  \" > Order Now! <span class=\"glyphicon glyphicon-shopping-cart\"</a>
<a id=\"wishlist_btn\" href= \"#\" class= \"btn  \" > Add to Wishlist <span class=\"glyphicon glyphicon-bell\"></span> </a>
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
<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-4\">
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
 include ('includes/footer.html');
 ?>