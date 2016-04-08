<?php
//make a comment on a specific image
require_once('connection.inc.php');
$conn = dbConnect('read');

$owner = trim($_SESSION['authenticated']);

//make sure that the currently logged user can view the image comments
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

//prevet GET param tampering
if(($iid == $imageid && $image_name === $iname) || ($iid2 == $imageid && $image_name === $iname2)){

if (is_int($iid2)){
	
	$iid = $iid2;
}
	//list all the comments for this image
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
