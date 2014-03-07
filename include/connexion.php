<?php 

	if(isset($_POST["pseudo"]) && isset($_POST['password'])){
		if(!empty($_POST['pseudo']) && !empty($_POST['password'])){
			//creation de la variable du pseudo pour recuperer ce que l'utilisateur a entrer dans le formulaire
			$pseudo = $_POST["pseudo"];
			//creation de la variable du mot de passe pour recuperer ce que l'utilisateur a entrer dans le formulaire
			$password = sha1($_POST["password"]);
			//requete effectuee a la base de donnee pour la connexion (on verifie que le pseudo et le mot de passe corresponde bien à un utilisateur)
			$resultat = $bdd->prepare("SELECT * FROM users WHERE pseudo= :pseudo AND password= :pass LIMIT 1");
			$resultat->execute(array(
				":pseudo"	=> $pseudo,
				":pass"		=> $password
			));
			
			//on verifie que la requete renvoi une valeur
			
			if($resultat->rowCount() != 0){
				$user = $resultat->fetchAll();
				$_SESSION['user'] = $user[0];
				header("Location:/FreeBed/index.php?p=edit-profil");
			}
			else{
				echo "Erreur dans le pseudo/password";
			}
		}
		else{
			echo "Vous n'avez pas remplie tous les champs obligatoire";
		}
	}
?>

    		<form name="login-form" class="login-form" action="?p=connexion" method="POST">
	
		<div class="header">
		<h1>CONNEXION</h1>
		<span>Vueillez saisir votre pseudo et votre mot de passe </span>
		</div>
	
		<div class="content">
		<input name="pseudo" type="text" class="input username" placeholder="Pseudo" required/>
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="Password" required/>
		<div class="pass-icon"></div>		
		</div>

		<div class="footer">
		<input type="submit" name="submit" value="Se connecter" class="button" />
		</div>
	
	</form>

	