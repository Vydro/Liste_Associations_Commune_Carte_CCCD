<?php
class mypdo extends PDO{
    
    private $PARAM_hote='localhost'; // le chemin vers le serveur
    private $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    private $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
    private $PARAM_nom_bd='association_cccd'; // nom de la base de donn�e ustilis�e
    private $connexion;
    public function __construct() {
        try {
            
            $this->connexion = new PDO('mysql:host='.$this->PARAM_hote.';dbname='.$this->PARAM_nom_bd, $this->PARAM_utilisateur, $this->PARAM_mot_passe,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            //echo '<script>alert ("ok connex");</script>)';echo $this->PARAM_nom_bd;
        }
        catch (PDOException $e)
        {
            echo 'hote: '.$this->PARAM_hote.' '.$_SERVER['DOCUMENT_ROOT'].'<br />';
            echo 'Erreur : '.$e->getMessage().'<br />';
            echo 'N° : '.$e->getCode();
            $this->connexion=false;
            //echo '<script>alert ("pbs acces bdd");</script>)';
        }
    }
    public function __get($propriete) {
        switch ($propriete) {
            case 'connexion' :
                {
                    return $this->connexion;
                    break;
                }
        }
    }
    
    public function liste_associations($nomCommune, $idCategorie)
    {
        $requete='
            select intitule, nomCategorie, civilite, nom, adresse 
            from association a, categorie ct, commune cm, president p
            where a.idCategorie=ct.idCategorie
            and a.idCommune=cm.idCommune
            and a.idPresident=p.idPresident
            and cm.nomComm ="'.$nomCommune.'"
            and a.idCategorie="'.$idCategorie.'"
            order by intitule';
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return ($result);
        }
    }
    
    public function liste_toutes_les_associations($nomCommune)
    {
        $requete='
            select intitule, nomCategorie, civilite, nom, adresse
            from association a, categorie ct, commune cm, president p
            where a.idCategorie=ct.idCategorie
            and a.idCommune=cm.idCommune
            and a.idPresident=p.idPresident
            and cm.nomComm ="'.$nomCommune.'"
            order by intitule';
        $result=$this->connexion ->query($requete); //liste_toutes_les_associations
        if ($result)
        {
            return ($result);
        }
    }
    
    public function liste_categorie($nomCommune)
    {
        $requete='
        select ct.idCategorie, nomCategorie, nomReelComm
        from association a, categorie ct, commune cm
        where a.idCategorie=ct.idCategorie
        and a.idCommune=cm.idCommune
        and cm.nomComm ="'.$nomCommune.'"
        group by nomCategorie
        order by nomCategorie';
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return ($result);
        }
    }
    
    public function liste_communes()
    {
        $requete='
            select nomComm
            from commune';
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return ($result);
        }
    }
}
?>
