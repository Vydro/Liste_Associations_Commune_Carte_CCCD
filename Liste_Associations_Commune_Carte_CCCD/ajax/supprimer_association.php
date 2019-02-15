<?php
session_start();

include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type']=="1")
{
    if(isset($_POST['id']))
    {
        $result = $mypdo->supp_assoc($_POST['id']);
        if(isset($result)){
            $data['erreur']='aucune';
        }
        else{$data['erreur']='requete';}
    }
    else{$data['erreur']='post';}
}
else{$data['erreur']='connexion';}

echo json_encode($data);

?>