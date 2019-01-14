<?php
class controleur {

	private $vpdo;
	private $db;
	protected $path='http://localhost/reposGit_Liste_Associations_Commune_Carte_CCCD/Liste_Associations_Commune_Carte_CCCD';
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
					
				    return $this->db; //932px � 692
					break;
				}
		}
	}
	
	public function retourne_carte()
	{
		return '
           <h3>Carte</h3>
           <object data="'.$this->path.'/image/carte.svg" type="image/svg+xml" id="cartesvg" width="70%" height="70%"></object>';
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
