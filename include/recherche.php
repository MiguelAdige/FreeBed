<form method="GET" action="/FreeBed/index.php">

	<label for="type">Type : </label>
    <select name="type" id="type">
        <option value="all">Tous type</option>
        <option value="Appartement">Appartement</option>
        <option value="Gite">Gite</option>
        <option value="Chambre">Chambre</option>
    </select>

    <label for="surface">Surface : </label>
    <input type="text" id="surface" name="surface"> m²

    <label for="pays">Pays :</label>
    <select name="pays" id="pays">4
        <option value="indifferent">Indifférent</option>
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

    <label for="ville">Ville :</label>
    <input type="text" name="ville" id="ville"><br>

	Tarif par jour: Minimum <input type="number" name="tarif_day_min"> Maximum: <input type="number" name="tarif_day_max"><br/>

    Tarif par semaine: Minimum <input type="number" name="tarif_week_min"> Maximum: <input type="number" name="tarif_week_max"><br/>

	<input type="submit" name="p" value="Recherche">


</form>

<?php

if(isset($_GET['p'])){

    $sql = "SELECT * FROM biens"; // Requete de base
    $params = array(); // par défaut il n'y pas de paramettre

    // si l'une des variables ne sont pas vide on concataine le WHERE à la chaine $sql
    if (!empty($_GET['type']) || 
        !empty($_GET['surface']) || 
        !empty($_GET['pays']) || 
        !empty($_GET['ville']) || 
        !empty($_GET['tarif_day_min']) ||
        !empty($_GET['tarif_day_max']) ||
        !empty($_GET['tarif_week_min']) ||
        !empty($_GET['tarif_week_max'])) {
        
        $sql .= " WHERE ";
    }

    // si l'une des variables ne sont pas vide on concataine à la chaine $sql
    if(!empty($_GET['type'])){
        $sql .= " type = :type ";
        $params['type'] = $_GET['type'];
    }

    if (!empty($_GET['surface'])) {
        $sql .= " surface= :surface ";
        $params['surface'] = $_GET['surface'];
    }

    echo $sql;
    var_dump($params);
    die();

    $req = $bdd->prepare($sql);
    $req->execute($params);
    echo '<ul>';
    while ($donnees = $req->fetch())
    {
        echo '<li>' .$donnees['pseudo']. '</li>
              <li>' .$donnees['nom']. '</li>
              <li>' .$donnees['type']. '</li>
              <li>' .$donnees['surface']. '</li>
              <li>' .$donnees['tarif_day']. '</li>
              <li>' .$donnees['tarif_week'].'</li>';
    }
    echo '</ul>';
    $req->closeCursor();
}

?>