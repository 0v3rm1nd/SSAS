<?php
require_once('../includes/session_timeout_db.inc.php');
$error = '';
$success = '';

$imageid = trim($_GET['iid']);
$image_name = trim($_GET['image_name']);

if (isset($_POST['com'])) {

    $owner = trim($_SESSION['authenticated']);
    $comment = trim($_POST['comment']);
    
    //if the username inputed is too big drop a message
    if(strlen($comment) > 100){
         $error = 'A comment can not be bigger than 100 characters!';
    }else{
        require_once('../includes/comment_image.inc.php');
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SSAS</title>
    </head>

    <body>
        <div id="allcontent">

            <div id="header">
                
            </div>

            <h1>Comment on image</h1>

            <?php
	            if ($error) {
	                echo "<p>$error</p></br>";
	            }else if($success){
	            	echo "<p>$success</p></br>";
	            }?>

            <form  id="shareform" action="" method="post">
				<label for="comment" data-icon="u" > Make a comment on picture <?php echo "$image_name";?>:</label>
				<input name="comment" required type="text" placeholder="fill in comment"/>
				<input type="submit" name="com" value="comment" />
			</form>

            <p>
                Click the link below to go back to the main board!
            </p>
            <p>
                <a href='main_board.php'><span>main board</span></a>
            </p>
            
            <h2> Current comments for <?php echo "$image_name";?></h2>
            <?php require('../includes/list_comments.inc.php');?>
            <div id="footer">
               
            </div>

        </div>

    </body>
</html>