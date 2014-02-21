<?php
include_once 'bdd.php';

if (isset($_GET['p']) && preg_match("/^[a-z0-9-]+$/i",$_GET['p'])) {
	// Vérifie si le fichier existe avant inclusion
	if(file_exists('include/' . $_GET['p'] . '.php')){
		
		include_once 'header.php'; // Inclusion de l'entete de la page

		include_once 'include/' . $_GET['p'] . '.php'; // Inclusion du contenu de la page
	}
	else{// sinon renvoi une erreur 404 si le fichier n'existe pas
		header('HTTP/1.0 404 Not Found');
		header('Location:404.php');
	}
}
elseif (!isset($_GET['p'])) {
	include_once 'header.php'; // Inclusion de l'entete de la page
	
	include_once 'include/accueil.php';
}

// Inclusion du pied de page
include_once 'footer.php';
?>
