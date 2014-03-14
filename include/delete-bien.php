<?php 
	
	$security->is_logged($bdd);

			$tableBien = $bdd->prepare('DELETE FROM biens WHERE id = :id_bien AND users_id = :user_id');

			$tableBien->execute(array(
					':id_bien'	=> $_GET['id'],
					':user_id'	=> $_SESSION['user']['id']
			));

			header("Location:?p=listing");

?>