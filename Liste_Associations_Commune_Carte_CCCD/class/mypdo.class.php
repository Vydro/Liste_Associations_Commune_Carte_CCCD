<?php
class mypdo extends PDO{

    private $PARAM_hote='localhost'; // le chemin vers le serveur
    private $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    private $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
    private $PARAM_nom_bd='association_cccd'; // nom de la base de donnée ustilisée
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
    		echo 'NÂ° : '.$e->getCode();
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
    
    public function liste_associations($nomCommune)
    {
        $requete='
            select intitule, adresse, tel, siteInternet, descriptif, nomCategorie, nomComm, nomReelComm, civilite, nom, prenom
            from association a, categorie ct, commune cm, president p
            where a.idCategorie=ct.idCategorie
            and a.idCommune=cm.idCommune
            and a.idPresident=p.idPresident
            and cm.nomComm ="'.$nomCommune.'"
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
