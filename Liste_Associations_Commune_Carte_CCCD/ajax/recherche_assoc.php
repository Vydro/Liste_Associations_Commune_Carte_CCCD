<?php
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();
$request = strtolower($_SERVER['REQUEST_URI']);
$params = explode('/', trim($request, '/'));
$params = array_filter($params);

if(isset($_POST['idCat']))
{
    //if(($_POST['idCat']) != 0){
        $resultat = $mypdo->liste_associations($params[4],$_POST['idCat']);
    //}
    //else{
    //    $resultat = $mypdo->liste_toutes_les_associations($params[4]);
    //}
    if(isset($resultat)){
		while($donnees = $resultat->fetch(PDO::FETCH_OBJ));
		{
			$data["intitule"][] = ($donnees->intitule);
			//$data["nomCategorie"][] = ($donnees->nomCategorie);
			//$data["civilite"][] = ($donnees->civilite);
			//$data["nom"][] = ($donnees->nom);
			//$data["adresse"][] = ($donnees->adresse);
			//$data["cp"][] = ($donnees->cp);
		}
	}
}
echo json_encode($data);
?>