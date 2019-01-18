<?php
session_start();

include_once ('class/autoload.php');
$site = new page_base();
$controleur = new controleur();
$request = strtolower($_SERVER['REQUEST_URI']);
$params = explode('/', trim($request, '/'));
$params = array_filter($params);
// var_dump($params);
if (! isset($params[2])) {
    $params[2] = 'accueil';
}
switch ($params[2]) {
    case 'accueil':
        if (isset($params[3])) 
        {
            switch ($params[3]) 
            {
                case 'commune':
                    if (isset($params[4]) && in_array($params[4], $controleur->array_commune($params[4])) 
                                && $controleur->infos_associations($params[4]))
                    {
                        $site->titre = $params[4];
                        $site->js = 'app.min';
                        $site->js = 'accordion';
                        $site->left_sidebar = $controleur->retourne_carte();
                        $site->left_sidebar = $controleur->infos_associations($params[4]);
                        $site->affiche();
                    }
                    else{
                        $site->titre = 'Accueil';
                        $site->left_sidebar = '<br>*Il n\'y a pas d\'associations pour cette commune</br>';
                        $site->affiche();
                    }
                    break;
                default:
                    $site->titre = 'Accueil';
                    $site->left_sidebar = '<img src="' . $site->path . '/image/erreur-404.png" alt="Erreur de liens">';
                    $site->affiche();
                    break;
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

    case 'connexion':
        $site->titre = 'Connexion';
        $site->js = 'jquery.validate.min';
        $site->js = 'messages_fr';
        $site->js = 'jquery.tooltipster.min';
        $site->css = 'tooltipster';
        $site->left_sidebar = $controleur->retourne_formulaire_login();
        $site->affiche();
        break;
    case 'deconnexion':
        $_SESSION = array();
        session_destroy();
        echo '<script>document.location.href="index.php"; </script>';
        break;
    default:
        $site->titre = 'Accueil';
        $site->left_sidebar = '<img src="' . $site->path . '/image/erreur-404.png" alt="Erreur de liens">';
        $site->affiche();
        break;
}

?>