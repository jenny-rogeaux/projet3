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
			<p><img src="pictures/GBAF.png" alt="logo du groupe GBAF" class="col-lg-5 offset-lg-1" /></p>
			
			<p>
				<img src="icons/person-fill.svg" alt="" width="40" height="40" />
				<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"] ?><br />
				<a href="logout.php">déconnexion</a>
			</p>
		</header><?php
	}
	
	else
	{
		?><header class="row">
			<p><img src="pictures/GBAF.png" alt="logo du groupe GBAF" class="col-lg-5 offset-lg-1" /></p>
		</header><?php
	}

?>