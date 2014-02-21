<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="header.css">
  <script src="script.js"></script>
</head>
<body>

	<nav method="POST" action="login.php"> 
		Login<input type="text" name="email"/><br/> 
		Password<input type="password" name="password"/><br/> 
		<input type="submit" name="submit" value="se connecter"> 
	</nav>

	<form method="get" action="/recherche.php" onsubmit="var q = $('#q').val(); if(q == 'Recherche' || q == ''){return false;}">
		<fieldset>
			<input type="text" id="q" name="q" class="search placeholder" placeholder="Recherche" value="Recherche">
			<input type="submit" name="submit_search" value="">
		</fieldset>
	</form>

	<ul id="menu_horizontal">
<li class="bouton_gauche"><a href="accueil.php">Accueil</a></li>
<li class="bouton_gauche"><a href="inscription.php">Inscription</a></li>
<li class="bouton_gauche"><a href="connexion.php">Connexion</a></li>
<li class="bouton_droite"><a href="recherche.php">Recherche</a></li>
<li class="bouton_droite"><a href="contact.php">Contact</a></li>
	</ul>

</body>
</html>