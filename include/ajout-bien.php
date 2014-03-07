<?php 
	// Vérifie si l'utilisateur est bien connecté
	$security->is_logged($bdd);

	//on verifie que l'utilisateur a bien rentrer toutes les informations
	if(isset($_POST["nom"])	&& isset($_POST["type"]) && isset($_POST["surface"]) && isset($_POST["adresse"]) && isset($_POST["cp"]) && isset($_POST["ville"]) && isset($_POST["pays"]) 
		&& isset($_POST["tarif_week"]) && isset($_POST["tarif_day"]) && isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["description"]) && isset($_FILES["photo"])){
		
		$photo = $_FILES["photo"];

		// Upload de l'image
		$imgSize = filesize($photo['tmp_name']);
        $imgExtension = strrchr(basename($photo['name']), '.'); // On récupère l'extension de l'image
        $imgName = time().$imgExtension; // On définie le nom final de l'image selon sont extension
        $pathUploadImg = "upload/img/";

		//On fait un tableau contenant les extensions autorisé
        $extensions = array('.jpg', '.JPG', '.jpeg', '.JPEG');


        //Ensuite on teste si l'extension de l'image est correcte
        if(in_array($imgExtension, $extensions)){
            $extensionValide = true;
        }
        else{
            $extensionValide = false;
        }

        // Vérifie si la taille de l'image ne dépasse pas la taille autorisé
        if($imgSize > 2097152){
            $sizeValide = false;
        }
        else{
            $sizeValide = true;
        }

        // Déplace l'image dans le dossier final
        if(move_uploaded_file($photo['tmp_name'], $pathUploadImg.$imgName)){
        	$moveValide = true;
        }
        else{
        	$moveValide = false;
        	echo '<div class="error">Une erreur c\'est produite lors de l\'upload</div>';
        }

        // Si $extensionValide et $sizeValide renvoi true on continue
        if($sizeValide && $extensionValide && $moveValide){
        	//requete pour la table 'adresse'
			try{
				$adresse = $bdd->prepare("INSERT INTO adresses 
											(adresse, cp, ville, pays)
											VALUES(:adresse, :cp, :ville, :pays)");
				$bdd->beginTransaction();

				$adresse->execute(array(
					":adresse"	=> $_POST["adresse"],
					":cp"		=> $_POST["cp"],
					":ville"	=> $_POST["ville"],
					":pays"		=> $_POST["pays"]
				));

				$idAdresse = $bdd->lastInsertId();
				$bdd->commit();
			}
			catch(PDOException $e){
				$bdd->rollback();
				print "Error! ".$e->getMessage()."<br/>";
			}

			//requete pour la table 'biens'
			try{
				$bien = $bdd->prepare("INSERT INTO biens(nom, type, surface, tarif_week, tarif_day, description, users_id, adresse_id) VALUES(:nom, :type, :surface, :tarif_week, :tarif_day, :description, :user, :adresse);");
				$bdd->beginTransaction();

				$bien->execute(array(
					":nom" => $_POST["nom"],
					":type" => $_POST["type"],
					":surface" => $_POST["surface"],
					":tarif_week" => $_POST["tarif_week"],
					":tarif_day"	=> $_POST['tarif_day'],
					":description" => $_POST["description"],
					":adresse" => $idAdresse,
					":user"		=> $_SESSION['user']['id']
				));

				$idBien = $bdd->lastInsertId();
				$bdd->commit();
			}
			catch(PDOException $e){
				$bdd->rollback();
					print "Error! ".$e->getMessage()."<br/>";
			}

			$disponibilité = $bdd->prepare("INSERT INTO date_disponibilites(date_debut, date_fin, biens_id) VALUES(:debut, :fin, :idBien);");
			$disponibilité->execute(array(
				":debut" => $_POST["date_debut"],
				":fin" => $_POST["date_fin"],
				":idBien" => $idBien
				));

			$image=$bdd->prepare("INSERT INTO images(nom, url, biens_id) VALUES(:nom, :url, :idBien)");
			$image->execute(array(
				":nom"=> $imgName,
				":url"=>$pathUploadImg.$imgName,
				":idBien"=> $idBien
				));
			
				echo '<div class="succes">Bien ajouté</div>';
			}
	        else{
	        	echo '<div class="error">L\'extension de l\'image est invalide ou la taille est supérieur à 2Mo</div>';
	        }
        }

?>


<form method="POST" action="?p=ajout-bien" enctype="multipart/form-data">

	<label for="nom">Nom du bien :</label>
	<input type="text" name="nom" id="nom">
	<label for="type">Type de bien :</label>
	<select name="type" id="type">
		<option value="Appartement" >Appartement</option>
		<option value="Gite">Gite</option>
		<option value="Chambre">Chambre d'hôte</option>
	</select>
	<label for="surface">Surface :</label>
	<input type="number" id="surface" name="surface">
	<label for="adresse">Adresse :</label>
	<input type="text" id="adresse" name="adresse">
	<label for="cp">Code Postal :</label>
	<input type="number" name="cp" id="cp">
	<label for="ville">Ville :</label>
	<input type="text" name="ville" id="ville">
	<label for="pays">Pays :</label>
	<select name="pays" id="pays">
		<?php
			// Tableau de tous les pays du monde
			$country = array(
				'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua And Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia And Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Columbia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D\'Ivorie (Ivory Coast)', 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Democratic Republic Of Congo (Zaire)', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard And McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar (Burma)', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'North Korea', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts And Nevis', 'Saint Lucia', 'Saint Pierre And Miquelon', 'Saint Vincent And The Grenadines', 'San Marino', 'Sao Tome And Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovak Republic', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia And South Sandwich Islands', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard And Jan Mayen', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad And Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks And Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City (Holy See)', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (US)', 'Wallis And Futuna Islands', 'Western Sahara', 'Western Samoa', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'
			);

			foreach ($country as $key => $pays) {

				echo '<option value="'.$pays.'" >'.$pays.'</option>';
			}
		?>
	</select>
	<label for="tarif_week">Prix de location par semaine :</label>
	<input type="number" id="tarif_week" name="tarif_week">
	<label for="tarif_week">Prix de location par jour :</label>
	<input type="number" id="tarif_day" name="tarif_day">
	<label for="date">Disponibilité :</label>
	Du <input type="date" id="date" name="date_debut"> au <input type="date" name="date_fin">
	<label for="description">Description :</label>
	<textarea name="description" id="description"></textarea>
	<label for="photo">Photo :</label>
	<input type="file" name="photo" id="photo"><br/>
	<button type="submit">Ajouter</button>

</form> 