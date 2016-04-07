<?php
require_once('../includes/session_timeout_db.inc.php');
if (isset($_POST['upload'])) {
    require_once('../includes/upload_image.inc.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Main Board </title>
    </head>
    <body>
        <div id="allcontent">
            <div id="header">
               
            </div>

            <div id="uploadimage">
                <h1>
                    Upload an image
                </h1>
                <h3>
                   Please choose an image and click the Upload Button
                </h3>

                  <form enctype="multipart/form-data" method="post" action="">
                    <input type="hidden" name="MAX_FILE_SIZE" value="4097152" />
                    <div><input name="userimage" type="file" /></div>
                    <div><input name= "upload" type="submit" value="Upload" /></div>
                  </form>
            </div>

                <h1>Logout</h1>
                <h3>Press the logout button to logout!</h3>
                
                <form method="post" action="">
                    <?php include('../includes/logout_db.inc.php'); ?>
                    <input name="logout" type="submit" id="logout" value="Logout">
                </form>

            <div id="ownimages">
                <h1>
                    Your Images
                </h1>                                
                <?php
                  require_once('../includes/display_ownimages.inc.php');
                ?>
            </div>

            <div id="sharedimages">
                <h1>
                    Images Shared With you
                </h1>
                <?php
                  require_once('../includes/display_sharedimages.inc.php');
                ?>
            </div>

            <div id="footer">
                
            </div>

        </div>
    </body>

</html>