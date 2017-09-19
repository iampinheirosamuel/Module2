<?php
// set the header
// product catalog goes here
require_once('includes/connection.php');
$page_title="Electromart";
include('includes/header.php');

// set carousel here
include('includes/carousel.html');


?>

<div class="container">
<div id="content" class="row">
<div  class=" col-md-3  sidebar">
<div id="sidebar">
	<div id="nav">
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
</div>
</div>
<div id="product_tray" class="  col-md-9  main">
<div class="row">

<!--Validates the form-->
 <?php
//
if (isset($_POST['submit'])) { // Handle the form...

// Validate the incoming data...
 $errors = array();

 //incoming data
 $firstname = $_POST['firstname'];
 $lastname = $_POST['lastname'];
 $email = $_POST['email'];
 $telephone = $_POST['telephone'];
 $city = $_POST['city'];
 $state = $_POST['state'];
 $country = $_POST['country'];
 $pass = $_POST['password'];
 $address = $_POST['address'];


 // Check for name:
 if (preg_match('/^[A-Z \'.-]{2,40}$/i', $_POST['firstname'])) {
 $firstname = $_POST['firstname'];
 } else {
 $errors[] = 'Please enter your firstname';
}

 if (preg_match('/^[A-Z \'.-]{2,40}$/i', $_POST['lastname'])) {
 $lastname = $_POST['lastname'];
 } else {
 $errors[] = 'Please enter your surname';
} 

//Check for telephone
if (preg_match('/^[0-9]{2,40}$/', $_POST['telephone'])) {
 $telephone = $_POST['telephone'];
 } else {
 $errors[] = 'Please enter your telephone';
}

// Validate the email address:
 if (preg_match('/^[\w.-]+@[\w.-]+\.[AZa-z]{2,6}$/', $_POST['email'])) {
     $email= $_POST['email'];
 } 
 else {
    $errors[] = 'You entered an invalid email address! ';
 }
  // Validate the password:
 if (!empty($_POST['password'])) {
     $pass =$_POST['password'];
 } 
 else {
 $errors[]='You forgot to enter your password!';
 }



 if (empty($errors)) { // If everything's OK...

 try {

 	$q = 'SELECT userEmail
            FROM users 
            WHERE userEmail = :email ';
        $stm = $pdo->prepare($q);
        $stm->bindvalue(':email', $email);
        $stm->execute(); 
        $result = $stm->fetch();    
   }
  catch(PDOException $e){
   	echo $e->getMessage();
         }
 $del_email = $result['userEmail'];

 if ($del_email == $email) { //Available

//2
echo  '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Yay!</strong><p>That email
address has already been registered.
If you have forgotten your password,
use the link at right to have your
password sent to you.</p></div>'; 

// // Include the HTML footer.
//      include('includes/footer.html');      
//  // Stop the page.
//       exit();
 }else{
 // If everything's OK.

 // Query the database:
try{
    $sql = 'INSERT INTO users SET
            userEmail = :email,
            userPassword = :pass,
            userFirstname = :firstname, 
            userSurname = :lastname,
            userAddress = :address,
            userCity = :city,
            userState = :state,
            userCountry = :country,
            userPhone = :telephone
           ';
         $s = $pdo->prepare($sql);
		 $s->bindvalue(':email',$email);
		 $s->bindvalue(':pass',sha1($pass));
         $s->bindvalue(':firstname',$firstname);
         $s->bindvalue(':lastname',$lastname);
         $s->bindvalue(':address',$address);
         $s->bindvalue(':city',$city);
         $s->bindvalue(':state',$state);
         $s->bindvalue(':country',$country);
         $s->bindvalue(':telephone',$telephone);
		 $s->execute();
 }
 catch (PDOException $e)
	   {
	     $error = 'Error registering user' . $e->getMessage();
	   }

	   // Send the email:
    $body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
         // Create the activation code:
 	    $a =md5(uniqid(rand(), true));

 // $body .= BASE_URL . 'activate.php?x=' . urlencode($email) . "&y= $a";

 // Finish the page:
 echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Success!</strong><p>Thank you for registering! A confirmation email has been sent to your address.
          Please click on the link in that email in order to activate your account.</p>
           </div>';
// Include the HTML footer.
 //     include('includes/footer.html');      
 // // Stop the page.
 //      exit();
    }
    
     //end of if for email reg


      }
else { echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong><p>You could
not be registered due to a system
error. We apologize for any
inconvenience.</p></div>';
}

}                           
 //Alert! there is an error somewhere

if(!empty($errors) && is_array($errors)) {
 echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong><p>Complete filling out the form first!</p><br>
          ';foreach ($errors as $msg) {
	# code...
	echo " -$msg <br />";
}

           echo '</div>';
}


?>

<!--End of validate the form-->


<?php
// Default query for this page:
if (isset($_GET['categoryID'])) {
    $cat_id = $_GET['categoryID'];
    $cat_name =$_GET['categoryName'];
try{ 
	$sql = 'SELECT 
      productName, productPrice, productLongDesc, productID, productImage , categoryName 
      FROM products , categories
      WHERE categories.categoryID = products.productcategoryID AND
      products.productcategoryID = :categoryID
     ';
      $s=$pdo->prepare($sql);
      $s->bindvalue(':categoryID',$cat_id);
      $s->execute();
     
}catch(PDOException $e){
      echo 'Error querying db'.$e->getMessage();
}

echo '<div><h2>'.$cat_name.'</h2></div>';

 // Display all featured products, linked to URLs:
 foreach ($s as $row) {
 // Display each record:

 echo " <div class=\"mycards\">
<div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-4\">
<div class= \"card\">
<div class=\"cart_img center-block\" ><a href=\"product_details.php?pid={$row['productID']}\" ><img id=\"cart_img\" class=\"card-img-top img-responsive visible-xs visible-sm visible-md visible-lg\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" 
 alt=\"{$row['productName']}\" /></a></div>
<div class= \"card-block\" >
<h4 class= \"card-title\"><a href=\"product_details.php?pid={$row['productID']}\" >{$row['productName']}</a></h4>
</div>
<ul class= \"list-group list-group-flush\" >
<li class= \"list-group-item\" id=\"productdesc\">{$row['productLongDesc']}</li>
<li class= \"list-group-item\" >Price: \${$row['productPrice']} </li>
</ul>
<div class= \"card-block-btn\" >
<a id=\"cart_btn\" href= \"\" class= \"btn  \" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#login\" data-whatever=\"@mdo\"> Order Now! <span class=\"glyphicon glyphicon-shopping-cart\"</a>

<a id=\"wishlist_btn\" href= \"\" class= \"btn  \" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#login\" data-whatever=\"@mdo\"> Add to Wishlist <span class=\"glyphicon glyphicon-bell\"></span> </a>
<div class=\"clearfix visible-lg-block visible-md-block\"></div>
</div>
</div>
</div>
</div>  ";
 }
 

 }
 else{
 	echo '<div class="alert alert-warning" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Oops!</strong><h4>We have run out of products in this category</h4>
           </div>';
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
	<h3 class="text-center">We're also social!</h3>
    <p></p>
	<hr>
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

<!-- Feedback Modal-->
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



<?php 
// set the footer here
include('includes/footer.html');
?>