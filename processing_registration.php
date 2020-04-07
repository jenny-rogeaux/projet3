<?php session_start() ; ?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- enregistrement d'un nouvel utilisateur
	
	développé par Jenny Rogeaux
-->

<?php
	// on récupère les données envoyées par le formulaire
	if(isset($_POST["nom"]) && strlen((string)$_POST["nom"])<=20
		&& isset($_POST["prenom"]) && strlen((string)$_POST["prenom"])<=20
		&& isset($_POST["pseudo"]) && strlen((string)$_POST["pseudo"])<=20
		&& isset($_POST["mdp"]) && strlen((string)$_POST["mdp"])<=50
		&& isset($_POST["question"]) && strlen((string)$_POST["question"])<=100
		&& isset($_POST["reponse"]) && strlen((string)$_POST["reponse"])<=100)
	{
		$nom = (string)$_POST["nom"] ;
		$prenom = (string)$_POST["prenom"] ;
		$pseudo = (string)$_POST["pseudo"] ;
		$mdp = (string)$_POST["mdp"] ;
		$question = (string)$_POST["question"] ;
		$reponse = (string)$_POST["reponse"] ;
	}
	
	else
	{
		?><script type="text/javascript">
			alert("Une erreur est survenue lors de l'envoi du formulaire. Merci de contacter le web-master si le problème persiste.") ;
			document.location.href="registration_form.php" ;
		</script><?php
	}
	
	// on vérifie que l'utilisateur n'est pas déjà dans la base de données (nom + prénom)
	include("database_functions.php") ;
	$db = database_connect() ;
	
	$res = $db->prepare("select count(id_user) as nb_user from account where nom=:nom and prenom=:prenom") ;
	$res->execute(array("nom"=>$nom, "prenom"=>$prenom)) ;
	
	$data = $res->fetch() ;
	if($data["nb_user"]>0)
	{
		?><script type="text/javascript">
			alert("Vous êtes déjà enregistré dans la base de données.") ;
			document.location.href="registration_form.php" ;
		</script><?php
	}
	
	$res->closeCursor() ;
	
	// on vérifie que l'identifiant est disponible
	if(search_username($pseudo))
	{
		?><script type="text/javascript">
			alert("Cet identifiant est déjà utilisé.") ;
			document.location.href="registration_form.php" ;
		</script><?php
	}
	
	else
	{
		// on enregistre les données dans la base de données
		$res = $db->prepare("insert into account(nom, prenom, username, password, question, reponse) values(:nom, :prenom, :pseudo, :mdp, :question, :reponse)") ;
		$res->execute(array("nom"=>$nom, "prenom"=>$prenom, "pseudo"=>$pseudo, "mdp"=>$mdp, "question"=>$question, "reponse"=>$reponse)) ;
	}	
	
	// on créé la session
	new_session($nom, $prenom) ;
?>