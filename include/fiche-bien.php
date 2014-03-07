<?php
$nr_de_vue = $bdd->query('SELECT visites FROM biens');
$resultat = $nr_de_vue->fetch();
$nr_de_vue = $resultat['visites']++;
echo $resultat['visites'];

?>

<article class="left">
	<div class="photo">
		<img src="" alt="photo">
	</div>

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

	<div class="form-avis">
		<h3>Laissez votre avis votre tour !</h3>
		<form action="?p=fiche-bien&id=12">
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
		</form>
	</div>

	<aside class="list-avis">
		<div class="comment">
	        <div class="message small-11 medium-11 large-11 left">
	            <div class="author">
	                <strong>Mixta</strong> 5/10
	            </div>
	            <div class="content">
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget interdum metus. Vivamus massa elit, vestibulum sed tortor eleifend, placerat condimentum lectus. Nulla vehicula vel magna non tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat augue vitae mauris fringilla eleifend. Fusce vestibulum nulla ac leo tempor tincidunt. Fusce eu ligula et neque euismod posuere sit amet a mauris. Maecenas vestibulum, nisl at varius scelerisque, lectus est molestie magna, dapibus dignissim mi arcu non erat.
	            </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	</aside>

</article>
<aside class="left">
	<div class="reserver">
		<a href="#" class="button">Réserver</a>
	</div>
	
	<div class="info-proprio">
		Mixta <br>
		Av 20 Novembre 1250, Santorini
	</div>
</aside>
<div class="clear"></div>