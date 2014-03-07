<?php
	
	$security->is_logged($bdd);

	//requete pour voir si l'utilisateur possede un bien
	$requete = $bdd->prepare("SELECT * 
								FROM biens b
								JOIN images i
									ON b.id = i.id
								WHERE users_id = :user");

	$requete->execute(array(
							":user" => $_SESSION['user']['id'] /*Mettre variable pour l'ulisateur connecté*/
							));

	//Si la requete retourne des lignes alors on entre dans le 'if'
	if($requete->rowCount() != 0){


		//boucle qui affiche les biens de l'utilisateur : tant que le compteur est inférieur au nb de lignes de la requete
		while($donnees = $requete->fetch()){
			
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

		} //accolade fermante de la boucle qui affiche les biens

	} //accolade fermente du 1er 'if' pour verifier que la requete retourne des lignes
	else{
		echo "<p>Vous n'avez encore aucun bien</p>";
	}
?>
