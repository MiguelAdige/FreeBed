<?php 

	if(isset($_POST["pseudo"])){
		//creation de la variable du pseudo pour recuperer ce que l'utilisateur a entrer dans le formulaire
		$pseudo = $_POST["pseudo"];
		//creation de la variable du mot de passe pour recuperer ce que l'utilisateur a entrer dans le formulaire
		$password = $_POST["password"];
		//requete effectuee a la base de donnee pour la connexion (on verifie que le pseudo et le mot de passe corresponde bien à un utilisateur)
		$resultat = $bdd->exec("SELECT * FROM user WHERE pseudo = ".$pseudo." AND password = ".$password."LIMIT 1;");
		
		//on verifie que la requete renvoi une valeur
		if($resultat != 0){

		}
		else{
			echo "Erreur dans le pseudo/password";
		}
	}
	
	

?>


    	<form method="POST" action="?=connexion">
    		<table>
    			<tr>
    				<td>Pseudo : </td>
    				<td><input type="text" name="pseudo"></td>
    			</tr>

    			<tr>
    				<td>Password : </td>
    				<td><input type="text" name="password"></td>
    			</tr>

    			<tr>
    				<td colspan="2"><input type="submit" value="Se connecter" name="connexion"></td>
    			</tr>

    		</table>

    	</form>

	