<?php
//will display the images the current user is an owner of
$owner = trim($_SESSION['authenticated']);
// connect to MySQL
try {
	 $dbh = new PDO("mysql:host=localhost;dbname=ssas", 'root', '0v3rm1nd');
	 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	/*** The sql statement ***/
	
	//get image based on the owner id
	$stmt = $dbh->prepare("SELECT a.id, a.image, a.image_name FROM images a WHERE owner = (SELECT b.id FROM users b WHERE b.username = ?)");                        
	$stmt->bindParam(1, $owner);
	$stmt->execute();
	//display all images of a particular owner
	while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if(sizeof($array) === 3){
			echo '<h2>Image Name: '.$array['image_name'].'</h2>';
			
			//list the people that this image is shared with
			$imageid = $array['id'];
			require('image_share_status.inc.php');

			echo '<img src="data:image/jpeg;base64,'.base64_encode($array['image']).'"/></br>';
			echo'<h3>Share image</h3>';
			//share image form
			echo '<p>Click <a href="share_image.php?iid='.$imageid.'&image_name='.$array['image_name'].'"><span>here</span></a> to share '.$array['image_name'].'!</p>';
			echo'<h3>Comment/view comments </h3>';
			//comment on image + view comments
			echo '<p>Click <a href="comment_image.php?iid='.$imageid.'&image_name='.$array['image_name'].'"><span>here</span></a> to comment on and view other comments for '.$array['image_name'].'!</p></br>';

		}else{
			throw new Exception("Out of bounds error");         
		}
	}
	
}catch(PDOException $e){
	 	echo $e->getMessage();
}catch(Exception $e){
		echo $e->getMessage();
}