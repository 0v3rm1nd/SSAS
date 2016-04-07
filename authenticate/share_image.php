<?php
require_once('../includes/session_timeout_db.inc.php');
$error = '';
$success = '';

$imageid = trim($_GET['iid']);
$image_name = trim($_GET['image_name']);

if (isset($_POST['share'])) {
	$owner = trim($_SESSION['authenticated']);
	$username = trim($_POST['shareuser']);
    
    //if the username inputed is too big drop a message
    if(strlen($username) > 30){
         $error = 'Username can not be bigger than 30 chars!';
    }else{
        require_once('../includes/share_image.inc.php');
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

            <h1>Share Image</h1>

            <?php
	            if ($error) {
	                echo "<p>$error</p></br>";
	            }else if($success){
	            	echo "<p>$success</p></br>";
	            }?>

            <form  id="shareform" action="" method="post">
				<label for="shareuser" data-icon="u" > Share <?php echo "$image_name";?> with:</label>
				<input name="shareuser" required type="text" placeholder="Fill in username"/>
				<input type="submit" name="share" value="Share" />
			</form>

            <p>
                Click the link below to go back to the main board!
            </p>
            <p>
                <a href='main_board.php'><span>main board</span></a>
            </p>
            <div id="footer">
               
            </div>

        </div>

    </body>
</html>



