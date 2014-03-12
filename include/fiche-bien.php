<?php
// On vérifie si l'ip n'est pas déjà dans la table ip_vues depuis plus de 24h
$time24h = time() - 3600*24;

$ip_vues = $bdd->prepare("SELECT * FROM ip_vues WHERE ip=:ip AND biens_id=:id AND date < :date24h");

$ip_vues->execute(array(
	'ip'	=> $_SERVER['REMOTE_ADDR'],
	'id'	=> $_GET['id'],
	'date24h'	=> date('Y-d-m', $time24h)
	));

if($ip_vues->rowCount() == 0){

	$bien = $bdd->prepare('SELECT id,visites FROM biens WHERE id=:id');
	$bien->execute(array(
		'id'	=> $_GET['id']));

	$reqBien = $bien->fetch();

	$nbr_de_vue = $reqBien['visites']+1;

	// Mise à jour du nombre de vue
	$maj_vues = $bdd->prepare("UPDATE biens SET visites=:nbr_vue WHERE id=:id_bien");

	$maj_vues->execute(array(
		'nbr_vue' => $nbr_de_vue,
		'id_bien' => $_GET['id']
	));

	// Et on met l'ip dans la table ip_vues
	
	$insert_ip = $bdd->prepare("INSERT INTO ip_vues (ip, date, biens_id) VALUES (? , ?, ?)");

	$insert_ip->execute(array($_SERVER['REMOTE_ADDR'], date('Y-d-m', time()), $_GET['id']));
}

// Ont récupère le bien pour l'afficher
// 
$biens = $bdd->prepare("SELECT b.id,b.nom,b.type,b.surface,b.tarif_week,b.tarif_day,b.description,b.visites,a.adresse,a.cp,a.ville,a.pays,au.adresse adresse_user,au.cp cp_user,au.ville ville_user,au.pays pays_user,i.url,u.pseudo,u.nom nom_user,u.prenom FROM biens b
					LEFT JOIN images i
						ON b.id=i.biens_id
					LEFT JOIN adresses a
						ON b.adresse_id=a.id
					LEFT JOIN adresses au
						ON b.users_id=au.id
					LEFT JOIN users u
						ON b.users_id=u.id
					WHERE b.id= ? AND active=1
					LIMIT 1");

$biens->execute(array($_GET['id']));

$bien = $biens->fetch();
?>

<article class="bien left">
	<h1><?php echo $bien['nom'];?></h1>
	<hr>
	<div class="image">
		<?php 
		if($bien['url'] != null){
			echo '<img src="'.$bien['url'].'" alt="photo du bien">';
		}
		else{
			echo '<img src="upload/img/no-image.png" alt="pas de photo du bien">';
		}
	?>
	</div>
	<aside class="info-bien">
		<div class="date-dispo">
			<h3>Date de disponibilité(es)</h3>
			<ul>
				<li>Du 12/05/2014 au 25/05/2014</li>
				<li>Du 29/05/2014 au 5/06/2014</li>
			</ul>
		</div>

		<div class="reservation">
			<h3>Réservation</h3>

			<ul>
				<li>Du 12/05/2014 au 20/05/2014</li>
				<li>Du 29/05/2014 au 29/05/2014</li>
			</ul>
		</div>

		<div class="description">
			<h3>Description</h3>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, sint, consequuntur tenetur rerum quos quasi excepturi nulla numquam alias aliquam ratione ullam nam perspiciatis fugiat praesentium impedit cumque? Hic, quas.
		</div>

		<div class="localite">
			<h3>Localité</h3>
			<p>Av 20 Novembre 1250 <br>
			www.hotel-name.com</p>
		</div>
	</aside>

	<div class="form-avis">
		<h3>Laissez votre avis votre tour !</h3>
		<form action="?p=fiche-bien&id=<?php echo $_GET['id'];?>">
			<label>Note</label>
			1<input type="radio" name="note" value="1">
			2<input type="radio" name="note" value="2">
			3<input type="radio" name="note" value="3">
			4<input type="radio" name="note" value="4">
			5<input type="radio" name="note" value="5">
			6<input type="radio" name="note" value="6">
			7<input type="radio" name="note" value="7">
			8<input type="radio" name="note" value="8">
			9<input type="radio" name="note" value="9">
			10<input type="radio" name="note" value="10">
			<label for="avis">Votre avis</label>
			<textarea name="avis" id="avis" cols="124" rows="5"></textarea>
			<button type="submit">Envoyer</button>
		</form>
	</div>

	<aside class="list-avis">
		<div class="comment">
	        <div class="message small-11 medium-11 large-11 left">
	            <div class="author">
	                <strong>Mixta</strong> <span class="first">1</span><span>/ 10</span>
	            </div>
	            <div class="content">
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget interdum metus. Vivamus massa elit, vestibulum sed tortor eleifend, placerat condimentum lectus. Nulla vehicula vel magna non tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat augue vitae mauris fringilla eleifend. Fusce vestibulum nulla ac leo tempor tincidunt. Fusce eu ligula et neque euismod posuere sit amet a mauris. Maecenas vestibulum, nisl at varius scelerisque, lectus est molestie magna, dapibus dignissim mi arcu non erat.
	            </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <div class="comment">
	        <div class="message small-11 medium-11 large-11 left">
	            <div class="author">
	                <strong>Mixta</strong> <span class="first">1</span><span>/ 10</span>
	            </div>
	            <div class="content">
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget interdum metus. Vivamus massa elit, vestibulum sed tortor eleifend, placerat condimentum lectus. Nulla vehicula vel magna non tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat augue vitae mauris fringilla eleifend. Fusce vestibulum nulla ac leo tempor tincidunt. Fusce eu ligula et neque euismod posuere sit amet a mauris. Maecenas vestibulum, nisl at varius scelerisque, lectus est molestie magna, dapibus dignissim mi arcu non erat.
	            </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <div class="comment">
	        <div class="message small-11 medium-11 large-11 left">
	            <div class="author">
	                <strong>Mixta</strong> <span class="first">1</span><span>/ 10</span>
	            </div>
	            <div class="content">
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget interdum metus. Vivamus massa elit, vestibulum sed tortor eleifend, placerat condimentum lectus. Nulla vehicula vel magna non tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat augue vitae mauris fringilla eleifend. Fusce vestibulum nulla ac leo tempor tincidunt. Fusce eu ligula et neque euismod posuere sit amet a mauris. Maecenas vestibulum, nisl at varius scelerisque, lectus est molestie magna, dapibus dignissim mi arcu non erat.
	            </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	</aside>

</article>
<aside class="bien-aside left">
	<div class="reserver">
		<a href="#" class="button">Réserver</a>
	</div>
	
	<div class="score">
		<span>1</span><span>/ 10</span>
	</div>

	<div class="info-proprio">
		<h3>Bailleur</h3>
		Mixta <br>
		Av 20 Novembre 1250, Santorini
	</div>
</aside>
<div class="clear"></div>