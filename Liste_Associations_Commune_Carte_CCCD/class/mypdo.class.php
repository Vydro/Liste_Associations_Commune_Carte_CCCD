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
    
    public function liste_assoc($nomCommune, $idCategorie)
    {
        $requete='
            select idAssociation, intitule, nomCategorie, civilite, nom, adresse, cp
            from association a, categorie ct, commune cm, president p
            where a.idCategorie=ct.idCategorie
            and a.idCommune=cm.idCommune
            and a.idPresident=p.idPresident
            and cm.nomComm ="'.$nomCommune.'"';
        if($idCategorie != 0){
            $requete = $requete . 'and a.idCategorie="'.$idCategorie.'"';
        }
        $requete = $requete . 'order by intitule';
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return ($result);
        }
    }
    
    public function infos_assoc($nomAssociation)
    {
        $requete='
            select intitule, adresse, cp, tel, siteInternet, descriptif, nomCategorie, nomComm, nomReelComm, civilite, nom, prenom
            from association a, categorie ct, commune cm, president p
            where a.idCategorie=ct.idCategorie
            and a.idCommune=cm.idCommune
            and a.idPresident=p.idPresident
            and intitule ="'.$nomAssociation.'"';
        $result=$this->connexion ->query($requete);
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
        $result=$this->connexion->query($requete);
        if ($result)
        {
            return ($result);
        }
    }
    
    public function liste_communes()
    {
        $requete='
            select *
            from commune
            order by nomComm';
        $result=$this->connexion ->query($requete);
        if ($result){return ($result);}
    }
    
    public function liste_toutes_categories()
    {
        $requete='
            select *
            from categorie
            order by nomCategorie';
        $result=$this->connexion ->query($requete);
        if ($result){return ($result);}
    }
    
    public function connect($tab)
    {
        $requete='select user.*, type.* 
            from user, type
            where type.idType = user.idType
            and login="'.$tab['login'].'"
            and password=PASSWORD("'.$tab['password'].'")';
        
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            if ($result-> rowCount()==1){return ($result);}
        }
        return null;
    }
    
    public function president_exist($nom, $prenom, $civilite)
    {
        $requete='select idPresident from president 
            where nom = "'.$nom.'" and prenom = "'.$prenom.'" and civilite="'.$civilite.'"';
        
        $result=$this->connexion->query($requete);
        if ($result)
        {
            if ($result->rowCount()==1){return ($result);}
        }
        return null;
    }
    
    public function president_ajout($nom, $prenom, $civilite)
    {
        $requete="INSERT INTO `president` (`idPresident`, `nom`, `prenom`, `civilite`)
                VALUES (NULL, '$nom', '$prenom', '$civilite')";
        
        $result=$this->connexion->query($requete);
        if ($result)
        {
          return true;
        }
        return null;
    }
    
    public function ajout_assoc($param)
    {
        $requete="INSERT INTO `association` (`idAssociation`, `intitule`, `adresse`, `tel`, `siteInternet`, `descriptif`, `idCategorie`, `idCommune`, `idPresident`)
                VALUES (NULL, '$param[1]', '$param[2]', '$param[3]', '$param[4]', '$param[5]', '$param[6]', '$param[7]', '$param[8]')";
        
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return true;
        }
        return null;
    }
    
    public function supp_assoc($id)
    {
        $requete="DELETE from `association` WHERE idAssociation=".$id;
        
        $result=$this->connexion ->query($requete);
        if ($result)
        {
            return true;
        }
        return null;
    } 
}
?>
