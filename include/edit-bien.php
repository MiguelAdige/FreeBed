<?php 
	
	$security->is_logged($bdd);

	$req = $bdd->prepare('SELECT b.nom , b.type , b.surface , b.tarif_week , b.tarif_day , b.description , b.active 
							FROM biens b
							JOIN users u 
								ON users_id = u.id
							WHERE b.id = :id_b 
							AND u.id = :id_u 
							LIMIT 1');

	$req->execute(array(
				':id_b' => $_GET['id'],
				':id_u' => $_SESSION['user']['id'] ));

	$bien = $req->fetch(PDO::FETCH_OBJ);


	if(isset($_POST['nom']) && isset($_POST['type']) && isset($_POST['surface']) &&
		isset($_POST['tarif_day']) && isset($_POST['tarif_week']) && 
		isset($_POST['description']) && isset($_POST['active'])){

		if(!empty($_POST['nom']) && !empty($_POST['type']) && !empty($_POST['surface']) && 
		!empty($_POST['tarif_day']) && !empty($_POST['tarif_week']) && 
		!empty($_POST['description']) && !empty($_POST['active']) ) {

			$tableBien = $bdd->prepare('UPDATE biens
										SET nom = :nom,
											type = :type,
											surface = :surface,
											tarif_day = :tarif_day,
											tarif_week = :tarif_week,
											description = :description,
											active = :active 
										WHERE id = :id_bien');

			$tableBien->execute(array(
					':nom' 			 => $_POST['nom'],
					':type' 		 => $_POST['type'],
					':surface'		 => $_POST['surface'],
					':tarif_day'	 => $_POST['tarif_day'],
					':tarif_week'	 => $_POST['tarif_week'],
					':description'	 => $_POST['description'],
					':active'		 => $_POST['active'],
					':id_bien'		 => $_GET['id']			
					));

			echo '<p class="succes">Votre bien a été modifié, cliquez <a href="?p=fiche-bien&id='.$_GET['id'].'" style="color:yellow;">ici</a> pour le voir !</p>';
		}

	}
	else{
			echo '<p class="error">Veuillez remplir tous les champs</p>';
		}





?>

<form method="POST" action="?p=edit-bien&id=<?php echo $_GET['id']; ?>">
	Nom : <input type="text" name="nom" value="<?php echo $bien->nom; ?>"  required><br/>
	Type : <input type="radio" name="type" value="appartement"> Appartement <input type="radio" name="type" value="gite"> Gite <input type="radio" name="type" value="chambre"> Chambre d'hôte <br/>
	Surface : <input type="number" name="surface" value="<?php echo $bien->surface; ?>"  required> m²<br/>
	Tarif/jour : <input type="number" name="tarif_day" value="<?php echo $bien->tarif_day; ?>"  required> €<br/>
	Tarif/semaine : <input type="number" name="tarif_week" value="<?php echo $bien->tarif_week; ?>"  required> €<br/>
	Description :<br/>
	<textarea  style="width: 300px; height:100px" type="text" name="description"><?php echo $bien->description; ?></textarea><br/>
	Desactiver la location du bien : <input type="radio" name="active" value="0"> OUI <input type="radio" name="active" value="1"> NON <br/>
	<button class="block" type="submit">Modifier</button>
</form>
