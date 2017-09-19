
 <?php # Script 17.1 - add_print.php
 // This page allows the administrator to add a print (product).
require_once('includes/header.php');
 require_once('includes/connection.php');


 if (isset($_POST['submit'])) { // Handle the form.

 // Validate the incoming data...
 $errors = array();

 // Check for a product name:
 if (!empty($_POST['product_name'])) {
 $product_name = trim($_POST['product_name']);
 } else {
 $errors[] = 'Please enter the product name!';
 }

 // Check for a product name:
 if (!empty($_POST['category_name'])) {
 $category_name = trim($_POST['category_name']);
 } else {
 $errors[] = 'Please enter the category name!';
 }

 // Check for an image:
 if (is_uploaded_file ($_FILES['image']['tmp_name'])) {

 // Create a temporary file name:
 $temp = 'uploads/'. md5($_FILES['image']['name']);

 // Move the file over:
 if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {

     echo '<div class="alert alert-success" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Success!</strong><p>The product has been uploaded!</p>
           </div>';

// Set the $i variable to the image's name:
 $image_name = $_FILES['image']['name'];

 } else { // Couldn't move the file over.
 $errors[] = 'The file could not be moved.';
 $temp = $_FILES['image']['tmp_name'];
 }

 } else { // No uploaded file.
 $errors[] = 'No file was uploaded.';
 $temp = NULL;
 }


 // Check for a price:
 if (is_numeric($_POST['price'])) {
 $price = $_POST['price'];
 } else {
 $errors[] = 'Please enter the print\'s price!';
 }

 // Check for a description (not required):
 $description = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;



 // Validate the categories
 if (isset($_POST['check']) && ($_POST['check'] == 'new_cat')) {
 // If it's a new category, add the artist to the database...

 // Add the category to the database:

try{
	$sql='INSERT INTO categories SET 
	 categoryName = :category_name
	';
	$s=$pdo->prepare($sql);
	$s->bindvalue(':category_name',$category_name);
	$s->execute();
} catch(PDOException $e){
  echo 'Error inserting into db' .$e->getMessage();
}

 // Check the results....
 try{
 	$sql='SELECT categoryID FROM categories
 	       WHERE 
 	      categoryName = :category_name';
 	      $s=$pdo->prepare($sql);
 	      $s->bindvalue(':category_name', $category_name);
        $s->execute();
          
 }catch(PDOException $e){
     echo ''.$e->getMessage();
 }

 // Close this prepared statement:
 $result=$s->fetch();
 $uid = $result['categoryID'];
 } elseif ( isset($_POST['check'])) 
 { // Existing artist.
   $uid = (int) $_POST['check'];
  } else { // No artist selected.

 $errors[] = 'Please enter or select the print\'s artist!';

 }



 if (empty($errors)) { // If everything's OK.



 // Add the print to the database:
 try{
   
    $sql='INSERT INTO products SET
          productCategoryID = :uid,
          productName = :product_name,
          productPrice = :price,
          productLongDesc = :description,
          productImage = :image_name
         ';
         $s=$pdo->prepare($sql);
         $s->bindvalue(':uid', $uid);
         $s->bindvalue(':product_name', $product_name);
         $s->bindvalue(':price', $price);
         $s->bindvalue(':description', $description);
         $s->bindvalue(':image_name', $image_name);
         $s->execute();
 }catch(PDOException $e){
    echo "Error inserting into db". $e->getMessage();
 }

 // Check the results...
 try{
 	$sql='SELECT productID FROM products
 	       WHERE 
 	      productName = :product_name';
 	      $s=$pdo->prepare($sql);
 	      $s->bindvalue(':product_name', $product_name);
          $s->execute();
          
 }catch(PDOException $e){
     echo ''.$e->getMessage();
 }

 // Close this prepared statement:
 $result=$s->fetch();
 $pid = $result['productID'];
   rename($temp, "uploads/$pid");
 } // End of $errors IF.

 // Delete the uploaded file if it still exists:
 if ( isset($temp) && file_exists ($temp) && is_file($temp) ) {
 unlink ($temp);
 }

 } // End of the submission IF.

 // Check for any errors and print them:
 if ( !empty($errors) && is_array($errors) ) {
 echo '<div class="alert alert-warning alert-dismmisible fade show" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="close">
           <span aria-hidden="true">&times;</span>
           </button>
           <strong>Error!</strong><p>The followingg seem to be the problem:</p>
           </div>';
 foreach ($errors as $msg) {
echo " - $msg<br />\n";

 }

 echo 'Please reselect the print image and try again.</p>';

 }



 // Display the form...

 ?>


<!--form  -->
<div class="container">
  <div class="form">
    <form enctype="multipart/form-data"  method="post" action="admin_crud.php">
    <fieldset class="fieldset"> <h1>Admin CRUD</h1><br></fieldset>
    <input type="hidden" name="MAX_FILE_SIZE" value="824288" />

  <div class="form-group">
    <label for="Input">
      Category Name
    </label>
    <input type="text" name="category_name" class="form-control" id="InputFirstName" aria-describedby="entryHelp" placeholder="" required>
   
  </div>

  <div class="form-group">
    <label for="InputCountry">
      Choose if category exists or not...
    </label>
    <select name="check" class="form-control" id="InputCountry">
      <option value="new_cat">
        New Category
      </option>
      
     

<?php // Retrieve all the categories and check for existing cat_name to the pull-down menu.

try{
  $sql='SELECT categoryID , categoryName
   FROM categories';
   $s=$pdo->prepare($sql);
   $s->execute();
   $row=$s->fetch();
} catch(PDOException $e){
  echo 'Error querying db'. $e->getMessage();
}
 while ($row =$s->fetch()) {
 $cat_name =$row['categoryName'];
 $cat_id = $row['categoryID'];
 echo "<option value=\"$cat_id\"";

 // Check for stickyness:

 echo ">$cat_name</option>\n";

}
 
 
 ?>
 
    </select>
    
  </div>




  <div class="form-group">
    <label for="InputLastName">
      Product Name
    </label>
    <input type="text" name="product_name" class="form-control" id="InputLastName" aria-describedby="entryHelp" placeholder="" required>
  </div>
 

 <div class="form-group">
    <label for="InputLastName">
      Product Description
    </label>
    <textarea type="text" col="30" rows="10" name="description" class="form-control" id="InputLastName" aria-describedby="entryHelp" placeholder="" required ></textarea>
  </div>

 
  <div class="form-group">
    <label for="InputLastName">
      Price
    </label>
    <input type="text" name="price" class="form-control" id="InputLastName" aria-describedby="entryHelp" placeholder="" required>
  </div>

  <div class="form-group">
    <label for="InputCity">
      Product Image
    </label>
    <input type="file" name="image"  class="form-control-file" >
    
  </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
     <input type="hidden" name="submitted" value="TRUE" />

     </form>
  </div>

</div>
<!--End of form-->

<div class="container">
<br>
<br>
<div><h2 class="text-center">Catalogue of Products in the database</h2></div>
<br>
  <?php
// Default query for this page:
try{ $sql = 'SELECT categoryName, productID, productName, productImage, productPrice, productLongDesc
      FROM products, categories
       WHERE products.productCategoryID = categories.categoryID ';
      $s=$pdo->prepare($sql);
      $s->execute();
      $row=$s->fetch();
}catch(PDOException $e){
      echo 'Error querying db'.$e->getMessage();
}



// Create the table head:
 echo '<br><br> 
 <table border="0" width="90%"
cellspacing="3" cellpadding="3"
align="center">

<tr>
 <td align="left"
width="20%"><b> Category</b></td>
 <td align="left" width="20%"><b>Product
Name</b></td>
<td align="left" width="20%"><b>Product Image</b></td>
 <td align="left"
width="40%"><b>Description</b></td>
 <td align="center"
width="50%"><b>Price</b></td>
<td align="center"
width="40%"><b>Remove</b></td>
 </tr>

 ';

 // Display all the prints, linked to URLs:
 while ($row = $s->fetch()) {

 // Display each record:
 echo "\t<tr>
 <td align=\"left\">{$row['categoryName']}</td>
 <td align=\"left\">{$row['productName']}</td>
 <td align=\"left\">
  <div><img class=\"img-responsive\" 
 src=\"show_image.php?image={$row['productID']}&name=" . urlencode($row['productImage']) . "\" width=\"80%\" height=\"150px\"
 alt=\"{$row['productName']}\" /></div>
 </td>
 <td
align=\"left\">{$row['productLongDesc']}</td>
 <td
align=\"center\">#{$row['productPrice']}</td>

<td
align=\"center\"><a href=\"delete_product.php?pid={$row['productID']}\" role=\"button\" class=\"btn btn-primary\">Remove</a></td>
 </tr>\n";

 } // End of while loop.

 echo '</table><br><br>';
 ?>
</div>
<?php
require_once('includes/footer.html');
?>