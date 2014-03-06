<?php
	
	$security->isLogged();

	//requete pour voir si l'utilisateur possede un bien
	$requete = $bdd->prepare('SELECT u.id, b.id  
								FROM users u
								JOIN biens b
									ON u.id = b.users_id
								WHERE pseudo = ":pseudo"');
	$requete->execute(array(
							":pseudo" => "aaa"/*Mettre variable pour l'ulisateur connecté*/
							));

	//Si la requete retourne des lignes alors on entre dans le 'if'
	if($requete->rowCount() != 0){


		$biens = $bdd->query('SELECT *
							FROM biens');

		//boucle qui affiche les biens de l'utilisateur : tant que le compteur est inférieur au nb de lignes de la requete
		while($donnees = $biens->fetch()){

?>
				<section>
	
					<ul>
						<li>
							<img src="#">
	
							Nom : <?php echo $donnees['nom']; ?> <br/>
							Type : <?php echo $donnees['type']; ?><br/>
							Surface : <?php echo $donnees['surface']; ?> <br/>
							Tarif : <?php echo $donnees['tarif']; ?> <br/>
							Description : <?php echo $donnees['description']; ?> <br/>
							
	
	
						</li>
					</ul>
	
				</section>

<?php

			$compteur++; //incrementation du compteur

		} //accolade fermante de la boucle qui affiche les biens

	} //accolade fermente du 1er 'if' pour verifier que la requete retourne des lignes
	else{
		echo "<p>Vous n'avez encore aucun bien</p>";
	}
?>
