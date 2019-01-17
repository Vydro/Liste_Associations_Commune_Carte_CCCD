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
	
	public function infos_associations($nomCommune)
	{
	    $result = $this->vpdo->liste_associations($nomCommune);
	    if ($result != false) {
	        $categorie = $result->fetch( PDO::FETCH_OBJ )->nomCategorie;
	        $retour = ' <h3>Associations de la commune de'. $result->fetch( PDO::FETCH_OBJ )->nomReelComm.'<h3>';
	        $retour = $retour . '<button class="accordion">'.$categorie.'</button><div class="panel">';
	        while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
	        // parcourir chaque ligne s�lectionn�e
	        {
	            if($categorie != $row->nomCategorie){
	                $categorie = $row->nomCategorie;
	                $retour = $retour .'</div><button class="accordion">'.$categorie.'</button></button><div class="panel">';
	            }
	            $retour = $retour . '<h3>'.$row->intitule.'</h3>';
	        }
	        $retour = $retour .'</section>';
	        return $retour;
	    }
	}
	
	public function array_commune()
	{
	    $retour = array();
	    $result = $this->vpdo->liste_communes();
	    if ($result != false) {
	        while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
	        // parcourir chaque ligne s�lectionn�e
	        {
	            
	            $retour[]= $row->nomComm;
	        }
	        return $retour;
	    }
	}

	
	public function genererMDP ($longueur = 8){
		// initialiser la variable $mdp
		$mdp = "";
	
		// Définir tout les caractères possibles dans le mot de passe,
		// Il est possible de rajouter des voyelles ou bien des caractères spéciaux
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ&#@$*!";
	
		// obtenir le nombre de caractères dans la chaîne précédente
		// cette valeur sera utilisé plus tard
		$longueurMax = strlen($possible);
	
		if ($longueur > $longueurMax) {
			$longueur = $longueurMax;
		}
	
		// initialiser le compteur
		$i = 0;
	
		// ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
		while ($i < $longueur) {
			// prendre un caractère aléatoire
			$caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
	
			// vérifier si le caractère est déjà utilisé dans $mdp
			if (!strstr($mdp, $caractere)) {
				// Si non, ajouter le caractère à $mdp et augmenter le compteur
				$mdp .= $caractere;
				$i++;
			}
		}
	
		// retourner le résultat final
		return $mdp;
	}
	
	
}

?>
