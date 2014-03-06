<?php
session_start();

try{
	//On se connecte a MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=freebed','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
	//Si erreur, on affiche un message
	die('Erreur : '.$e->getMessage());
}

?>