<!-- 
	Extranet du groupe bancaire GBAF :
	- formulaire de récupération de mot de passe (question secrète)
	
	développé par Jenny Rogeaux
-->
	
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Extranet du Groupe GBAF | Récupération mot de passe</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<?php
			// récupération de la question secrète dans la base de données
			$question="question" ;
		?>
		
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
				<h1 class="col-lg-12">Récupération de mot de passe</h1>
		
				<form class="clo-lg-7 offset-lg-1" method="post" action="#">
					<div class="form-group">
						<label for="pseudo">nom d'utilisateur :</label>
						<input type="text" name="pseudo" id="pseudo" maxlength="20" required class ="form-control" />
					</div>
					<center><input type="submit" value="afficher la question secrète" class="btn btn-primary" /></center>
				</form>
				
				<?php
				// on récupère l'identifiant envoyé par l'utilisateur
				if(isset($_POST["pseudo"]))
				{
					$pseudo = htmlspecialchars((string)$_POST["pseudo"]) ;
					
					// on cherche si l'identifiant existe dans la base de données
					include("database_functions.php") ;
					if(search_username($pseudo))
					{											
						// on cherche la question secrète de l'utilisateur
						$db = database_connect() ;
						
						$res = $db->prepare("select question, reponse from account where username=?") ;
						$res->execute(array($pseudo)) ;
						
						$question = $res->fetch() ;
						$res->closeCursor() ;						
						
						?><form class="col-lg-7 offset-lg-1" method="post" action="processing_password_recovery.php" name="question">
							<legend>Question secrète : <?php echo $question["question"] ; ?></legend>
							<div class="form-group">
								<label for="reponse">réponse</label> :
								<input type="text" name="reponse" id="reponse" maxlength="100" required class="form-control" />
							</div>
							<input type="hidden" name="pseudo" value="<?php echo $pseudo ; ?>" />
							<center><input type="submit" value="envoyer" class="btn btn-primary" /></center>
						</form>
					<?php }
					
					else
					{
						?><script type="text/javascript">
							alert("Nom d'utilisateur inconnu dans la base de données") ;
							document.location.href="password_recovery_form.php" ;
						</script><?php
					}
				} ?>
				
				
			</section>
			
			<?php include("footer.php") ; ?>
		</div>
	</body>
</html>