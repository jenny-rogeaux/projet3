<!-- 
	Extranet du groupe bancaire GBAF :
	- affichage de l'en-tête
	
	développé par Jenny Rogeaux
-->

<?php
	// on teste si une session est ouverte
	if(isset($_SESSION["nom"]))
	{
		?><header class="row"><!---->
			<p class="col-12 col-sm-12 col-md-5 col-lg-5 offset-lg-1 logo">
				<a href="index.php"><img src="pictures/GBAF.png" alt="logo du groupe GBAF" width="200" /></a>
			</p>
			
			<p class="col-2 col-sm-1 col-md-1 col-lg-1 offset-md-1 offset-lg-1 profil">
				<img src="icons/person-fill.svg" alt="" width="40" height="40" />
			</p>
			
			<p class="col-9 col-sm-3 col-md-3 col-lg-3 profil">			
				<a href='display_perso_data.php'><?php echo $_SESSION["nom"]." ".$_SESSION["prenom"] ; ?></a><br />
				<a href="logout.php">déconnexion</a>
			</p>
		</header><?php
	}
	
	else
	{
		?><header class="row">
			<p class="col-12 col-sm-12 col-md-5 col-lg-5 offset-lg-1 logo">
				<a href="index.php"><img src="pictures/GBAF.png" alt="logo du groupe GBAF" class="col-lg-5 offset-lg-1" /></a>
			</p>
		</header><?php
	}

?>