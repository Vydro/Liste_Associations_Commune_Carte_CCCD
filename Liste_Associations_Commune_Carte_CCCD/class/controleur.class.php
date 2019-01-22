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
	        $row = $result->fetch ( PDO::FETCH_OBJ );
	        if($row != NULL)
	        {
	            $retour = '<h3>Associations de la commune de '. $row->nomReelComm.'</h3>';
	            $retour = $retour . '<hr class="hracc"><button class="accordion">'.$row->nomCategorie.'</button><div class="panel">';
	            $cat = $row->nomCategorie;
	            $result->execute();
	            $i=-1;
	            while ( $row = $result->fetch ( PDO::FETCH_OBJ )) // parcourir chaque ligne s�lectionn�e
	            {
	                if($cat != $row->nomCategorie)//nouveau accordion si on change de catégorie d'assoc
	                {
	                    $i = -1;
	                    $cat = $row->nomCategorie;
	                    $retour = $retour .'</div><esp><hr class="hracc"><button class="accordion">'.$row->nomCategorie.'</button><div class="panel">';
	                }
	                $i++;
	                if($i>0){$retour = $retour .'<br><hr><br>';}
	                $retour = $retour . 
	                '<p>
                        <atstrong>'.$row->intitule.'</atstrong><br>
                        <atcivil>President(e). '.$row->civilite.'. '.$row->nom.'</atcivil><br>
                        <at>'.$row->adresse.'&nbsp;'.$row->adresse.'<esp>
                        &emsp;&emsp;'.$row->descriptif.'<esp>
                        Tel. : '.$this->set_tel($row->tel).'<br>
                        <a class="b" title="site - reseau social de l\'association" href="'.$row->siteInternet.'">Lien vers la page officiel</a><br>
                        </at>
                    </p>';
	            }
	            return $retour = $retour . '</div>
                <script>
                var acc= document.getElementsByClassName("accordion");
                var i;
                for (i = 0; i < acc.length; i++) {
                    acc[i].onclick = function(){
                    this.classList.toggle("active");
                    this.nextElementSibling.classList.toggle("show");
                    }
                }
                </script>';
	        }
	        else
	        {
	            return '<err>*pas d\'association</err>';
	        }
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
