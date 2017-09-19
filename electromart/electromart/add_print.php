<!DOCTYPE html>
<html lang="en">
 <head>
 <meta charset="utf-8" />
 <title>Add a Print</title>
 </head>
 <body>
 <?php # Script 17.1 - add_print.php
 // This page allows the administrator to add a print (product).

 require_once('includes/connection.php');


 if (isset($_POST['submit'])) { // Handle the form.

 // Validate the incoming data...
 $errors = array();

 // Check for a print name:
 if (!empty($_POST['print_name'])) {
 $print_name = trim($_POST['print_name']);
 } else {
 $errors[] = 'Please enter the print name!';
 }

 // Check for an image:
 if (is_uploaded_file ($_FILES['image']['tmp_name'])) {

 // Create a temporary file name:
 $temp = 'uploads/' . md5($_FILES['image']['name']);

 // Move the file over:
 if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {
     echo '<p>The file has been uploaded!</p>';
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

 // Check for a size (not required):
 $size = (!empty($_POST['size'])) ? trim($_POST['size']) : NULL;

 // Check for a price:
 if (is_numeric($_POST['price'])) {
 $price = (float) $_POST['price'];
 } else {
 $errors[] = 'Please enter the print\'s price!';
 }

 // Check for a description (not required):
 $description = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;

 // Validate the artist...
 if (isset($_POST['artist']) && ($_POST['artist'] == 'new') ) {
 // If it's a new artist, add the artist to the database...

 // Validate the first and middle names (neither required):
 $first_name = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
 $middle_name = (!empty($_POST['middle_name'])) ? trim($_POST['middle_name']) : NULL;

 // Check for a last_name...
 if (!empty($_POST['last_name'])) {
$last_name = trim($_POST['last_name']);

 // Add the artist to the database:

try{
	$sql='INSERT INTO artists SET 
	 first_name = :first_name,
	 last_name = :last_name
	';
	$s=$pdo->prepare($sql);
	$s->bindvalue(':first_name',$first_name);
	$s->bindvalue(':last_name',$last_name);
	$s->execute();
} catch(PDOException $e){
  echo 'Error inserting into db' .$e->getMessage();
}

 // Check the results....
 try{
 	$sql='SELECT artist_id FROM artists
 	       WHERE 
 	      last_name = :last_name';
 	      $s=$pdo->prepare($sql);
 	      $s->bindvalue(':last_name', $last_name);
          $s->execute();
          
 }catch(PDOException $e){
     echo ''.$e->getMessage();
 }

 // Close this prepared statement:
 $result=$s->fetch();
 $uid = $result['artist_id'];

 } else { // No last name value.
 $errors[] = 'Please enter the artist\'s name!';
 }

 } elseif ( isset($_POST['artist']) && ($_POST['artist'] == 'existing') && ($_POST['existing'] >0) ) 
 { // Existing artist.
  $a = (int) $_POST['existing'];
  } else { // No artist selected.

 $errors[] = 'Please enter or select the print\'s artist!';

 }



 if (empty($errors)) { // If everything's OK.



 // Add the print to the database:
 try{
   
    $sql='INSERT INTO prints SET
          artist_id = :uid,
          print_name = :print_name,
          price = :price,
          size = :size,
          description = :description,
          image_name = :image_name
         ';
         $s=$pdo->prepare($sql);
         $s->bindvalue(':uid',$uid);
         $s->bindvalue(':print_name', $print_name);
         $s->bindvalue(':price', $price);
         $s->bindvalue(':size', $size);
         $s->bindvalue(':description', $description);
         $s->bindvalue(':image_name', $image_name);
         $s->execute();
 }catch(PDOException $e){
    echo "Error inserting into db". $e->getMessage();
 }

 // Check the results...
 try{
 	$sql='SELECT print_id FROM prints
 	       WHERE 
 	      print_name = :print_name';
 	      $s=$pdo->prepare($sql);
 	      $s->bindvalue(':print_name', $print_name);
          $s->execute();
          
 }catch(PDOException $e){
     echo ''.$e->getMessage();
 }

 // Close this prepared statement:
 $result=$s->fetch();
 $pid = $result['print_id'];
   rename($temp, "uploads/$pid");
 } // End of $errors IF.

 // Delete the uploaded file if it still exists:
 if ( isset($temp) && file_exists ($temp) && is_file($temp) ) {
 unlink ($temp);
 }

 } // End of the submission IF.

 // Check for any errors and print them:
 if ( !empty($errors) && is_array($errors) ) {
 echo '<h1>Error!</h1>
 <p style="font-weight: bold; color: #C00">The following error(s) occurred:<br />';
 foreach ($errors as $msg) {
echo " - $msg<br />\n";

 }

 echo 'Please reselect the print image and try again.</p>';

 }



 // Display the form...

 ?>

 <h1>Add a Print</h1>

 <form enctype="multipart/form-data" action="add_print.php" method="post">



 <input type="hidden" name="MAX_FILE_SIZE" value="524288" />



 <fieldset><legend>Fill out the form to add a print to the catalog:</legend>



 <p><b>Print Name:</b> <input type="text" name="print_name" size="30" maxlength="60"
value="<?php if (isset($_POST['print_name'])) echo htmlspecialchars($_POST['print_name']); ?>"
/></p>



 <p><b>Image:</b> <input type="file" name="image" /></p>



 <div><b>Artist:</b> 

 <p><input type="radio" name="artist" value="existing" <?php if (isset($_POST['artist']) &&
($_POST['artist'] == 'existing') ) echo ' checked="checked"'; ?>/> Existing =>

 <select name="existing"><option>Select One</option>

 <?php // Retrieve all the artists and add to the pull-down menu.

try{
	$sql='SELECT artist_id, first_name, middle_name, last_name
	 FROM artists ORDER BY last_name, first_name ASC';
	 $s=$pdo->prepare($sql);
	 $s->execute();
	 $row=$s->fetch();
} catch(PDOException $e){
	echo 'Error querying db'. $e->getMessage();
}
if(count($row)>0){
 while ($row =$s->fetch()) {

 echo "<option value=\"$row[0]\"";

 // Check for stickyness:

 if (isset($_POST['existing']) && ($_POST['existing'] == $row[0]) ) echo '
selected="selected"';

 echo ">$row[1]</option>\n";

}
 } else {

 echo '<option>Please add a new artist.</option>';

 }
 
 ?>
 </select></p>

 <p>

 <input type="radio" name="artist" value="new" <?php if (isset($_POST['artist']) &&
 ($_POST['artist'] == 'new') ) echo ' checked="checked"'; ?>/> 
 
 New =>First Name: <input type="text" name="first_name" size="10" maxlength="20" value="<?php if
(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" />

 
 Last Name: <input type="text" name="last_name" size="10" maxlength="40" value="<?php if
(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
 </div>

 <p><b>Price:</b> <input type="text" name="price" size="10" maxlength="10" value="<?php if
(isset($_POST['price'])) echo $_POST['price']; ?>" /> <small>Do not include the dollar sign or
commas.</small></p>

 <p><b>Size:</b> <input type="text" name="size" size="30" maxlength="60" value="<?php if
(isset($_POST['size'])) echo htmlspecialchars($_POST['size']); ?>" /> (optional)</p>

 <p><b>Description:</b> 
 <textarea name="description" cols="40" rows="5"><?php if
(isset($_POST['description'])) echo $_POST['description']; ?></textarea> (optional)</p>

 </fieldset>

 <div align="center"><input type="submit" name="submit" value="Submit" /></div>
 <input type="hidden" name="submitted" value="TRUE" />

 </form>

 </body>
 </html>