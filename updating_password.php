<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- mise à jour du mot de passe de l'utilisateur dans la base de données
	
	développé par Jenny Rogeaux
-->

<?php
	// on récupère les données envoyées par le formulaire
	if(isset($_POST["mdp"]) && strlen((string)$_POST["mdp"])<=50)
	{
		if(CRYPT_STD_DES==1)
			$mdp = crypt((string)$_POST["mdp"], 'md') ;
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Une erreur est survenue lors de l'envoi du formulaire. Merci de contacter le web-master si le problème persiste.") ;
			document.location.href="display_perso_data.php" ;
		</script><?php
	}
	
	//on met à jour la base de données
	include("database_functions.php") ;
	$db = database_connect() ;
	
	$res = $db->prepare("update account set password=:mdp where username=:pseudo") ;
	$res->execute(array("mdp"=>$mdp, "pseudo"=>$_SESSION["pseudo"])) ;
	
	// on déconnecte l'utilisateur
	include("logout.php") ;
	
	// on redirige l'utilisateur vers la page de connexion
?><script type="text/javascript">
	alert("Votre mot de passe à bien été mis à jour.") ;
	document.location.href="login_form.php" ;
</script>