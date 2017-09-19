<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
     
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
    <!--Awesome fonts-->
     <link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css">
    <!-- Core CSS Styling-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <!-- Bootstrap jQuery-->
    <script src="../js/bootstrap.min.js" type="text/javascript"></script> 
    <script src="../js/jquery.3.1.1.min.js" type="text/javascript"></script>
    <script src="js/app.js" type="text/javascript"></script> 
  <?php require_once('includes/connection.php');?>
  <script type="text/javascript">  window.wigzo = (function(module){    module.USER_IDENTIFIER =  ""; /* Fill your currently logged in customer's email or its unique ID here. Default - empty.*/    module.ORGANIZATIONID = "303512d8-0aec-47dd-b629-957660997b14";       module.FEATURES = {    "ONSITEPUSH": true    };   return module;}(window.wigzo || {}));</script><script async type="text/javascript" src="https://tracker.wigzopush.com/wigzo.js"></script><script async src="https://tracker.wigzopush.com/gcm_http_subscribe.js?orgtoken=303512d8-0aec-47dd-b629-957660997b14" type="text/javascript"></script><script type="text/javascript">window.wigzo = (function(module){module.httpGcmShowDialog = true;return module;}(window.wigzo || {}));</script>
  <title><?php echo $page_title; ?></title>
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <header>
    <nav id="header-social-nav" class="navbar navbar-fixed-top bg-faded">
    <div class="container">
      <div class="navbar-header">

        
         <ul id="nav-list-socials" class="nav nav-pills ">
         <li class="nav-item" class="visible">
            <a href="tel:+234-903-248-7893">
             <span class="glyphicon glyphicon-earphone"></span><div class="visible-lg">+234-903-248-7893</div>
             
            </a>
          </li>
          <li class="nav-item">
            <?php if(isset($_SESSION['cart'])){
                   echo '<a href="view_cart.php">
              <span class="glyphicon glyphicon-shopping-cart"><span class="badge">0</span></span>
            <div class="visible-lg">Shopping Cart </div></a>';
              } else{
                echo '<a href="#">
              <span class="glyphicon glyphicon-shopping-cart"><span class="badge">0</span></span>
            <div class="visible-lg">Shopping Cart </div></a>';
              }
              ?>
          </li>
         <!--#nav list-->
         <?php
         if (isset($_SESSION['firstname'])) {
            # code...
           echo '
          <li class="nav-item"><a href="wishlist.php"><span class="glyphicon glyphicon-bell
          "></span><div class="visible-lg">Wish-list</div></a>
          </li>';
           } else {
            echo '<li class="nav-item"><a href=""><span class="glyphicon glyphicon-bell
          "></span><div class="visible-lg">Wish-list</div></a>
          </li>';
           }
          ?>
          <!--#nav list-->
          <?php
              if (isset($_SESSION['firstname'])) {
                echo "<li class=\"dropdown\">
          <a class=\"btn btn-secondary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" href=\"\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-user
          \"></span> Hi, {$_SESSION['firstname']}</a>
          <div class=\"dropdown-menu\">
             <a href=\"logout.php\" class=\"dropdown-item\">Log Out</a><br>
             <a  href=\"change_password.php\">Change Password</a>
          </div>
          </li>
          ";
              }else{
               echo "<li class=\"dropdown\">
          <a class=\"btn btn-secondary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-log-in
          \"></span></a>
          <div class=\"dropdown-menu\">
             <a href=\"\" class=\"dropdown-item\"  data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#register\" data-whatever=\"@mdo\">Register</a><br>
            <a class=\"dropdown-item\" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#login\" data-whatever=\"@mdo\" href=\"\">Login</a>
          </div>
          </li>"; 
              }
           ?>
          
          <li class="visible-md visible-lg "> <!--Search form goes here!!!!-->
      <div id="search-form1">
        <form class="form-inline">
        <div class="input-group">
          <span class="input-group-btn">
          <button type="submit" id="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>
           </button></span>
          <input class="form-control" type="text" name="search"  placeholder="Search..." aria-describedby="basic-add0n1">
        </div>
        </form>
      </div>
      </li>
         </ul>
         <!--end of second navlist-->
         <!--Search form goes here!!!!-->
      <div id="search-form2" class="visible-xs">
        <form class="form-inline">
        <div class="input-group">
          <span class="input-group-btn">
          <button type="submit" id="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>
          </button></span>
          <input class="form-control" type="text"  name="search" placeholder="Search..." aria-describedby="basic-add0n2">
        </div>
        </form>
      </div>

       </div>  
    
    </div>
    </nav>
    
   <nav id="header-nav" class="navbar navbar-static-top">
   	 <div class="container">
	   <div class="navbar-header">
	   	<!--  <a href="index.html" class="pull-left visible-md visible-lg" >
	   	 <div id="logo-img" alt="Logo image">
	   	 </div>
	   	 </a> -->

	   	 <div class="navbar-brand">
	   	 	<a href="index.html">
	   	 		<h1>ElectroMart</h1>
	   	 	</a>
	   	 	<!-- <p>
	   	 		<img src="images/loge.png" alt="Kosher">
	   	 		<span>Kosher Certified</span>
	   	 	</p> -->
	   	 </div>

	   	 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	   	 <span  class="sr-only">Toggle navigation</span>
	   	 	<span class="icon-bar"></span>
	   	 	<span class="icon-bar"></span>
	   	 	<span class="icon-bar"></span>
	   	 </button>
	   </div>
       

       <div id="navbar" class="navbar-collapse collapse">
         <ul id="nav-list" class="nav navbar-nav navbar-right">
          <li class="">
          <?php 
            if(isset($_SESSION['firstname'])) {
            # code...
            echo "<a href=\"user.php\" >";
          } else{
            echo "<a href=\"index.php\" >";
          }
          ?>
         		
         			<span class="glyphicon glyphicon-home"></span><br class="hidden-xs ">Home
         		</a>
         	</li>
         	<li class="dropdown">
          <a class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart
          "></span><br class="hidden-xs">Categories</a>
          <div class="dropdown-menu">
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

while ($row=$s->fetch()) {
      echo "  <a class=\"dropdown-item btn btn-secondary dropdown-toggle\" type=\"button\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\" href=\"product_category.php?categoryID=".urlencode($row['categoryID'])."&categoryName=".urlencode($row['categoryName'])."\">{$row['categoryName']}</a><br>
      ";
}
 
    ?>
           
          </div>
          </li>
         	<li>
         		<a href="menu-categories.html">
         			<span class="glyphicon glyphicon-blackboard"></span><br class="hidden-xs">Contact Us 
         		</a>
         	</li>
          <li>
            <a href="menu-categories.html">
              <span class="glyphicon glyphicon-info-sign"></span><br class="hidden-xs">About Us 
            </a>
          </li>
          <?php 
          if (isset($_SESSION['firstname'])) {
            # code...
         echo '
         <li class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-dashboard
          "></span><br class="hidden-xs">Dashboard</a>
          <div class="dropdown-menu">
           
              <a class="btn btn-secondary dropdown-toggle" type="button" href="shopping-cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a><br>
              <a class="btn btn-secondary dropdown-toggle" type="button" href="wishlist.php"><span class="glyphicon glyphicon-bell"></span> Wishlist </a><br>
              <a class="btn btn-secondary dropdown-toggle" type="button" href="change_password.php"><span class="glyphicon glyphicon-refresh"></span> Change password</a><br>
              <a class="btn btn-secondary dropdown-toggle" type="button" href="#"><span class="glyphicon glyphicon-list"></span> Order History</a><br>
              <a class="btn btn-secondary dropdown-toggle" type="button" href="#"><span class="glyphicon glyphicon-list"></span> Subcribe to Newsletter</a><br>  

            
          </div>
         </li>';
          }
         ?>
         </ul><!--#nav list-->

       </div>  <!-- navigation. collapse--> 
     </div>
      </nav>
     </header>