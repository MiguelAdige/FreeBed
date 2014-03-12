<form method="POST" action="recherche.php">

	Pseudo : <input type="text" name="pseudo"><br/>
	Nom du bien : <input type="text" name="nom"><br/>
	Type : <input type="radio" name="type" value="Appartement"> Appartement 
			<input type="radio" name="type" value="gite"> Gite
			<input type="radio" name="type" value="chambre"> Chambre<br/>
	Surface : <input type="text" name="surface"> m²<br/>
	Tarif : Minimum <input type="number" name="tarifday"> €  Maximum: <input type="number" name="tarifweek"><br/>

	<input type="submit" name="valider" name="Rechercher">


</form>

<?php

$req = $bdd->prepare('SELECT pseudo, nom, type, surface, tarif_day, tarif_week FROM biens WHERE pseudo = :pseudo AND nom = :nom AND type = :type AND surface =:surface AND tarif_day >= :tarifmin AND tarif_week <= :tarifmax ORDER BY visites DESC');
$req->execute(array(
    'pseudo'   => $_POST['pseudo'],
    'nom' 	   => $_POST['nom'],
    'type'     => $_POST['type'],
    'surface'  => $_POST['surface'],
    'tarifmin' => $_POST['tarifday'],
    'tarifmax' => $_POST['tarifweek']));
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

?>