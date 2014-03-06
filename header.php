<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FreeBed</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
	<h1 class="logo left"><a href="/Freebed/">Tropical</a></h1>
	<form class="right header-search" action="?p=recherche" method="post">
		<input type="text" name="recherche"/>
		<button type="submit">Ok</button>
	</form>

	<nav class="clear">
		<ul id="menu">
			<li><a href="?p=accueil">Accueil</a></li>
			<li><a href="?p=recherche">Recherche</a></li>
			<li><a href="?p=contact">Contact</a></li>
			<?php 
			if(!$security->logged()){
			?>
			<li><a href="?p=inscription">Inscription</a></li>
			<li><a href="?p=connexion">Connexion</a></li>
			<?php
			}
			else{
			?>
			<li><a href="?p=logout">Déconnexion</a></li>
			<?php
			}
			?>
		</ul>
	</nav>
	<div class="clear"></div>
</header>

<section id="content">