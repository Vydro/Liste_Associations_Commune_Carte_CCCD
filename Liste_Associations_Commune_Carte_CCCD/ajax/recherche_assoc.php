<?php
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

if(isset($_POST['idCat']) && isset($_POST['commune']) )
{   
    $result = $mypdo->liste_assoc($_POST['commune'], $_POST['idCat']);

    if(isset($result)){
        while ( $row = $result->fetch ( PDO::FETCH_OBJ ))
		{
		    $data['id'][] = ($row->idAssociation);
		    $data['intitule'][] = ($row->intitule);
		    $data["nomCategorie"][] = ($row->nomCategorie);
		    $data["civilite"][] = ($row->civilite);
		    $data["nom"][] = ($row->nom);
		    $data["adresse"][] = ($row->adresse);
		}
	}
}
echo json_encode($data);
?>