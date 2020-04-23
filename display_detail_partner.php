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
			
			include("database_functions.php") ;
			$db = database_connect() ;

			if(isset($_GET["vote"]) && ((string)$_GET["vote"]=="like" || (string)$_GET["vote"]=='dislike'))
			{
				$new_vote = $_GET["vote"] ;
				
				// on cherche si l'utilisateur a déjà voté pour ce partenaire
				$res = $db->prepare("select count(vote) as nb_vote from vote where id_user=:user and id_acteur=:acteur") ;
				$res->execute(array("user"=>$_SESSION["id"], "acteur"=>$id)) ;
				$nb_vote = $res->fetch() ;
				
				// si oui : 
				if ($nb_vote["nb_vote"] > 0)
				{
					// on récupère le vote de l'utilisateur
					$query = $db->prepare("select vote from vote where id_user=:user and id_acteur=:acteur") ;
					$query->execute(array("user"=>$_SESSION["id"], "acteur"=>$id)) ;
					$vote = $query->fetch() ;
					
					// on compare le vote enregistré à celui qu'il vient de faire
					if($vote["vote"]==$new_vote)
					{
						// si les deux votes sont identiques on affiche un message
						if($new_vote=="like")
						{
							?><script>alert("vous avez déjà liké ce partenaire") ;</script><?php
						}
						
						else
						{
							?><script>alert("vous avez déjà disliké ce partenaire") ;</script><?php
						}
					}

					else
					{
						// mise à jour du vote dans la base de données
						$query->closeCursor() ;
						$query = $db->prepare("update vote set vote=:vote where id_user=:user and id_acteur=:acteur") ;
						$query->execute(array("user"=>$_SESSION["id"], "acteur"=>$id, "vote"=>$new_vote)) ;	
						$query->closeCursor() ;
					}					
				}						
				
				// si non : on créé une nouvelle entrée
				else
				{
					$res->closeCursor() ;
					$res = $db->prepare("insert into vote(id_user, id_acteur, vote) values(:user, :acteur, :vote)") ;
					$res->execute(array("user"=>$_SESSION["id"], "acteur"=>$id, "vote"=>$new_vote)) ;
				}
			}
			
			// on récupère les données à afficher
			
			
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
			
			$query = $db->query("select count(vote) as nb_like from vote where vote='like'") ;
			$data = $query->fetch() ;
			$nb_like = $data["nb_like"] ;
			$query->closeCursor() ;
			
			$query = $db->query("select count(vote) as nb_dislike from vote where vote='dislike'") ;
			$data = $query->fetch() ;
			$nb_dislike = $data["nb_dislike"] ;
			$query->closeCursor() ;
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
				<a href="#formulaire" class="col-lg-2 offset-lg-1"><button type="button" class="btn btn-secondary">nouveau commentaire</button></a>
				<p class="offset-lg-1 col-lg-6">
					<button class="btn btn-link" onclick="location.href='display_detail_partner.php?id='+<?php echo $id ; ?>+'&vote=like' ;"><img src="icons/like.png"/></button>
					<?php echo $nb_like ; ?> 
					<button class="btn btn-link" onclick="location.href='display_detail_partner.php?id='+<?php echo $id ; ?>+'&vote=dislike' ;"><img src="icons/dislike.png"/></button>
					<?php echo $nb_dislike ; ?> 
				</p>
				
				<?php
					while($commentaires = $res->fetch())
					{
						?><p class="col-lg-12">
							<br /><?php echo $commentaires["prenom"] ; ?>
							<br /><?php echo $commentaires["date"] ; ?>
							<br /><?php echo $commentaires["post"] ; ?>
						</p><?php
						
					}
					
					$res->closeCursor() ;
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
		
		<?php
			
		?>
		<script>
			/*function giveItsOpinion(vote)
			{*/
				
		</script>
	</body>
</html>