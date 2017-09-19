<?php 
    // this file is where every basic function goes
	
	function redirect_to($page){
	   header("Location: {$page}");
	   exit();
	}
	
	function mysql_prep($value){
	  $magic_quotes_active = get_magic_quotes_gpc();
	  $new_enough_php = function_exists("mysql_real_escaoe_string"); 
	  // PHP > v4.3.0
	   if($new_enough_php){
	     if(!magic_quotes_active){ $value =- stripslashes($values);}
		 $value = mysql_real_escape_string($value);
	  } else {
	     if(!$magic_quotes_active) {$value = addslashes($value);}
	  }
	  return  $value; 
	}
	
	function get_category_by_id($category_id){
	  global $pdo;
   	 try {
							     $sql = "SELECT * 
								 FROM  categories
								 WHERE id={category_id}
								 LIMIT 1";
								 $category_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching categories' . $e->getMessage();
								  exit ();
							   }  
							   if ($category = $category_set->fetch())
							   { 
							     return $category;
							   } else {
							      return NULL;
							   }
							  
							   
	}
	
	function get_product_by_id($product_id){
	  global $pdo;
   	 try {
							     $sql = "SELECT * 
								 FROM products 
								 WHERE id={$product_id}
								 LIMIT 1";
								 $product_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching products' . $e->getMessage();
								  exit ();
							   }  
							   if ($product = $product_set->fetch())
							   { 
							     return $product;
							   } else {
							      return NULL;
							   }
							  
							   
	} 
	// 
	function find_selected_page (){
	global $sel_category;
	global $sel_product;
	  if (isset($_GET['cat_id'])){
	  $sel_category= get_category_by_id($_GET['cat_id']);
	  $sel_product =NULL;
   } elseif (isset($_GET['prod_id'])){
	  $sel_product= get_product_by_id($_GET['product']);
	  $sel_category=NULL;
   } 
   else {
   $sel_category=NULL;
   $sel_product=NULL;
   }   
	}
	
	function navigation($sel_category, $sel_product){
	     global $pdo;
	    echo "<ul class=\"subjects\">";
						      
							   //Perform database query
						      try {
							     $sql = 'SELECT * 
								 FROM categories 
								 ORDER BY position ASC';
								 $subject_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching categories' . $e->getMessage();
								  exit ();
							   }
							  
							   while ($category = $category_set->fetch())
							   {
							     echo "<li";
								       if ($category["id"] == $sel_category['id']){
									      echo " class=\"selected\" ";
									   }
								    echo "><a href=\".php?subj=" . urlencode($subject["id"]) . "\">
								 {$subject["menu_name"]}</a></li>";
								 
								 // Fetching data for pages looping in a loop
								 
								 try {
							     $sql = "SELECT * 
								 FROM pages 
								 WHERE subject_id ={$subject["id"]}
								 ORDER BY position ASC" ;
								 $page_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching menu_name:' . $e->getMessage();
								  exit ();
							   }
							   echo "<ul class=\"pages\">";
							   
							   while ($page = $page_set->fetch())
							   {
							     echo "<li";
								   if ($page["id"] == $sel_page['id']){
									      echo " class=\"selected\" ";
									   }
								 
								 echo "><a href=\"edit_page.php?page= ". urlencode($page["id"]) . 
								 "\">
								 {$page["menu_name"]}</a></li>";
								}
								
								echo "</ul>";
								}
	}
	
	function public_navigation($sel_subject, $sel_page){
	     global $pdo;
	    echo "<ul class=\"subjects\">";
						      
							   //Perform database query
						      try {
							     $sql = 'SELECT * 
								 FROM subjects 
								 ORDER BY position ASC';
								 $subject_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching menu_name:' . $e->getMessage();
								  exit ();
							   }
							  
							   while ($subject = $subject_set->fetch())
							   {
							     echo "<li";
								       if ($subject["id"] == $sel_subject['id']){
									      echo " class=\"selected\" ";
									   }
								    echo "><a href=\"index.php?subj=" . urlencode($subject["id"]) . "\">
								 {$subject["menu_name"]}</a></li>";
								 
								 // Fetching data for pages looping in a loop
								if($subject["id"]== $sel_subject["id"]){ 
								 try {
							     $sql = "SELECT * 
								 FROM pages 
								 WHERE subject_id ={$subject["id"]}
								 ORDER BY position ASC" ;
								 $page_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching menu_name:' . $e->getMessage();
								  exit ();
							   }
							   echo "<ul class=\"pages\">";
							   
							   while ($page = $page_set->fetch())
							   {
							     echo "<li";
								   if ($page["id"] == $sel_page['id']){
									      echo " class=\"selected\" ";
									   }
								 
								 echo "><a href=\"index.php?page= ". urlencode($page["id"]) . 
								 "\">
								 {$page["menu_name"]}</a></li>";
								}
								
								
						}
								
								echo "</ul>";
								}
	}
	
	  // to fetch subjects from database by their id
	function get_all_subjects(){
	     global $pdo;
						      try {
							     $sql = 'SELECT * 
								 FROM subjects 
								 ORDER BY position ASC';
								 $subject_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching menu_name:' . $e->getMessage();
								  exit ();
							   }
							  
							   while ($subject = $subject_set->fetch())
							   {
							      echo $subject;
							   }
							   return $subject;
							   }
?>




	try{ 
		$sql='SELECT * FROM users
		 WHERE email=:email';

		$s=$pdo->prepare($sql);
		$s->bindvalue(':email',$email);
		$s->execute();
	}
	catch(PDOException $e){
      echo 'Query failed'. $e->getMesasge;
      exit();
	}

	 $row = $s->fetch();
			
if (count($row)>0){
}
else { // The email address is not available.
 	echo '<p class="error">That email
address has already been registered.
If you have forgotten your password,
use the link at right to have your
password sent to you.</p>';
 }

 } else { // If it did not run OK.
 echo '<p class="error">You could
not be registered due to a system
error. We apologize for any
inconvenience.</p>';
 }