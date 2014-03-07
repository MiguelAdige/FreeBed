<?php
	
	$security->is_logged($bdd);

	//requete pour voir si l'utilisateur possede un bien
	$requete = $bdd->prepare("SELECT * 
								FROM biens b 
								JOIN users u 
									ON users_id = u.id
								LEFT JOIN images i 
									ON biens_id = b.id
								WHERE users_id = :user");

	$requete->execute(array(
							":user" => $_SESSION['user']['id'] /*Mettre variable pour l'ulisateur connecté*/
							));

	//Si la requete retourne des lignes alors on entre dans le 'if'
	if($requete->rowCount() != 0){


		//boucle qui affiche les biens de l'utilisateur
		while($donnees = $requete->fetch()){
			//var_dump($donnees);
?>
				<section>
	
					<ul>
						<li>
							<img src="<?php echo $donnees['url'] ?>">
	
							Nom : <?php echo $donnees['nom']; ?> <br/>
							Type : <?php echo $donnees['type']; ?><br/>
							Surface : <?php echo $donnees['surface']; ?> m² <br/>
							Tarif : <?php echo $donnees['tarif']; ?> <br/>
							Description : <?php echo $donnees['description']; ?> <br/>						
	
	
						</li>
					</ul>
	
				</section>

<?php


		} //accolade fermante de la boucle qui affiche les biens

		$requete->closeCursor(); // termine le traitement de la requete

	} //accolade fermente du 1er 'if' pour verifier que la requete retourne des lignes
	else{
		echo "<p>Vous n'avez encore aucun bien</p>";
	}
?>
