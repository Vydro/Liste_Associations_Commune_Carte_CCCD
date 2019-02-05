<?php
session_start();

include_once ('class/autoload.php');
$site = new page_base();
$controleur = new controleur();
$request = strtolower($_SERVER['REQUEST_URI']);
$params = explode('/', trim($request, '/'));
$params = array_filter($params);
if (! isset($params[2])) {
    $params[2] = 'accueil';
}
switch ($params[2]) {
    case 'accueil':
        if (isset($params[3])) {
            switch ($params[3]) {
                case 'commune':
                    if (isset($params[4]) && in_array($params[4], $controleur->array_commune($params[4]))) {
                        if (isset($params[5]) && $controleur->infos_assoc(urldecode($params[5])) != '') {
                            $site->titre = urldecode($params[5]);
                            $site->left_sidebar = $controleur->infos_assoc(urldecode($params[5]));
                            $site->affiche();
                        }
                        else{
                            if(! isset($params[5])){
                                $site->titre = $params[4];
                                $site->js = 'categorie';
                                $site->left_sidebar = $controleur->liste_categorie($params[4]);
                                $site->left_sidebar = $controleur->afficher_associations();
                                $site->affiche();
                            }else{deflt($site);}
                        }
                    }else{deflt($site);}
                break;
                default:deflt($site);
            }
        }
        else 
        {
            $site->titre = 'Accueil';
            $site->js = 'app.min';
            $site->left_sidebar = $controleur->retourne_carte();
            $site->affiche();  
        }
        break;
    case 'connexion' :
        $site->titre = 'Connexion';
        $site->js = 'jquery-3.3.1.min';
        $site->js = 'bootstrap';
        $site->js = 'connexion';
        $site-> left_sidebar = $controleur->retourne_formulaire_login();
        $site->affiche();
        break;
    case 'deconnexion' :
        $_SESSION=array();
        session_destroy();
        echo '<script>document.location.href="index.php"; </script>';
        break;
    default:deflt($site);
}


function deflt($site){
    $site->titre = 'Accueil';
    $site->left_sidebar = '<img src="' . $site->path . '/image/erreur-404.png" alt="Erreur de liens">';
    $site->affiche();
}
?>