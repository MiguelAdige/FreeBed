<?php
class Security
{
	function is_logged()
	{
		if(isset($_SESSION['user'])){

		}
		else {
			header("Location:index.php?p=connexion");
		}
	}
}