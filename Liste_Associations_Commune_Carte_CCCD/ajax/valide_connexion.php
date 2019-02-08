<?php
session_start();

include_once('../class/autoload.php');

$errors = array();
$data = array();
$data['success']=false;

$tab=array();
$mypdo=new mypdo();

$tab['login']=$_POST['login'];
$tab['password']=$_POST['password'];

$result = $mypdo->connect($tab);
if(isset($result))
{
    $row = $result->fetch ( PDO::FETCH_OBJ );
	$_SESSION['login']=$tab['login'];
	$_SESSION['type']=($row->idType);
	$data['success']=true;
}
else
{$errors['message']='Identifiant ou mot de passe invalide';}

if ( ! empty($errors)) {
	$data['success'] = false;
	$data['errors']  = $errors;
} else {
	if($data['success'])
	{
		$data['message'] = 'Connexion réusssie';
	}
}

echo json_encode($data);
?>
