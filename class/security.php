<?php
class Security
{
	function is_logged($bdd)
	{
		if(isset($_SESSION['user'])){
			$resultat = $bdd->prepare("SELECT * FROM users WHERE pseudo= :pseudo AND password= :pass LIMIT 1");
			
			$resultat->execute(array(
				":pseudo"	=> $_SESSION['user']['pseudo'],
				":pass"		=> $_SESSION['user']['password']
			));

			if($resultat->rowCount() == 0){
				$_SESSION = array();
				unset($_SESSION);
				session_destroy();
				header("Location:index.php?p=connexion");
			}

		}
		else {
			header("Location:index.php?p=connexion");
		}
	}

	function logged()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}
		else{
			return false;
		}
	}
}