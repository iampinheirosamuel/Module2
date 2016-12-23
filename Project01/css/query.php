<?php 

    /*** ======================  Function A1 -Queries unique IDs of both category and product
    ==========================================================*****/

function get_category_by_id($category_id){
	  global $pdo;
   	 try {
							     $sql = "SELECT * 
								 FROM productcategories 
								 WHERE id={$category_id}
								 LIMIT 1";
								 $category_set = $pdo->query($sql);
							   }
							   catch (PDOException $e) 
							   {
							      $error =  'Error fetching menu_name:' . $e->getMessage();
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
							      $error =  'Error fetching menu_name:' . $e->getMessage();
								  exit ();
							   }  
							   if ($product = $product_set->fetch())
							   { 
							     return $product;
							   } else {
							      return NULL;
							   }						   
	}
   
/* =========================================================================== Results of queried products and categories
*/



                   try {
							     $sql = 'SELECT product_name,product_price,product_longdesc 
								 FROM products 
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

							   }
						}

?>