<?php
//share an image with a particular user
require_once('connection.inc.php');
$conn = dbConnect('write');

//verify that the typed username is valid
$sql = 'SELECT id, username FROM users WHERE username = ?';
// initialize and prepare statement
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
// bind the input parameter
$stmt->bind_param('s', $username);
$stmt->bind_result($uid,$uname);
$stmt->execute();
$stmt->fetch();

//make sure that such a user exists
if ($uname===$username) {
	//make sure that the currently logged user is the owner of the image that will be shared
	$sql = 'SELECT b.id, b.image_name, b.owner FROM images b WHERE b.id =? AND b.owner = (SELECT a.id FROM users  a WHERE a.username = ?) ';
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('is', $imageid, $owner);
	$stmt->bind_result($iid,$iname,$ownerid);
	$stmt->execute();
	$stmt->fetch();
	//make sure that the user can not temper with the GET parameters
	if($iid == $imageid && $iname === $image_name){
		//make sure there are not duplicate entries
		$sql = 'SELECT iid FROM image_shares WHERE owner_id =? AND uid =? AND iid=?';
		$stmt = $conn->stmt_init();
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('iii',$ownerid, $uid, $iid);
		$stmt->bind_result($id);
		$stmt->execute();
		$stmt->fetch();
		if($id == $iid){
			$error = 'Image '.$iname.' is already shared with user '.$uname.'';	
		}else{
		//if everything is good proceed and share the image
		$sql = 'INSERT INTO image_shares (owner_id, uid, iid) VALUES (?, ?, ?)';
		$stmt = $conn->stmt_init();
 		$stmt = $conn->prepare($sql);
 		$stmt->bind_param('iii',$ownerid, $uid, $iid);
		$stmt->execute();
		if ($stmt->affected_rows == 1) {
			$success = 'You successfully shared image '.$iname.' with user '.$uname.'';
		}else{
			$error = 'Sorry, there was a problem with the database.!';
			}
		}
	}else{

		$error = 'I know you are trying to mess with the GET parameters ;) Try again!!';
	}

  } else{
  	$error = 'The user '.$username.' does not exist!';
  }