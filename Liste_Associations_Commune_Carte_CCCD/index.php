<?php
	session_start();

	include_once('class/autoload.php');
	$site = new page_base();
	$controleur=new controleur();
	$request = strtolower($_SERVER['REQUEST_URI']);
	$params = explode('reposGit_Liste_Associations_Commune_Carte_CCCD/', trim($request, '/'));
    $params = array_filter($params);
	if (!isset($params[1]))
	{
		$params[1]='accueil';
	}
	switch ($params[0]) {
		case 'accueil' :
			$site->titre='Accueil';
			$site-> left_sidebar=$controleur->retourne_article($site->titre);
			$site->affiche();
			break;
		case 'connexion' :
			$site->titre='Connexion';
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='jquery.tooltipster.min';
			$site->css='tooltipster';
			$site-> left_sidebar=$controleur->retourne_formulaire_login();
			$site->affiche();
			break;
		case 'deconnexion' :
			$_SESSION=array();
			session_destroy();
			echo '<script>document.location.href="index.php"; </script>';
			break;
		default: 
			$site->titre='Accueil';
			$site-> left_sidebar='<img src="'.$site->path.'/image/erreur-404.png" alt="Erreur de liens">';
			$site->affiche();
			break;
	}	
	
?>