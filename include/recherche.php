<form method="GET" action="/FreeBed/index.php">

	<label for="type">Type : </label>
    <select name="type" id="type">
        <option value="">Tous type</option>
        <option value="Appartement">Appartement</option>
        <option value="Gite">Gite</option>
        <option value="Chambre">Chambre</option>
    </select>

    <label for="surface">Surface : </label>
    <input type="text" id="surface" name="surface"> m²

    <label for="pays">Pays :</label>
    <select name="pays" id="pays">4
        <option value="">Indifférent</option>
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

if(isset($_GET['p']) && !empty($_GET['type']) || 
        !empty($_GET['surface']) || 
        !empty($_GET['pays']) || 
        !empty($_GET['ville']) || 
        !empty($_GET['tarif_day_min']) ||
        !empty($_GET['tarif_day_max']) ||
        !empty($_GET['tarif_week_min']) ||
        !empty($_GET['tarif_week_max'])){

    $sql = "SELECT b.id 'b.id', b.nom 'b.nom', b.type 'b.type', b.surface 'b.surface', b.tarif_week 'b.tarif_week', b.tarif_day 'b.tarif_day', i.nom 'i.nom', i.url 'i.url' FROM biens b
            JOIN adresses a
                ON b.adresse_id = a.id
            LEFT JOIN images i
                ON b.id=i.biens_id"; // Requete de base
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
    $getSQL = array(
        'type'              => $_GET['type'],
        'surface'           => $_GET['surface'],
        'pays'              => $_GET['pays'],
        'ville'             => $_GET['ville'],
        'tarif_day_min'     => $_GET['tarif_day_min'],
        'tarif_day_max'     => $_GET['tarif_day_max'],
        'tarif_week_min'    => $_GET['tarif_week_min'],
        'tarif_week_max'    => $_GET['tarif_week_max']
    );

    $i = 1;
    $itarif = 0;
    $itarif_day = 0;
    $itarif_week =0;
    $passe_tarif_day = false;
    

    foreach ($getSQL as $key => $value) {

        $i++;
        if (!empty($_GET[$key])) {
        
            $params[$key] = $value;
        }

        if(!empty($_GET[$key]) && $i <= 4){
            $and = null;
            $max = sizeof($getSQL);

            if($i > 1 && $i <= $max){
                $and = "AND";
            }

            $sql .= " ".$key." = :".$key." ".$and;
        }


        if($i >= 5 && $itarif_day <= 0){
            $itarif_day++;
                // Tarif par jour minimum
                if (!empty($getSQL['tarif_day_min'])) {
                    $tarif_day_min = ":tarif_day_min";
                }
                else{
                    $tarif_day_min = "''";
                }
                // Tarif par jour max
                if (!empty($getSQL['tarif_day_max'])) {
                    $tarif_day_max = ":tarif_day_max";
                }
                else{
                    $tarif_day_max = "''";
                }

                if(!empty($getSQL['tarif_day_min']) || !empty($getSQL['tarif_day_max'])){
                    $sql .= " tarif_day BETWEEN ".$tarif_day_min." AND ".$tarif_day_max."";
                    
                    $passe_tarif_day = true;
                }
        }

        if($passe_tarif_day == true && $itarif <= 0){
            $itarif++;
            $sql .=  " OR ";
        }

        if($i >= 7 && $itarif_week <= 0){
            $itarif_week++;
            // Tarif par semaine minimum
                if (!empty($getSQL['tarif_week_min'])) {
                    $tarif_week_min = ":tarif_week_min";
                }
                else{
                    $tarif_week_min = "''";
                }
                // Tarif par semaine max
                if (!empty($getSQL['tarif_week_max'])) {
                    $tarif_week_max = ":tarif_week_max";
                }
                else{
                    $tarif_week_max = "''";
                }

            if (!empty($getSQL['tarif_week_min']) || !empty($getSQL['tarif_week_max'])) {
                $sql .= " tarif_week BETWEEN ".$tarif_week_min." AND ".$tarif_week_max."";

            }
        }

    }

    $sql = rtrim($sql, " AND");
    

    $req = $bdd->prepare($sql);
    $req->execute($params);
    while ($donnees = $req->fetch())
    {
        echo '<article class="item">
                <figure>
                    <a href="?p=fiche-bien&id='.$donnees['b.id'].'" title="'.$donnees['b.nom'].'">';
                        if($donnees['i.url'] != null){
                            echo '<img src="'.$donnees['i.url'].'" alt="">';
                        }
                        else{
                            echo '<img src="img/no-image.png" alt="">';
                        }
                echo '
                    </a>
                </figure>
                <div class="details">
                    <h3>'.$donnees['b.nom'].'</h3>
                    <ul>
                        <li>Type : '.$donnees['b.type'].'</li>
                        <li>Surface : '.$donnees['b.surface'].'m²</li>
                        <li>Tarif par semaine : '.$donnees['b.tarif_week'].'€</li>
                        <li>Tarif par jour : '.$donnees['b.tarif_day'].'€</li>
                    </ul>
                </div>
            </article>';
    }
    $req->closeCursor();
}

?>

<div class="clear"></div>