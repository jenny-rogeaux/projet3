<?php 
	session_start() ;
	session_destroy() ; 
?>

<!-- 
	Extranet du groupe bancaire GBAF :
	- déconnexion de l'utilisateur
	- redirection vers page de connexion
	
	développé par Jenny Rogeaux
-->

<script type="text/javascript">
	document.location.href="login_form.php" ;
</script>