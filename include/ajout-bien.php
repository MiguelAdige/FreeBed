<?php 
	// Vérifie si l'utilisateur est bien connecté
	$security->is_logged();


	//on verifie que l'utilisateur a bien rentrer toutes les informations
	if(isset($_POST["nom"])	&& isset($_POST["type"]) && isset($_POST["adresse"]) && isset($_POST["cp"]) && isset($_POST["ville"]) && isset($_POST["pays"]) 
		&& isset($_POST["tarif"])	&& isset($_POST["debut"]) && isset($_POST["fin"]) && isset($_POST["description"]) && isset($_POST["photo"])){
		$nom = $_POST["nom"];
		$type = $_POST["type"];
		$adresse = $_POST["adresse"];
		$cp = $_POST["cp"];
		$ville = $_POST["ville"];
		$pays = $_POST["pays"];
		$tarif = $_POST["tarif"];
		$debut = $_POST["debut"];
		$fin = $_POST["fin"];
		$photo = $_FILES["photo"];
		$upload = "../upload";
		$uploadName = date();
		move_uploaded_file($_FILES["photo"], $uploadName);
	

		//requete pour la table 'adresse'
		try{
			$adresse = $bdd->prepare("INSERT INTO adresses(adresse, cp, ville, pays) VALUES(:adresse, :cp; :ville; :pays);");
			$bdd -> beginTransaction();

			$adresse->execute(array(
				":adresse" => $adresse,
				":cp" => $cp,
				":ville" => $ville,
				":pays" => $pays,
				));
			$idAdresse->lastInsertId();
			$bdd->commit();
		}
		catch(PDOExecption $e){
			$bdd->rollback();
			print "Error! ".$e->getMessage()."<br/>";
		}

		//requete pour la table 'biens'
		try{
			$bien = $bdd->prepare("INSERT INTO biens(nom, type, surface, tarif, description, adresses_id) VALUES(:nom, :type, :surface, :tarif, :description, :adresse);");
			$bdd->beginTransaction();

			$bien->execute(array(
				":nom" => $nom,
				":type" => $type,
				":surface" => $surface,
				":tarif" => $tarif,
				":description" => $descritption,
				":adresse" => $idAdresse,
				));

			$idBien->lastInsertId();
			$bdd->commit();
		}
		catch(PDOExecption $e){
			$bdd->rollback();
				print "Error! ".$e->getMessage()."<br/>";
		}

		$disponibilitees = $bdd->prepare("INSERT INTO date_disponibilites(date_debut, date_fin, biens_id) VALUES(:debut, :fin, :idBien);");
		$disponibilitees->execute(array(
			":debut" => $debut,
			":fin" => $fin,
			":idBien" => $idBien,
			));

		$image=$bdd->prepare("INSERT INTO images(nom, url, biens_id) VALUES(:nom, :url, :idBien)");
		$image->execute(array(
			":nom"=> $uploadName,
			":url"=>$photo,
			"idBien"=>$idBien,
			));
		
		}


?>


<form method="POST" action="?p=ajout-bien" enctype="multipart/form-data">

	Nom du bien : <input type="text" name="nom" >
	Type de bien : 	<select name="type">
						<option value="appartement" name="appartement">Appartement</option>
						<option value="gite" name="gite">Gite</option>
						<option value="chambre" name="chambre">Chambre d'hôte</option>
					</select><br/>

	Adresse : <input type="text" name="adresse"><br/>
	Code Postal : <input type="text" name="cp"><br/>
	Ville : <input type="text" name="ville"><br/>
	Pays : <input type="text" name="pays"><br/>
	Prix de location : <input type="text" name="tarif"><br/>
	Disponibilitées : Du <input type="date" name="debut"> au <input type="date" name="fin"><br/>
	Description : <textarea name="description"></textarea>
	Photos : <input type="file" name="photo"><br/>
	<input type="submit" Value="Ajouter" name="ajout">

</form> 