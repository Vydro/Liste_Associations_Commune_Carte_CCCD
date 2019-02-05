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
			case 'vpdo' :{
					return $this->vpdo;
					break;
				}
			case 'db' :{
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
	            $retour = $retour . '<at>Filtrer par :</at><esp><select id="categorie" onChange="js_change_cat()" >
                    <option value="0">-- Toutes les catégories</option>';
	            $result->execute();
	            while ( $row = $result->fetch ( PDO::FETCH_OBJ )) // parcourir chaque ligne sï¿½lectionnï¿½e
	            {
	                $retour = $retour . '<option value="'.$row->idCategorie.'">'.$row->nomCategorie.'</option>';
	            }
	            return $retour = $retour . '</select><esp><hr class="hracc"><esp>';
	        }
	    }
	}
	
	public function afficher_associations()
	{
	    return'<div id="divAssoc" style="display:none">
            </div><a class="button blue" href="'.$this->path.'/accueil/">retour à la carte</a><esp>';
	}
	
	public function infos_assoc($nomAssociation)
	{
	    $result = $this->vpdo->infos_assoc($nomAssociation);
	    if ($result != false) {
	        $row = $result->fetch ( PDO::FETCH_OBJ );
	        if (! isset($row->nomCategorie)){return '';}
	        $president = "President";
	            if($row->civilite == "Madame"){$president = $president."e";}
	        return '<h3>Association '.$row->nomCategorie.' - '. $row->intitule.'</h3>
                <a class="button blue" href="'.$this->path.'/accueil/commune/'.$row->nomComm.'">retour à la liste des associations</a><esp>
                <atcivil>'.$president.' '.$row->civilite.' '.$row->nom.' '.$row->prenom.'</atcivil><br>
                <at>'.$row->adresse.'<br>'.$row->cp.' '.$row->nomReelComm.'<esp> &emsp; &emsp;'.$row->descriptif.'<esp>
                Tel. '.$this->set_tel($row->tel).'</at>
                <a class="b" href="'.$row->siteInternet.'" target = "_blank">Site officiel &#8594;</a>';
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
	
	public function set_tel ($tel)
	{
	    $i = 0;
	    $newTel = '';
	    while($i < 10)
	    {
	        $newTel = $newTel.substr($tel, $i, 2).' ';
	        $i = $i + 2;
	    }
	    return $newTel;
	}
	
	
	public function retourne_formulaire_login() {
	    $retour = '
           <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <div class="modal fade" id="connexionModal" role="dialog" style="color:#000;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
        				<h3 class="modal-title"><span class="fas fa-lock"></span> Connexion</h3>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ">
          					<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
					<div class="modal-body">
						<form role="form" id="connexion" method="post">
							<div class="form-group">
								<label for="login"><span class="fas fa-user"></span> Login</label>
								<input type="text" class="form-control" id="login" name="login" placeholder="Login">
							</div>
							<div class="form-group">
								<label for="password"><span class="fas fa-eye"></span> Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-success btn-block" class="submit"><span class="fas fa-power-off"></span> Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>';
	    return $retour;
	}
}

?>
