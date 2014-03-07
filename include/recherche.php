<form method="POST" action="recherche.php">

	Pseudo : <input type="text" name="pseudo"><br/>
	Nom du bien : <input type="text" name="nom"><br/>
	Type : <input type="radio" name="type" value="Appartement"> Appartement 
			<input type="radio" name="type" value="gite"> Gite
			<input type="radio" name="type" value="chambre"> Chambre<br/>
	Surface : <input type="text" name="surface"> m²<br/>
	Tarif : Minimum <input type="number" name="min"> €  Maximum: <input type="number" name="max"><br/>

	<input type="submit" name="valider" name="Rechercher">


</form>