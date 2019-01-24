<?php
class controleur {

	private $vpdo;
	private $db;
	protected $path='http://localhost/reposGitCCCD/Liste_Associations_Commune_Carte_CCCD';
	public function __construct() {
		$this->vpdo = new mypdo ();
		$this->db = $this->vpdo->connexion;
	}
	public function __get($propriete) {
		switch ($propriete) {
			case 'vpdo' :
				{
					return $this->vpdo;
					break;
				}
			case 'db' :
				{
					
				    return $this->db;
					break;
				}
		}
	}
	
	public function retourne_carte()
	{
		return '
            <h3>Carte des communes composant la CCCD</h3>
            <br>
            <object data="'.$this->path.'/image/carte.svg" type="image/svg+xml" id="cartesvg" width="65%"></object>';
	}
	
	public function liste_categorie($nomCommune)
	{
	    $result = $this->vpdo->liste_categorie($nomCommune);
	    if ($result != false) {
	        $row = $result->fetch ( PDO::FETCH_OBJ );
	        if($row != NULL)
	        {
	            $retour = '<h3>Associations de la commune de '. $row->nomReelComm.'</h3>
                    <a class="button blue" href="'.$this->path.'/accueil/">retour à la carte</a><esp>';
	            $retour = $retour . '<at>Filtrer par :</at><esp><select id="categorie"><option value="0">-- Toutes les catégories</option>';
	            $result->execute();
	            while ( $row = $result->fetch ( PDO::FETCH_OBJ )) // parcourir chaque ligne sï¿½lectionnï¿½e
	            {
	                $retour = $retour . '<option value="'.$row->idCategorie.'">'.$row->nomCategorie.'</option>';
	            }
	            return $retour = $retour . '</select>';
	        }
	    }
	}

	public function array_commune()
	{
	    $retour = array();
	    $result = $this->vpdo->liste_communes();
	    if ($result != false) {
	        while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
	        // parcourir chaque ligne sï¿½lectionnï¿½e
	        {
	            
	            $retour[]= $row->nomComm;
	        }
	        return $retour;
	    }
	}
	
	public function set_tel ($tel){
	    $i = 0;
	    $newTel = '';
	    while($i < 10)
	    {
	        $newTel = $newTel.substr($tel, $i, 2).' ';
	        $i = $i + 2;
	    }
	    return $newTel;
	}

	
	public function genererMDP ($longueur = 8){
		// initialiser la variable $mdp
		$mdp = "";
	
		// DÃ©finir tout les caractÃ¨res possibles dans le mot de passe,
		// Il est possible de rajouter des voyelles ou bien des caractÃ¨res spÃ©ciaux
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ&#@$*!";
	
		// obtenir le nombre de caractÃ¨res dans la chaÃ®ne prÃ©cÃ©dente
		// cette valeur sera utilisÃ© plus tard
		$longueurMax = strlen($possible);
	
		if ($longueur > $longueurMax) {
			$longueur = $longueurMax;
		}
	
		// initialiser le compteur
		$i = 0;
	
		// ajouter un caractÃ¨re alÃ©atoire Ã  $mdp jusqu'Ã  ce que $longueur soit atteint
		while ($i < $longueur) {
			// prendre un caractÃ¨re alÃ©atoire
			$caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
	
			// vÃ©rifier si le caractÃ¨re est dÃ©jÃ  utilisÃ© dans $mdp
			if (!strstr($mdp, $caractere)) {
				// Si non, ajouter le caractÃ¨re Ã  $mdp et augmenter le compteur
				$mdp .= $caractere;
				$i++;
			}
		}
	
		// retourner le rÃ©sultat final
		return $mdp;
	}
	
	
}

?>
