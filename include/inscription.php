<?php
if(isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password'])){

	$pseudo = $_POST['pseudo'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$password = sha1($_POST['password']); // Hache du mot de passe
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];


	// Vériffie si l'utilisateur n'existe pas déjà en base avec l'email
	$req = $bdd->prepare("SELECT email FROM users WHERE email= :email LIMIT 1");
	$req->execute(array('email' => $email));

	if($req->rowCount() != 1){

		try{
			$insert_adresse = $bdd->prepare("INSERT INTO adresses 
										(adresse, cp, ville, pays)
										VALUES(:adresse, :cp, :ville, :pays)");
			$bdd->beginTransaction();

			$insert_adresse->execute(array(
				"adresse"	=> $adresse,
				"cp"		=> $cp,
				"ville"		=> $ville,
				"pays"		=> $pays));

			$idAdresse = $bdd->lastInsertId(); // On récupère l'id de l'adresse pour l'insérer dans la table users
			$bdd->commit();
		}
		catch(PDOExecption $e) { 
	        $bdd->rollback(); 
	        print "Error!: " . $e->getMessage() . "</br>"; 
    	} 

		$req = $bdd->prepare("INSERT INTO users 
								(pseudo, nom, prenom, email, password, bailleur, adresses_id) 
								VALUES(:pseudo, :nom, :prenom, :email, :password, :bailleur, :id_adresse)");
		$req->execute(array(
			'pseudo'		=> $pseudo,
			'nom'			=> $nom,
			'prenom'		=> $prenom,
			'email' 		=> $email,
			'password'		=> $password,
			'bailleur'		=> 0,
			"id_adresse"	=> $idAdresse
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
<section class="inscription">

	<form method="POST" action="?p=inscription">
		<fieldset>
			<legend>Utilisateur</legend>
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
		</fieldset>
		<fieldset>
			<legend>Vos coordonnées</legend>
		<label for="adresse">Adresse</label>
		<input type="text" name="adresse" id="adresse" required>
		<label for="cp">Code postal</label>
		<input type="text" name="cp" id="cp" required>
		<label for="ville">Ville</label>
		<input type="text" name="ville" id="ville" required>
		<label for="pays">Pays</label>
		<select name="pays" id="pays" required>
			<?php
			// Tableau de tous les pays du monde
			$country = array(
				'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua And Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia And Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Columbia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D\'Ivorie (Ivory Coast)', 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Democratic Republic Of Congo (Zaire)', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard And McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar (Burma)', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'North Korea', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts And Nevis', 'Saint Lucia', 'Saint Pierre And Miquelon', 'Saint Vincent And The Grenadines', 'San Marino', 'Sao Tome And Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovak Republic', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia And South Sandwich Islands', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard And Jan Mayen', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad And Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks And Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City (Holy See)', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (US)', 'Wallis And Futuna Islands', 'Western Sahara', 'Western Samoa', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'
			);

			foreach ($country as $key => $pays) {
				echo '<option value="'.$pays.'">'.$pays.'</option>';
			}
			?>
		</select>
		</fieldset>
		<div class="footer"><button class="block" type="submit">S'inscrire</button></div>
	</form>	
</section>