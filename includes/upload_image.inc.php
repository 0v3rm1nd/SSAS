<?php

if(!isset($_FILES['userimage']))
    {
    echo '<p>Please select an image</p>';
    }
else
    {
    try{
          uploadimage();
          echo '<p>Thank you for uploading an image</p>';
        }
    catch(Exception $e)
        {
        echo '<h4>'.$e->getMessage().'</h4>';
        }
    }

    function uploadimage(){
    /*** check if image was successfully uploaded ***/
    if(is_uploaded_file($_FILES['userimage']['tmp_name']) && getimagesize($_FILES['userimage']['tmp_name']) != false)
        {
        /*** change this to a better value***/      
        $maxsize = 4097152;
        $name = $_FILES['userimage']['name'];
        $imgfp = fopen($_FILES['userimage']['tmp_name'], 'rb');
        $owner = trim($_SESSION['authenticated']);

        /*** check the file is less than the maximum file size ***/
        if($_FILES['userimage']['size'] < $maxsize )
            {
              /*** connect to db ***/
			  require_once('connection.inc.php');
              $dbh = dbConnect("write", "PDO");
			  // new PDO("mysql:host=localhost;dbname=ssas", 'root', '0v3rm1nd');

			  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt = $dbh->prepare("INSERT INTO images (image, image_name, owner) VALUES (? ,?, (SELECT id FROM users WHERE username = ?))");
              
              /*** bind the params ***/
              $stmt->bindParam(1, $imgfp, PDO::PARAM_LOB);
              $stmt->bindParam(2, $name);
              $stmt->bindParam(3, $owner);

              $stmt->execute();
            }
        else
            {
            /*** throw an exception is image is not of type ***/
            throw new Exception("File Size Error");
            }
        }
    else
        {
        // if the file is not less than the maximum allowed, print an error
        throw new Exception("Unsupported Image Format!");
        }
    }
?>
