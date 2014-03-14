<?php
	
	$security->is_logged($bdd);

	//requete pour voir si l'utilisateur possede un bien
	$requete = $bdd->prepare("SELECT b.id 'b.id', b.nom 'b.nom', b.type 'b.type', b.surface 'b.surface', b.tarif_week 'b.tarif_week', b.tarif_day 'b.tarif_day', b.active 'b.active', i.nom 'i.nom', i.url 'i.url' 
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

		echo '<table border="1">
					<tr>
						<th>Nom</th>
						<th>Etat</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>';

		//boucle qui affiche les biens de l'utilisateur
		while($donnees = $requete->fetch()){
			if($donnees['b.active'] == 1){
				$etat = "Activé";
			}
			else {
				$etat = "Désactivé";
			}

			echo '
					
					<tr>
						<td><a href="?p=fiche-bien&id='.$donnees['b.id'].'">'.$donnees['b.nom'].'</a></td>
						<td>'.$etat.'</td>
						<td><a href="?p=edit-bien&id='.$donnees['b.id'].'">Modifier</a></td>
						<td><a href="?p=delete-bien&id='.$donnees['b.id'].'">Supprimer</a></td>
					</tr>
				';


		} //accolade fermante de la boucle qui affiche les biens
		echo '</table>';
		$requete->closeCursor(); // termine le traitement de la requete

	} //accolade fermente du 1er 'if' pour verifier que la requete retourne des lignes
	else{
		echo "<p>Vous n'avez encore aucun bien</p>";
	}
?>
<div class="clear"></div>

