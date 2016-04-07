<?php
//make a comment on a specific image
require_once('connection.inc.php');
$conn = dbConnect('write');
$owner = trim($_SESSION['authenticated']);

//make sure that the currently logged user can view the image comments
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

//get all the comments for this image
if($iid == $imageid || $iid2 == $imageid){

if (is_int($iid2)){
	
	$iid = $iid2;
}
	$sql = 'SELECT a.image_comment, b.username FROM comments a LEFT JOIN users b ON a.uid = b.id WHERE a.iid = ?';
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $iid);
	$stmt->execute();
	$stmt->bind_result($image_comment, $username);
	while($stmt->fetch()){
		echo '<p>'.$username.':'.$image_comment.'</p>';
	}

}else{	
	$error = 'I know you are trying to mess with the GET parameters ;) Try again!!';
}
