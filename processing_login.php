<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- ouverture d'une session utilisateur
	
	développé par Jenny Rogeaux
-->

<?php
	// on récupère les données envoyées par le formulaire
	if(isset($_POST["pseudo"]) && strlen((string)$_POST["pseudo"])<=20 && isset($_POST["mdp"]) && strlen((string)$_POST["mdp"])<=50)
	{
		$pseudo = htmlspecialchars((string)$_POST["pseudo"]) ;
		$mdp = crypt((string)$_POST["mdp"], 'md') ;
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Une erreur est survenue lors de l'envoi du formulaire. Merci de contacter le web-master si le problème persiste.") ;
			document.location.href="login_form.php" ;
		</script><?php
	}
	
	// on cherche l'utilisateur dans la base de données
	include("database_functions.php") ;
	$db = database_connect() ;
	
	if(search_username($pseudo))
	{
		// on vérifie le mot de passe
		$res = $db->prepare("select nom, prenom, password from account where username=:pseudo") ;
		$res->execute(array("pseudo"=>$pseudo)) ;
		
		$data = $res->fetch() ;
		if($mdp != $data["password"])
		{
			?><script type="text/javascript">
				alert("Mot de passe incorrect.") ;
				document.location.href="login_form.php" ;
			</script><?php
		}
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Utilisateur inconnu.") ;
			document.location.href="login_form.php" ;
		</script><?php
	}
	
	// on créé la session
	new_session($data["nom"], $data["prenom"], $pseudo) ;
	
	// on redirige l'utilisateur vers le listing des partenaires
	?><script type="text/javascript">
			document.location.href="index.php" ;
		</script><?php
?>