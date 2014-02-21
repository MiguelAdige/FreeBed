<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

	<nav method="POST" action="?p=connexion"> 
		Pseudo<input type="text" name="pseudo"/><br/> 
		Password<input type="password" name="password"/><br/> 
		<input type="submit" name="submit" value="Se connecter"> 
	</nav>

	<form method="get" action="/recherche.php" onsubmit="var q = $('#q').val(); if(q == 'Recherche' || q == ''){return false;}">
		<fieldset>
			<input type="text" id="q" name="q" class="search placeholder" placeholder="Recherche" value="Recherche">
			<input type="submit" name="submit_search" value="Ok">
		</fieldset>
	</form>

	<ul id="menu_horizontal">
<li class="bouton_gauche"><a href="?p=accueil">Accueil</a></li>
<li class="bouton_gauche"><a href="?p=inscription">Inscription</a></li>
<li class="bouton_gauche"><a href="?p=connexion">Connexion</a></li>
<li class="bouton_droite"><a href="?p=recherche">Recherche</a></li>
<li class="bouton_droite"><a href="?p=contact">Contact</a></li>
	</ul>

</body>
</html>