<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FreeBed</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
	<div class="top-area">
		<h1 class="logo left"><a href="/Freebed/"><img src="img/logo.png" alt="Tropical"></a></h1>
		<form class="right header-search" action="?p=recherche" method="post">
			<input type="text" name="recherche" placeholder="Recherche" />
			<button type="submit">Ok</button>
		</form>
		<div class="clear"></div>
	</div>

	<nav class="clear">
		<ul id="menu">
			<li><a href="?p=accueil">Accueil</a></li>
			<li><a href="?p=recherche">Recherche</a></li>
			<li><a href="?p=locations">Locations</a></li>
			<?php 
			if(!$security->logged()){
			?>
			<li><a href="?p=inscription">Inscription</a></li>
			<li><a href="?p=connexion">Connexion</a></li>
			<?php
			}
			else{
			?>
			<li><a href="?p=mes-locations">Mes Locations</a></li>
			<li><a href="?p=edit-profil">Modifier mon profil</a></li>
			<li><a href="?p=listing">Mes biens</a></li>
			<li><a href="?p=logout">Déconnexion</a></li>
			<?php
			}
			?>
		</ul>
	</nav>
	<div class="clear"></div>
</header>

<section id="content">