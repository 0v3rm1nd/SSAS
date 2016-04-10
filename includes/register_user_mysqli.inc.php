<?php
require_once('./includes/CheckPassword.php');
$usernameMinChars = 6;
$errors = array();

if (strlen($username) < $usernameMinChars) {
  $errors[] = "Username must be at least $usernameMinChars characters.";
}
if (preg_match('/\s/', $username)) {
  $errors[] = 'Username should not contain spaces.';
}

$checkPwd = new Ps2_CheckPassword($password, 6);
$checkPwd->requireMixedCase();
$checkPwd->requireNumbers(1);
$checkPwd->requireSymbols();
$passwordOK = $checkPwd->check();
if (!$passwordOK) {
  $errors = array_merge($errors, $checkPwd->getErrors());
}
if ($password != $retyped) {
  $errors[] = "Your passwords don't match.";
}
if (!$errors) {
  // include the connection file
  require_once('./includes/connection.inc.php');
  $conn = dbConnect('write');
  // create a salt using the current timestamp
  $salt = time();
  // encrypt the password and salt with SHA1
  $pwd = sha1($password . $salt);
  // prepare SQL statement
  $sql = 'INSERT INTO users (username, salt, password)
          VALUES (?, ?, ?)';
  $stmt = $conn->stmt_init();
  $stmt = $conn->prepare($sql);
  // bind parameters and insert the details into the database
  $stmt->bind_param('sis',$username, $salt, $pwd);
  $stmt->execute();
  if ($stmt->affected_rows == 1) {
	$success = "$username has been registered and it is now usable. Click here to login:<a href='index.php'><span>Log In</span></a>";
  } elseif ($stmt->errno == 1062) {
	$errors[] = "Username:$username is already in use.";
  } else {
	$errors[] = 'Sorry, there was a problem with the database.';
  }
}
