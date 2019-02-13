<?php
session_start();

include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

$param = array();

if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type']=="1")
{
    if(isset($_POST['intitule']) && isset($_POST['idCat']) && isset($_POST['nomP']) && isset($_POST['prenomP']) 
        && isset($_POST['civilite']) && isset($_POST['idComm']) && isset($_POST['adresse']))
    {    
        //ajout des paramètres essentiels pour la création de l'association
        $param[1]=$_POST['intitule'];
        $param[2]=$_POST['adresse'];
        //paramètre pouvant être null, si c'est le cas on met un string vide et non null
        if($_POST['tel'] != '' ){$param[3]=$_POST['tel'];}else{$param[3]=' ';}
        if($_POST['url'] != '' ){$param[4]=$_POST['url'];}else{$param[4]=' ';}
        if($_POST['descriptif'] != '' ){$param[5]=$_POST['descriptif'];}else{$param[5]=' ';}
        
        $param[6]=$_POST['idCat'];
        $param[7]=$_POST['idComm'];
        //on vérifie que le président (nom, prenom...) n'est pas déjà présent dans la BDD
        $prsdtExist=$mypdo->president_exist($_POST['nomP'], $_POST['prenomP'], $_POST['civilite']);
        if(! isset($prsdtExist)){//si il est absent on le rajoute
           $mypdo->president_ajout($_POST['nomP'], $_POST['prenomP'], $_POST['civilite']);
           $prsdtExist=$mypdo->president_exist($_POST['nomP'], $_POST['prenomP'], $_POST['civilite']);
        }
        //on récupère l'id du président (ajouté ou existant)
        $row = $prsdtExist->fetch ( PDO::FETCH_OBJ );
        $param[8]=$row->idPresident;
        
        $result = $mypdo->ajout_assoc($param);
        if(isset($result)){
            $data['erreur']='aucune';
        }
        else{$data['erreur']='requete';}
    }else{$data['erreur']='post';}
}else{$data['erreur']='connexion';}

echo json_encode($data);

?>