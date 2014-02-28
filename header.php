<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FreeBed</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
	<form class="left" method="POST" action="?p=connexion"> 
		<label for="pseudo">Pseudo</label>
		<input type="text" name="pseudo"/><br/> 
		<label for="password">Password</label>
		<input type="password" name="password"/><br/> 
		<button type="submit" name="submit">Se connecter</button>
	</form>

	<form class="right" action="?p=recherche" method="post">
		<input type="text" name="recherche"/>
		<button type="submit">Ok</button>
	</form>

	<nav>
		<ul id="menu">
			<li class="bouton_gauche"><a href="?p=accueil">Accueil</a></li>
			<li class="bouton_gauche"><a href="?p=inscription">Inscription</a></li>
			<li class="bouton_gauche"><a href="?p=connexion">Connexion</a></li>
			<li class="bouton_droite"><a href="?p=recherche">Recherche</a></li>
			<li class="bouton_droite"><a href="?p=contact">Contact</a></li>
		</ul>
	</nav>
</header>

<section id="content">