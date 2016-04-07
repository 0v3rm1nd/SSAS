<?php
if (isset($_POST['create'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['pwd']);
    $retyped = trim($_POST['conf_pwd']);
    require_once('./includes/register_user_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Create User</title>
    </head>

    <body>
        <div id="allcontent">

            <div id="header">
                
            </div>

            <!-- RegisterUserForm -->
            <div id="register">
				
                                <form id="registerform" method="post" action="">

                                    <h1>Create User</h1>
                                    <?php
                                    if (isset($success)) {
                                        echo "<p>$success</p>";
                                    } elseif (isset($errors) && !empty($errors)) {
                                        echo '<p><ul>';
                                        foreach ($errors as $error) {
                                            echo "<li>$error</li>";
                                        }
                                        echo '</ul></p>';
                                    }
                                    ?>
                                    <p>
                                        <label for="username" data-icon="u" > Username</label>
                                        <input id="username" name="username" required type="text" placeholder="Fill in username">
                                    </p>

                                    <p>
                                        <label for="pwd" class="youpasswd" data-icon="p"> User password </label>
                                        <input type="password" name="pwd" id="pwd" required placeholder="Fill in user password">
                                    </p>
                                    <p>
                                        <label for="conf_pwd" class="youpasswd" data-icon="p"> Confirm password </label>
                                        <input type="password" name="conf_pwd" id="conf_pwd" required placeholder="Retype user password">
                                    </p>    

                                    <p>
                                        <input name="create" type="submit"  value="Create User">
                                    </p> 
                                </form> 
            </div>

            <div id="footer">

            </div>
        </div>
    </body>
</html>
