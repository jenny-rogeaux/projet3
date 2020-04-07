<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- affichage du détail des informations concernant un partenaire donné
	
	développé par Jenny Rogeaux
-->
	
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<?php 
			include("redirection.php") ;			
			
			// traitement de l'ID envoyé par l'URL
			if(isset($_GET["id"]))
			{
				$id = (int)$_GET["id"] ;
			}
			
			else
			{
				?><script type="text/javascript">
					alert("Page inaccessible, merci de contacter le webmaster si le problème persiste.") ;
					document.location.href='index.php' ;
				</script><?php
			}
			
			// on récupère les données à afficher
			include("database_functions.php") ;
			$db = database_connect() ;
			
			$res = $db->prepare('select logo, acteur, description from acteur where id_acteur=:id') ;
			$res->execute(array('id'=>$id)) ;
			
			$acteur = $res->fetch() ;
			$res->closeCursor() ;
			
			// on compte le nombre de commentaires
			$res = $db->prepare('select count(id_post) as nb_com from post where id_acteur=:id') ;
			$res->execute(array("id"=>$id)) ;
			
			$nb_com = $res->fetch() ;
			$res->closeCursor() ;
			
			// on récupère les commentaires
			$res = $db->prepare('select prenom, date_format(date_add, "%d/%m/%Y") as date, post 
									from post 
									inner join account on post.id_user = account.id_user 
									where id_acteur = ?
									order by date desc') ;
			$res->execute(array($id)) ;
		?>
		
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
				<p><img class="col-lg-8 offset-lg-2" src="pictures/<?php echo $acteur['logo'] ; ?>" alt="logo du partenaire" /></p>
				<h2 class="col-lg-12"><?php echo $acteur["acteur"] ; ?></h2>
				<p class="col-lg-12"><?php echo $acteur["description"] ; ?></p>
			</section>
			
			<section class="row">
				<p class="col-lg-2"><?php echo $nb_com["nb_com"] ; ?> commentaires</p>
				<a href="#formulaire"><button type="button" class="btn btn-secondary col-lg-8 offset-lg-1">nouveau commentaire</button></a>
				
				<?php
					while($commentaires = $res->fetch())
					{
						?><p class="col-lg-12">
							<br /><?php echo $commentaires["prenom"] ; ?>
							<br /><?php echo $commentaires["date"] ; ?>
							<br /><?php echo $commentaires["post"] ; ?>
						</p><?php
						
					}
				?>				
				
				<form class="col-lg-7 offset-lg-1" method="post" action="processing_comments.php">
					<legend><a name="formulaire">ajouter un commentaire en tant que <?php echo $_SESSION["prenom"] ; ?> :</a></legend>
					<div class="form-group">
						<label for="commentaire">commentaire</label>
						<textarea class="form-control" name="commentaire" id="commentaire" required></textarea>
					</div>
					<input type="hidden" name="acteur" value="<?php echo $id ; ?>" />
					<center><input type="submit" value="commenter" /></center>
				</form>
			</section> 
				
			<?php include("footer.php") ; ?>
		</div>
	</body>
</html>