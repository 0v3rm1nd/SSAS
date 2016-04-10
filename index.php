<?php

function caesar($plain_text, $offset) {
	$alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$flip = array_flip($alphabet);
	$plain_text = str_split($plain_text);
	$encrypted_text = '';
	for ($i = 0; $i < count($plain_text); $i++) $encrypted_text .= $alphabet[($flip[$plain_text[$i]] + $offset) % 26];
	return $encrypted_text;
}

setcookie(caesar('MARCUSAURELIUS', 10), caesar('THESECRETPASSWORDISBLABLA', 10));

?>

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
