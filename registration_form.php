<!-- 
	Extranet du groupe bancaire GBAF :
	- formulaire d'inscription
	
	développé par Jenny Rogeaux
-->
	
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Extranet du Groupe GBAF | Inscription</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
					<h1 class="col-lg-12">Inscription</h1>
					
					<form class="col-lg-7 offset-lg-1" method="post" action="processing_registration.php">
						<div class="form-group">
							<label for="nom">nom</label> : 
							<input type="text" name="nom" id="nom" maxlength="20" required class="form-control" />
						</div>
						<div class="form-group">
							<label for="prenom">prénom</label> : 
							<input type="text" name="prenom" id="prenom" maxlength="20" required class="form-control"/>
						</div>
						<div class="form-group">
							<label for="pseudo">nom d'utilisateur</label> :
							<input type="text" name="pseudo" id="pseudo" maxlength="20" required class="form-control" />
						</div>
						<div class="form-group">
							<label for="mdp">mot de passe</label> :
							<input type="password" name="mdp" id="mdp" maxlength="50" required class="form-control" />
						</div>
						<div class="form-group">
							<label for="question">question secrète</label> :
							<input type="text" name="question" id="question" maxlength="100" required class="form-control" />
						</div>
						<div class="form-group">
							<label for="reponse">réponse à la question secrète</label> :
							<input type="text" name="reponse" id="reponse" maxlength="100" required class="form-control" />
						</div>
						<center><input type="submit" value="m'inscrire" class="btn btn-primary" /></center>
					</form>
			</section>
			
			<?php include("footer.php") ; ?>
		</div>		
	</body>
</html>