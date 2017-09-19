<?php
// Create a database connection
                            try{
							      $pdo = new PDO(
							      	'mysql:host=localhost;
							      	dbname=commerce' , 'root','');

								  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								  $pdo->exec ('set NAMES "utf8"');

							   }
							   catch (PDOException $e)
							   {
							    $error = 'Unable to connect to the database';
								
								exit();
							   }
?>