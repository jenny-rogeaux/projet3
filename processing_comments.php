<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- enregistrement d'un commentaire
	
	développé par Jenny Rogeaux
-->

<?php
	// on récupère les données envoyées par le formulaire
	if(isset($_POST["commentaire"]) && isset($_POST["acteur"]))
	{
		$commentaire = $_POST["commentaire"] ;
		$id_acteur = (int)$_POST["acteur"] ;
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Une erreur est survenue lors de l'envoi du formulaire. Merci de contacter le web-master si le problème persiste.") ;
			document.location.href="index.php" ;
		</script><?php
	}
	
	// on vérifie que l'utilisateur est connecté
	if(!isset($_SESSION["prenom"]))
	{
		?><script type="text/javascript">
			alert("Vous devez être connecté pour poster un commentaire.") ;
			document.location.href="login_form.php" ;
		</script><?php
	}
	
	// on cherche l'utilisateur dans la base de données
	include("database_functions.php") ;
	$db = database_connect() ;
	
	$res = $db->prepare("select id_user from account where prenom=:prenom and nom=:nom") ;
	$res->execute(array("prenom"=>$_SESSION["prenom"], "nom"=>$_SESSION["nom"])) ;
	
	$user = $res->fetch() ;
	
	// enregistrer les données dans la base
	$res->closeCursor() ;
	
	$res = $db->prepare("insert into post(id_user, id_acteur, date_add, post) values(:user, :acteur, now(), :commentaire)") ;
	$res->execute(array("user"=>$user["id_user"], "acteur"=>$id_acteur, "commentaire"=>$commentaire)) ;
	
	// rediriger l'utilisateur
?>
	<script type="text/javascript">
		document.location.href="display_detail_partner.php?id=<?php echo $id_acteur ;?>" ;
	</script>
	
	
	
	
	
	
	