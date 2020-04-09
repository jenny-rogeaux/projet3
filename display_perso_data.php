<?php session_start() ; ?>
<!-- 
	Extranet du groupe bancaire GBAF :
	- affichage des données personnelles de l'utilisateur
	
	développé par Jenny Rogeaux
-->

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Extranet du Groupe GBAF | Données personnelles</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<?php include("redirection.php") ; ?>
		
		<?php
			// on charge les informations du profil
			include("database_functions.php") ;
			$db = database_connect() ;
			
			$res = $db->prepare("select * from account where username=?") ;
			$res->execute(array($_SESSION["pseudo"])) ;
			
			$perso_data = $res->fetch() ;
			
			// on stocke les questions dans un tabeau
			$questions = array("Quel est le nom de jeune fille de votre mère ?",
				"Où avez-vous grandi ?",
				"Quel était le nom de votre premier animal de compagnie ?",
				"Quel est votre film préféré ?",
				"Quel a été votre premier métier ?") ;
		?>
		
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
				<h1 class="col-lg-12">Informations du profil</h1>
				
				<form class="col-lg-7 offset-lg-1" method="post" action="updating_perso_data.php">
					<div class="form-group">
						<label for="nom">nom</label> :
						<input type="text" name="nom" id="nom" class="form-control" required maxlength="20" value="<?php echo $perso_data["nom"] ; ?>" />
					</div>
					<div class="form-group">
						<label for="prenom">prénom</label> :
						<input type="text" name="prenom" id="prenom" class="form-control" required maxlength="20" value="<?php echo $perso_data["prenom"] ; ?>" />
					</div>
					<div class="form-group">
						<label for="pseudo">nom d'utilisateur</label> :
						<input type="text" name="pseudo" id="pseudo" class="form-control" required maxlength="20" value="<?php echo $perso_data["username"] ; ?>" />
					</div>
					
					<div class="form-group">
						<label for="question">question secrète</label> :
						<select name="question" id="question" class="form-control" required>
							<?php foreach($questions as $item)
							{
								 ?><option value="<?php echo $item ;?>"
								<?php if($item == $perso_data["question"])
								{
									echo "selected" ;
								}?>><?php echo $item ;?></option><?php
							} ?>
						</select>
					</div>
					<div class="form-group">
						<label for="reponse">réponse à la question secrète</label> :
						<input type="text" name="reponse" id="reponse" maxlength="100" required class="form-control" value="<?php echo $perso_data["reponse"] ; ?>" />
					</div>
					<center>
						<input type="reset" class="btn btn-secondary" value="réinitialiser" />
						<input type="submit" class="btn btn-primary" value="enregistrer les modifications" />
					</center>
				</form>
				<form method="post" action="updating_password.php" class="col-lg-7 offset-lg-1">
					<div class="form-group">
						<label for="mdp">nouveau mot de passe</label> :
						<input type="password" name="mdp" id="mdp" maxlength="50" required class="form-control" />
					</div>
					<center><input type="submit" value="changer mot de passe" class="btn btn-primary" /></center>
				</form>
			</section>
			
			<?php include("footer.php") ; ?>
		</div>
	</body>
</html>
	