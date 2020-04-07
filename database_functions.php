<!-- 
	Extranet du groupe bancaire GBAF :
	- fonction de connexion à la base de données
	
	développé par Jenny Rogeaux
-->

<?php
	function database_connect()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=projet3;charset=utf8', 'root', '') ;
		}
		
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage()) ;
		}
		
		return $db ;
	}
	
	function search_username($username)
	{
		// renvoie "true" si le nom d'utilisateur est présent dans la base
		
		$db = database_connect() ;
		
		$res = $db->prepare("select count(id_user) as nb_username from account where username=:pseudo") ;
		$res->execute(array("pseudo"=>$username)) ;
		
		$data = $res->fetch() ;
		if($data["nb_username"]>0)
			return true ;
		
		return false ;
	}
	
	function new_session($nom, $prenom)
	{
		$_SESSION["nom"] = $nom ;
		$_SESSION["prenom"] = $prenom ;
	}
?>