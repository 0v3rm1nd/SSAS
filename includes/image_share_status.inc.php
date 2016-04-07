<?php
//list the people that this image is shared with
try {
	 $stmt2 = $dbh->prepare("SELECT a.username FROM users a WHERE a.id IN (SELECT b.uid FROM image_shares b WHERE b.iid = ? AND b.owner_id IN (SELECT c.id FROM users c WHERE c.username = ?))");
	 $stmt2->bindParam(1, $imageid);
	 $stmt2->bindParam(2, $owner);
	 $stmt2-> execute();
	 
	$shares = '';
	while ($result = $stmt2->fetch(PDO::FETCH_ASSOC)) {
		   $shares = $shares . $result['username']. '; ';
	}

	echo '<p>'.$array['image_name'].' is shared with: '.$shares.'</p>';

}catch(PDOException $e){
	 	echo $e->getMessage();
}catch(Exception $e){
		echo $e->getMessage();
}