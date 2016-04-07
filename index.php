<?php
$error = '';
if (isset($_POST['login'])) {
    session_start();
    $username = trim($_POST['username']);
    $password = trim($_POST['pwd']);
// location to redirect on success
    $redirectadmin = './authenticate/main_board.php';
    require_once('./includes/authenticate_mysqli.inc.php');
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

            <!-- LoginForm -->
                            <div id="login">

                                <form  id="loginform" action="" method="post"> 
                                    <h1>Log In</h1> 

                                    <?php
                                    if ($error) {
                                        echo "<p>$error</p>";
                                    } elseif (isset($_GET['expired'])) {
                                        ?>
                                        <p>Your session has expired. Please log in again.</p>
                                    <?php } ?>
                                    
                                    <p> 
                                        <label for="username" data-icon="u" > Your username</label>
                                        <input id="username" name="username" required type="text" placeholder="Fill in username"/>
                                    </p>
                                    <p> 
                                        <label for="password" data-icon="p"> Your password </label>
                                        <input id="password" name="pwd" required type="password" placeholder="Fill in password" /> 
                                    </p>

                                    <p> 
                                        <input type="submit" name="login" value="Login" /> 
                                    </p>

                                </form>
                            </div>
            <!-- Login Form End -->
            <p>
                If you are not already a user click the link below to register
            </p>
            <p>
                <a href='register.php'><span>register</span></a>
            </p>
            <div id="footer">
               
            </div>

        </div>

    </body>
</html>