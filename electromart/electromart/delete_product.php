<?php require("includes/connection.php");?>
<?php 
   
   if(!isset($_GET['pid']) ){
		echo "Invalid ID";
		exit();
   }
   elseif(!preg_match("/^[0-9]{1,12}$/",  trim($_GET['pid']))){die("Invalid");}

	
	 try {
	 $sql = 'DELETE  FROM products
               WHERE productID = :id ';
		 $s = $pdo->prepare($sql);
		 $s ->bindvalue(':id', $_GET['pid']);
		 $s->execute();
	   }
	   catch (PDOException $e)
	   {
	     echo 'Error deleting page ' . $e->getMessage();
		 exit();
	   }
	  header("location: admin_crud.php");
	
?>