<?php # Script 16.10 - forgot_password.php
 // This page allows a user to reset their password, if forgotten.

 include('includes/connection.php');
 $page_title = 'Forgot Your Password';
 include ('includes/header.php');
// If no first_name session variable exists, redirect the user:

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
 

 // Validate the email address...
 if (!empty($_POST['email'])) {

 // Check for the existence of that email address...
  try{
    $sql='SELECT userID FROM users
    WHERE userEmail = :email';

    $s=$pdo->prepare($sql);
    $s->bindvalue(':email',$_POST['email'] );
    $s->execute();
    $result= $s->fetch();
  }
  catch(PDOException $e){
       echo 'Error querying db'. $e->getMesssage();
  }

  if(count($result>0)){
     $uid=$result['userID'];
  } else{
    echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong><p>The submitted email does not match. Please try again </p>
           </div>';

  }

 } else { // No email!
 echo '<div class="alert alert-warning" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong>
           <p>You forgot to
enter your email address!</p></div>';
}  // End of empty email


 if($uid){
   // create a new password
  $p = substr(md5(uniqid(rand(),true)),3,10);

  //update the database

  try{
    $sql='UPDATE users SET userPassword = :hashed_password
    WHERE userID = :uid';

    $s=$pdo->prepare($sql);
    $s->bindvalue(':hashed_password',sha1($p));
    $s->bindvalue(':uid',$uid);
    $s->execute();
  } 
  catch(PDOException $e){
      echo 'Error updating db'.$e->getMesssage();
  }
  
    // Send email to user with new password
     $body = "Your password to log into
<whatever site> has been temporarily changed to '$p'. Please log in using
this password and this email address. Then you may change your password to something more familiar.";
    
    //$sendmail= @mail($_POST['email'], 'Your temporary password.', $body, 'From:admin@sitename.com');

 // Print a message and wrap up:
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Success!</strong>
           <p>Your password has been changed. You will receive the new,
temporary password at the email address with which you registered.
Once you have logged in with this password, you may change it by
clicking on the "Change Password" link.</p></div>';


 }
 else{
    echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Wrong Email!</strong>
           <p class="error">Please enter <strong>your email</strong>. </p></div>';
 }

}
 ?>


<?php

 echo "<div><h1>Password Reset</h1></div><hr>";  

?>

<div class="form">
   <form method="post" action="password_reset.php">
    <fieldset class="fieldset"> <h5>Enter your enmail while we reset your password. Thanks</h5><br></fieldset>

  <div class="input-group">
    <span class="input-group-addon"><li class="fa fa-envelope-o fa-fw"></li></span>
    <input type="email" name="email" maxlength="30" class="form-control"  aria-describedby="emailHelp" placeholder="Enter your email address" required>
  </div>
 <br>
<br>
<div class="form-inline">
    
    <button type="submit" width="100%" name="submit" class="btn btn-primary">Reset password</button>
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