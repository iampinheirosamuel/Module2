<?php # Script 16.8 - login.php
 // This is the login page for the site.
session_start();
// product catalog goes here

require_once('includes/connection.php');


 if (isset($_POST['submit'])) {

 // Validate the email address:
 if (!empty($_POST['email'])) {
  $email= $_POST['email'];
 } 
 else {
    $email = FALSE;
 echo '<p class="error">You forgot to enter your email address!</p> ';
 }
  // Validate the password:
 if (!empty($_POST['password'])) {
     $pass =$_POST['password'];
 } 
 else {
 $p = FALSE;
 echo '<p class="error">You forgot to enter your password!</p>';
 }
  // hashed_password
 $hashed_pass = sha1($pass);

 if ($email && $hashed_pass) { // If everything's OK.

 // Query the database:
try{
	$sql=' SELECT userID, userFirstname, userEmail, userPassword FROM users WHERE
	 userEmail = :email AND
	 userPassword = :hashed_pass';
	 $s=$pdo->prepare($sql);
	 $s->bindvalue('email',$email);
	 $s->bindvalue('hashed_pass',$hashed_pass);
	 $s->execute();
	 $result= $s->fetch();
}catch(PDOException $e){
  echo 'Error querying db'.$e->getMessage();
}
  if($result['userPassword']==$hashed_pass){
     $_SESSION['firstname'] = $result['userFirstname'];
     $_SESSION['userID']=$result['userID'];
     header("Location: user.php");
  } else{
     echo '<div class="alert alert-danger" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong><p>Wrong password/e-mail.</p></div>';

           header("Location:index.php");
  }
}
}

include('includes/header.php');

// set carousel here
include('includes/carousel.html');

?>

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

<br>
<br>

<?php 
// set the footer here
include('includes/footer.html');
?>
