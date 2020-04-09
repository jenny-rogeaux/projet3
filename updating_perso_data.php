<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- mise à jour des données personnelles de l'utilisateur dans la base de données
	
	développé par Jenny Rogeaux
-->

<?php
	// on récupère les données envoyées par le formulaire
	if(isset($_POST["nom"]) && strlen((string)$_POST["nom"])<=20
		&& isset($_POST["prenom"]) && strlen((string)$_POST["prenom"])<=20
		&& isset($_POST["pseudo"]) && strlen((string)$_POST["pseudo"])<=20
		&& isset($_POST["question"]) && strlen((string)$_POST["question"])<=100
		&& isset($_POST["reponse"]) && strlen((string)$_POST["reponse"])<=100)
	{
		$nom = (string)$_POST["nom"] ;
		$prenom = (string)$_POST["prenom"] ;
		$pseudo = (string)$_POST["pseudo"] ;
		$question = (string)$_POST["question"] ;
		$reponse = (string)$_POST["reponse"] ;
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Une erreur est survenue lors de l'envoi du formulaire. Merci de contacter le web-master si le problème persiste.") ;
			document.location.href="display_perso_data.php" ;
		</script><?php
	}
	
	// on met à jour la base de données
	include("database_functions.php") ;
	$db = database_connect() ;
	
	$res = $db->prepare("update account set nom=:nom, prenom=:prenom, username=:nouv_pseudo, question=:question, reponse=:reponse where username=:pseudo") ;
	$res->execute(array("pseudo"=>$_SESSION["pseudo"], "nom"=>$nom, "prenom"=>$prenom, "question"=>$question, "reponse"=>$reponse, "nouv_pseudo"=>$pseudo)) ;
	
	// on met à jour la session
	new_session($nom, $prenom, $pseudo) ;
	
	// on redirige l'utilisateur
?><script type="text/javascript">
	alert("Vos données ont bien été mises à jour.") ;
	document.location.href="index.php" ;
</script>