<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FreeBed</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
	<?php 
	if(!$security->logged()){
	?>
	<form class="left" method="POST" action="?p=connexion"> 
		<label for="pseudo">Pseudo</label>
		<input type="text" name="pseudo"/><br/> 
		<label for="password">Password</label>
		<input type="password" name="password"/><br/> 
		<button type="submit">Se connecter</button>
	</form>
	<?php
	}
	?>

	<form class="right header-search" action="?p=recherche" method="post">
		<input type="text" name="recherche"/>
		<button type="submit">Ok</button>
	</form>

	<nav>
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
</header>

<section id="content">