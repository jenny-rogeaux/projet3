<!-- 
	Extranet du groupe bancaire GBAF :
	- affichage de l'en-tête
	
	développé par Jenny Rogeaux
-->

<?php
	// on teste si une session est ouverte
	if(isset($_SESSION["nom"]))
	{
		?><header class="row">
			<p><a href="index.php"><img src="pictures/GBAF.png" alt="logo du groupe GBAF" class="col-lg-5 offset-lg-1" /></a></p>
			
			<p>
				<img src="icons/person-fill.svg" alt="" width="40" height="40" />
				<?php echo "<a href='display_perso_data.php'>".$_SESSION["nom"]." ".$_SESSION["prenom"]."</a>" ?><br />
				<a href="logout.php">déconnexion</a>
			</p>
		</header><?php
	}
	
	else
	{
		?><header class="row">
			<p><a href="index.php"><img src="pictures/GBAF.png" alt="logo du groupe GBAF" class="col-lg-5 offset-lg-1" /></a></p>
		</header><?php
	}

?>