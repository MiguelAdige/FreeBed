<?php

// Si une requete est executer
if (isset($_POST['pseudo']) && 
	isset($_POST['nom']) && 
	isset($_POST['prenom']) &&
	isset($_POST['email'])) {

	if (!empty($_POST['pseudo']) && 
		!empty($_POST['nom']) && 
		!empty($_POST['prenom']) &&
		!empty($_POST['email'])) {

		// Ont enregistre
		$save = $bdd->prepare("UPDATE users
 						SET pseudo = :pseudo,
 							nom = :nom,
 							prenom = :prenom,
 							email = :email
 						WHERE id=:id");
		$save->execute(array(
			"pseudo"	=> $_POST['pseudo'],
			"nom"		=> $_POST['nom'],
			"prenom"	=> $_POST['prenom'],
			"email"		=> $_POST['email'],
			"id"		=> $_SESSION['user']['id']
		));

		echo '<p class="success">Profil modifier</p>';
	}
	else{
		echo '<p class="error">Veuillez remplir tous les champs</p>';
	}
}

// Récupère les données de l'utilisateur
$req = $bdd->prepare("SELECT * FROM users WHERE id= :id LIMIT 1");
$req->execute(array('id' => $_SESSION['user']['id']));

$profil = $req->fetch(PDO::FETCH_OBJ);
?>

<h1>Editer profil</h1>

<form action="?p=edit-profil" method="POST">
	<label for="pseudo">Pseudo</label>
	<input type="text" value="<?php echo $profil->pseudo; ?>" name="pseudo" required>
	<label for="nom">Nom</label>
	<input type="text" value="<?php echo $profil->nom; ?>" name="nom" required>
	<label for="prenom">Prénom</label>
	<input type="text" value="<?php echo $profil->prenom; ?>" name="prenom" required>
	<label for="email">Email</label>
	<input type="email" value="<?php echo $profil->email; ?>" name="email" required>
	<button type="submit">Modifier</button>
</form>