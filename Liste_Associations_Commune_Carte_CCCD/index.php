<?php
session_start();

include_once ('class/autoload.php');
$site = connexsecurise();
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
        if(!(isset($_SESSION['login']) && isset($_SESSION['type']))){
            $site->titre = 'Connexion';
            $site->js = 'connexion';
            $site-> left_sidebar = $controleur->retourne_formulaire_login();
            $site->affiche();
        }else{echo '<script>document.location.href="accueil"; </script>';}
    break;
    
    case 'deconnexion' :
        $_SESSION=array();
        session_destroy();
        echo '<script>document.location.href="accueil"; </script>';
    break;
        
        /* Spécifique à la personne connecté */
    case 'ajoutassoc':
        if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type']=="1")
        {
             $site->titre = 'Ajouter Association';
             $site->js = 'gestion_association';
             $site-> left_sidebar = $controleur->retourne_formulaire_ajouter_association();
             $site->affiche();
        }else{echo '<script>document.location.href="accueil"; </script>';}
    break;
    
    default:deflt($site);
}


function deflt($site){
    $site->titre = 'Accueil';
    $site->left_sidebar = '<img src="' . $site->path . '/image/erreur-404.png" alt="Erreur de liens">';
    $site->affiche();
}

function connexsecurise() {
    $retour ='';
    if(!isset($_SESSION['login']) || !isset($_SESSION['type'])){
        $retour = new page_base();
    }
    else
    {
        switch ($_SESSION['type'])
        {
            case '1':
                $retour = new page_base_securisee_admin();
            break;
        }
    }
    return $retour;
}

?>