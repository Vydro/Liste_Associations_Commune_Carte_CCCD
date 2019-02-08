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
    <h3>Espace connexion</h3>
	<div class="cadre">
	   <form role="form" id="connexion" method="post">
			<tlp>Login : </tlp><input type="text" id="login" name="login" placeholder="Login" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"><br><esp>
			<tlp>Password : </tlp><input type="password" id="password" name="password" placeholder="Password" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"><br><esp>
			<button type="submit" onclick="connexion()" >Se Connecter</button>
		</form>
	</div>
    <footer>*Vous devez posséder un compte crée au préalable par l\'administrateur</footer>';
	    return $retour;
	}
	
	/* Spécifique à la personne connecté */
	public function retourne_formulaire_ajouter_association() {
	    $retour='
        <h3>Ajouter une Association</h3>
        <div class="cadre">
	    <form role="form" id="ajoutAssociation" method="post">
			<tlp>Intitulé: </tlp><input type="text" id="intitule" placeholder="nom de l\'association" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"><err>*</err><br><esp>

            <tlp>Catégorie: </tlp>
                <select id="arrayCat" required="required">
                    <option>-- Choisissez une catégorie</option>';
	    $result = $this->vpdo->liste_toutes_categories();
	    if ($result != false) {
	        while ($row = $result->fetch ( PDO::FETCH_OBJ ) ) // parcourir chaque ligne sï¿½lectionnï¿½e
	        {$retour = $retour . '<option value="'.$row->idCategorie.'">'.$row->nomCategorie.'</option>';}
	    }else{$retour = $retour . '<option>erreur lors du chargement</option>';}
	    $retour = $retour . '</select><err>*</err><esp>

            <tlp>Nom: </tlp><input type="text" id="nom" placeholder="nom du président" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="oninput="this.value = this.value.toUpperCase()""><err>*</err><esp>
            
           <tlp>Préom: </tlp><input type="text" id="nom" placeholder="prénom du président" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"><err>*</err><esp>
            

            <tlp>Commune: </tlp>
                <select id="arrayComune" required="required">
                    <option>-- Choisissez une commune</option>';
	    $result = $this->vpdo->liste_communes();
	    if ($result != false) {
	        while ($row = $result->fetch ( PDO::FETCH_OBJ ) ) // parcourir chaque ligne sï¿½lectionnï¿½e
	           {$retour = $retour . '<option value="'.$row->idCommune.'">'.$row->nomReelComm.'</option>';}
	    }else{$retour = $retour . '<option>erreur lors du chargement</option>';}
	    
	    $retour = $retour . '</select><err>*</err><esp>
			
            <tlp>Adresse: </tlp><input type="text" id="adresse" placeholder="numéro et nom de la rue" autocomplete="off"
                required="required" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);"><err>*</err><esp>
            
            <tlp>Numéro de téléphone: </tlp><input type="tel"  pattern="[0]{1}[0-9]{9}" id="tel" placeholder="0123456789" autocomplete="off"><esp>
            
            <tlp>Site Internet: </tlp><input type="url"  pattern="https://.*|http://.*" id="site" placeholder="https://example.com" autocomplete="off"><esp>
            
            <tlp>Description: </tlp><br><textarea id="descriptif" placeholder="Descriptif de l\'association" autocomplete="off"
                style="resize:vertical" rows="8" cols="80"></textarea><br>
            <err>*Champ obligatoire pour l\'ajout de l\'association</err>
			</div><esp>
            <button type="submit" onclick="valid()" >Valider</button>
            <button type="reset">Recommencer</button>
		</form>';
	    return $retour;
	}
}

?>
