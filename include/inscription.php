<?php
if(isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password'])){

	$pseudo = $_POST['pseudo'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$password = sha1($_POST['password']); // Hache du mot de passe

	// Vériffie si l'utilisateur n'existe pas déjà en base avec l'email
	$req = $bdd->prepare("SELECT email FROM users WHERE email= :email LIMIT 1");
	$req->execute(array('email' => $email));

	if($req->rowCount() != 1){

		$req = $bdd->prepare("INSERT INTO users 
								(pseudo, nom, prenom, email, password, bailleur) 
								VALUES(:pseudo, :nom, :prenom, :email, :password, :bailleur)");
		$req->execute(array(
			'pseudo'	=> $pseudo,
			'nom'		=> $nom,
			'prenom'	=> $prenom,
			'email' 	=> $email,
			'password'	=> $password,
			'bailleur'	=> 0
		));

		if($req->rowCount() != 0){ // Vérifie si l'utilisateur est bien enregistrer

			echo '<div class="succes">Super vous etes inscrit !</div>';
		}
		else{
			echo '<div class="error">Une erreur c\'est produite.</div>';
		}
		
	}
	else{
		echo '<div class="error">Cette adresse email existe déjà.</div>';
	}

}
?>

<form method="POST" action="?p=inscription">
	<label for="pseudo">Pseudo</label>
	<input type="text" name="pseudo" id="pseudo" required>
	<label for="nom">Nom</label>
	<input type="text" name="nom" id="nom" required>
	<label for="prenom">Prénom</label>
	<input type="text" name="prenom" id="prenom" required>
	<label for="email">Email</label>
	<input type="email" name="email" id="email" required>
	<label for="password">Mot de passe</label>
	<input type="password" name="password" id="password" required>
	<button type="submit">S'inscrire</button>
</form>