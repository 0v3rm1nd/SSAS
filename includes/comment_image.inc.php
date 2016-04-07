<?php
//make a comment on a specific image
require_once('connection.inc.php');
$conn = dbConnect('write');

//make sure that the currently logged user can comment on this image
//check if it is shared
$sql = 'SELECT iid FROM image_shares WHERE owner_id = (SELECT a.id FROM users a WHERE a.username = ?) AND iid = ? OR uid = (SELECT a.id FROM users a WHERE a.username = ?) AND iid = ?';
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('sisi',$owner,$imageid, $owner, $imageid);
$stmt->bind_result($iid);
$stmt->execute();
$stmt->fetch();
//check if you are the owrner
$sql = 'SELECT id FROM images WHERE owner = (SELECT a.id FROM users a WHERE a.username = ?) and id =?';
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('si',$owner,$imageid);
$stmt->bind_result($iid2);
$stmt->execute();
$stmt->fetch();

if($iid == $imageid || $iid2 == $imageid){

if (is_int($iid2)){
	
	$iid = $iid2;
}

// if everything is good proceed and share the image
$sql = 'INSERT INTO comments (uid, iid, image_comment) VALUES ((SELECT a.id FROM users a WHERE a.username = ?), ?, ?)';
$stmt = $conn->stmt_init();
$stmt = $conn->prepare($sql);
$stmt->bind_param('sis',$owner, $iid, $comment);
$stmt->execute();
	if ($stmt->affected_rows == 1) {
		$success = 'You successfully made a comment on '.$image_name.'';
	}else{
		$error = 'Sorry, there was a problem with the database!';
		}
}else{	
	$error = 'I know you are trying to mess with the GET parameters ;) Try again!!';
}