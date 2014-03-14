<?php
// Vérifie si l'utilisateur est bien connecter
$security->is_logged($bdd);


// Récupère les données de l'utilisateur
$req = $bdd->prepare("
	SELECT * FROM users u 
	LEFT JOIN adresses a
		ON u.adresses_id = a.id
	WHERE u.id= :id");

$req->execute(array('id' => $_SESSION['user']['id']));

$profil = $req->fetch(PDO::FETCH_OBJ);

// Si une requete est executer
if (isset($_POST['pseudo']) && 
	isset($_POST['nom']) && 
	isset($_POST['prenom']) &&
	isset($_POST['email'])) {

	if (!empty($_POST['pseudo']) && 
		!empty($_POST['nom']) && 
		!empty($_POST['prenom']) &&
		!empty($_POST['email'])) {

		// Ont enregistre les modification de l'adresse
		$adresse = $bdd->prepare("UPDATE adresses
							SET adresse = :adresse,
							cp = :cp,
							ville = :ville,
							pays = :pays
							WHERE id=:id_adresse");
		$adresse->execute(array(
			"adresse"		=> $_POST['adresse'],
			"cp"			=> $_POST['cp'],
			"ville"			=> $_POST['ville'],
			"pays"			=> $_POST['pays'],
			"id_adresse"	=> $profil->adresses_id
		));

		// Ont enregistre les modification de l'utilisateur
		$user = $bdd->prepare("UPDATE users
 						SET pseudo = :pseudo,
 							nom = :nom,
 							prenom = :prenom,
 							email = :email
 						WHERE id=:id");
		$user->execute(array(
			"pseudo"	=> $_POST['pseudo'],
			"nom"		=> $_POST['nom'],
			"prenom"	=> $_POST['prenom'],
			"email"		=> $_POST['email'],
			"id"		=> $_SESSION['user']['id']
		));

		echo '<p class="succes">Profil modifier</p>';
	}
	else{
		echo '<p class="error">Veuillez remplir tous les champs</p>';
	}
}

?>
<a href="?p=listing" class="button">Mes locations</a>
<section class="edit-profil">

	<h1>Modifier profil</h1>

	<form action="?p=edit-profil" method="POST">
		<label for="pseudo">Pseudo</label>
		<input type="text" id="pseudo" value="<?php echo $profil->pseudo; ?>" name="pseudo" required>
		<label for="nom">Nom</label>
		<input type="text" id="nom" value="<?php echo $profil->nom; ?>" name="nom" required>
		<label for="prenom">Prénom</label>
		<input type="text" id="prenom" value="<?php echo $profil->prenom; ?>" name="prenom" required>
		<label for="email">Email</label>
		<input type="email" id="email" value="<?php echo $profil->email; ?>" name="email" required>
		<label for="adresse">Adresse</label>
		<input type="text" id="adresse" name="adresse" value="<?php echo $profil->adresse; ?>" required>
		<label for="cp">Code postal</label>
		<input type="text" id="cp" name="cp" value="<?php echo $profil->cp; ?>" required>
		<label for="ville">Ville</label>
		<input type="text" id="ville" name="ville" value="<?php echo $profil->ville; ?>" required>
		<label for="pays">Pays</label>
			<select name="pays" id="pays" required>
				<?php
				// Tableau de tous les pays du monde
				$country = array(
					'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua And Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia And Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Columbia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D\'Ivorie (Ivory Coast)', 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Democratic Republic Of Congo (Zaire)', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard And McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar (Burma)', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'North Korea', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts And Nevis', 'Saint Lucia', 'Saint Pierre And Miquelon', 'Saint Vincent And The Grenadines', 'San Marino', 'Sao Tome And Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovak Republic', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia And South Sandwich Islands', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard And Jan Mayen', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad And Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks And Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City (Holy See)', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (US)', 'Wallis And Futuna Islands', 'Western Sahara', 'Western Samoa', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'
				);

				foreach ($country as $key => $pays) {
					$selected = null;

					if($profil->pays == $pays){
						$selected = "selected";
					}

					echo '<option value="'.$pays.'" '.$selected.'>'.$pays.'</option>';
				}
				?>
			</select>
		<div class="footer"><button class="button right" type="submit">Modifier</button></div>
	</form>
</section>