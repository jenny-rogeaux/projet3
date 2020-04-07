<?php session_start() ; ?>
<!-- 
	Extranet du groupe bancaire GBAF :
	- affichage de la liste des partenaires
	
	développé par Jenny Rogeaux
-->

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Extranet du Groupe GBAF | Liste de nos partenaires</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="style.css" />
	</head>
	
	<body>
		<?php include("redirection.php") ; ?>
			
		<div class="container">
			<?php include("header.php") ; ?>
			
			<section class="row">
				<h1 class="col-lg-12">Groupement Banque-Assurance Français</h1>
			</section>
			
			
			<section class="row">
				<h2 class="col-lg-12">acteurs et partenaires :</h2>
				
				<table class="col-lg-12">					
					<?php
						include("database_functions.php") ;
						$db = database_connect() ;

						$res = $db->query('select * from acteur') ;
						while($data = $res->fetch())
						{
							?>
							<tr class="row">
								<td class="col-lg-4"><p class="row"><img class="col-lg-12" src="pictures/<?php echo $data['logo'] ; ?>" alt="logo de <?php echo $data['acteur'] ; ?>" /></p></td>
								<td class="col-lg-4"><h3><?php echo $data['acteur'] ;?></h3></td>
								<td class="col-lg-4"><a href="#">[lire la suite]</a></td>
							</tr>
						<?php
						}
						
						$res->closeCursor() ;
					?>	
				</table>
			</section>			
			
			<?php include("footer.php") ; ?>
		</div>
	</body>
</html>
 