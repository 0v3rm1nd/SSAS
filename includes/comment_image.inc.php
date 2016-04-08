<?php
//make a comment on a specific image
require_once('connection.inc.php');
$conn = dbConnect('write');

//make sure that the currently logged user can comment on this image
//check if it is shared
$sql = 'SELECT a.iid, b.image_name FROM image_shares a LEFT JOIN images b ON a.iid = b.id WHERE a.owner_id = (SELECT c.id FROM users c WHERE c.username = ?) AND a.iid = ? OR a.uid = (SELECT c.id FROM users c WHERE c.username = ?) AND a.iid = ?';
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('sisi',$owner,$imageid, $owner, $imageid);
$stmt->bind_result($iid,$iname);
$stmt->execute();
$stmt->fetch();

//check if you are the owner
$sql = 'SELECT id,image_name FROM images WHERE owner = (SELECT a.id FROM users a WHERE a.username = ?) and id =?';
$stmt = $conn->stmt_init();
$stmt->prepare($sql);
$stmt->bind_param('si',$owner,$imageid);
$stmt->bind_result($iid2,$iname2);
$stmt->execute();
$stmt->fetch();

//prevent temparing with the get params
if(($iid == $imageid && $image_name === $iname) || ($iid2 == $imageid && $image_name === $iname2)){

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