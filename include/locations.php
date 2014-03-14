<?php
	//requete pour voir si l'utilisateur possede un bien
	$requete = $bdd->prepare("SELECT b.id 'b.id', b.nom 'b.nom', b.type 'b.type', b.surface 'b.surface', b.tarif_week 'b.tarif_week', b.tarif_day 'b.tarif_day', i.nom 'i.nom', i.url 'i.url' 
								FROM biens b 
								LEFT JOIN images i 
									ON biens_id = b.id
								WHERE b.active = 1");

	$requete->execute();

	//Si la requete retourne des lignes alors on entre dans le 'if'
	if($requete->rowCount() != 0){


		//boucle qui affiche les biens de l'utilisateur
		while($donnees = $requete->fetch()){
			
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


		} //accolade fermante de la boucle qui affiche les biens

		$requete->closeCursor(); // termine le traitement de la requete

	} //accolade fermente du 1er 'if' pour verifier que la requete retourne des lignes
	else{
		echo "<p>Aucun bien disponible</p>";
	}
?>
<div class="clear"></div>