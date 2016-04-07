<?php
$user = trim($_SESSION['authenticated']);

//get image based on the owner id
$stmt = $dbh->prepare("SELECT a.id, a.image, a.image_name, b.owner_id FROM images a LEFT JOIN image_shares b ON a.id = b.iid WHERE b.uid =(SELECT id FROM users WHERE username = ?)");                        
$stmt->bindParam(1, $user);
$stmt->execute();

//display all images of a particular owner
while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
	if(sizeof($array) === 4){
		echo '<p>Image Name: '.$array['image_name'].'</p>';
		//get owner username
		$sth = $dbh->prepare("SELECT username FROM users WHERE id = ?");                        
		$sth->bindParam(1, $array['owner_id']);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		echo '<p>Owner: '.$result['username'].'</p>';
		echo '<img src="data:image/jpeg;base64,'.base64_encode($array['image']).'"/>';
		
		echo'<h3>Comment/view comments </h3>';
		//comment on image + view comments
		echo '<p>Click <a href="comment_image.php?iid='.$array['id'].'&image_name='.$array['image_name'].'"><span>here</span></a> to comment on and view other comments for '.$array['image_name'].'!</p></br>';

	}else{

		throw new Exception("Out of bounds error");         
	}
}