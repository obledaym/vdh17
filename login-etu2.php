<?php 
	session_start();
	
	// Ask CAS for user ticket
	// the service parameter is the callback address
	if(!isset($_GET['ticket'])) {
		header('Location: https://cas.utc.fr/cas/login?service=http://assos.utc.fr/lavoieduhoublon/team/login-etu2.php?task=login');
	}
	
	// Ask for user info 
	$response = file_get_contents("https://cas.utc.fr/cas/serviceValidate?service=http://assos.utc.fr/lavoieduhoublon/team/login-etu2.php?task=login&ticket=".$_GET['ticket']);
	$response = new SimpleXMLElement($response);
	$response = $response->xpath('/cas:serviceResponse/cas:authenticationSuccess/cas:user');
	
	// Authenticated
	if($response) {
		$_SESSION['user'] = (string) $response[0];
		$_SESSION['autorisation']=false;
		include_once('../db.php');
		
		// Fetch user info
		$user = $db->query('
			SELECT * 
			FROM `users`
			WHERE `login` = "'.$_SESSION['user'].'"
		');
		
		if( $user->rowCount() > 0) {
			$_SESSION['autorisation']=true;
			$user1 = $user->fetch();
			//On ajoute ses droits
		$_SESSION['droits']=$user1['droit'];
			header('Location: index.php');}
		else {
		unset($_SESSION['login-etu']);
		echo "Tu n'as pas les autorisations pour accéder à cette page.";
		echo '<br><a href="../index.html">Retour</a>';
		exit();}
		
	} 
	else {echo "Tu ne peux pas accéder à cette page.";}
?>