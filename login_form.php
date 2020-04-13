<!-- 
	Extranet du groupe bancaire GBAF :
	- formulaire de connexion
	
	développé par Jenny Rogeaux
-->
	
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Extranet du Groupe GBAF | Connexion</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
				<h1 class="col-lg-12">Connexion</h1>
				
				<form class="col-lg-7 offset-lg-1" method="post" action="processing_login.php">
					<div class="form-group">
						<label for="pseudo">nom d'utilisateur</label> :
						<input type="text" name="pseudo" id="pseudo" maxlength="20" required class="form-control" />
					</div>
					<div class="form-group">
							<label for="mdp">mot de passe</label> :
							<input type="password" name="mdp" id="mdp" maxlength="50" required class="form-control" />
					</div>
					<center><input type="submit" value="me connecter" class="btn btn-primary" /></center>
				</form>
				
				<p class="col-lg-11 offset-lg-1"><a href="password_recovery_form.php">mot de passe oublié</a></p>
			</section>

			<?php include("footer.php") ; ?>
		</div>		
	</body>
</html>