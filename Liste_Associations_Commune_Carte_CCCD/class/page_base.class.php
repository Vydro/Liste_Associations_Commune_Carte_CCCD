<?php

class page_base {
	protected $right_sidebar;
	protected $left_sidebar;
	protected $titre;
	protected $js=array('jquery-3.3.1.min','bootstrap.min');
	protected $css=array('perso','bootstrap.min','base', 'modele');
	protected $page;
	protected $metadescription="Bienvenue sur le site de la CCCD, regroupant les associations présentent dans chaque commune";
	protected $metakeyword=array('comcom','chateaubriant','derval','association','commune');
	protected $path='http://localhost/reposGitCCCD/Liste_Associations_Commune_Carte_CCCD';

	public function __construct() {
		$numargs = func_num_args();
		//$arg_list = func_get_args();
        if ($numargs == 1) {
			$this->titre=$numargs[0];
		}
	}

	public function __set($propriete, $valeur) {
		switch ($propriete) {
			case 'css' : {
				$this->css[count($this->css)+1] = $valeur;
				break;
			}
			case 'js' : {
				$this->js[count($this->js)+1] = $valeur;
				break;
			}
			case 'metakeyword' : {
				$this->metakeyword[count($this->metakeyword)+1] = $valeur;
				break;
			}
			case 'titre' : {
				$this->titre = $valeur;
				break;
			}
			case 'metadescription' : {
				$this->metadescription = $valeur;
				break;
			}
			case 'right_sidebar' : {
				$this->right_sidebar = $this->right_sidebar.$valeur;
				break;
			}
			case 'left_sidebar' : {
				$this->left_sidebar = $this->left_sidebar.$valeur;
				break;
			}
			default:
			{
				$trace = debug_backtrace();
				trigger_error(
            'Propriété non-accessible via __set() : ' . $propriete .
            ' dans ' . $trace[0]['file'] .
            ' à la ligne ' . $trace[0]['line'],
            E_USER_NOTICE);

				break;
			}

		}
	}
	public function __get($propriete) {
		switch ($propriete) {
			case 'titre' :
				{
					return $this->titre;
					break;
				}
				case 'path' :
				{
					return $this->path;
					break;
				}
				default:
			{
				$trace = debug_backtrace();
        trigger_error(
            'Propriété non-accessible via __get() : ' . $propriete .
            ' dans ' . $trace[0]['file'] .
            ' à la ligne ' . $trace[0]['line'],
            E_USER_NOTICE);

				break;
			}
				
		}
	}
	/******************************Gestion des styles **********************************************/
	/* Insertion des feuilles de style */
	private function affiche_style() {
		foreach ($this->css as $s) {
			echo "<link rel='stylesheet'  href='".$this->path."/css/".$s.".css' />\n";
		}

	}
	/******************************Gestion du javascript **********************************************/
	/* Insertion  js */
	private function affiche_javascript() {
		foreach ($this->js as $s) {
			echo "<script src='".$this->path."/js/".$s.".js'></script>\n";
		}
	}
	/******************************affichage metakeyword **********************************************/

	private function affiche_keyword() {
		echo '<meta name="keywords" content="';
		foreach ($this->metakeyword as $s) {
			echo utf8_encode($s).',';
		}
		echo '" />';
	}	
	/****************************** Affichage de la partie entÃªte ***************************************/	
	protected function affiche_entete() {
		echo'
           <header>
				<img  class="img-responsive"  width="200" height="210" src="'.$this->path.'/image/logo.jpg" alt="logo" style="float:left;padding: 0 10px 10px 0;"/>
                <h1>
					Associations des différentes communes
				</h1>
                <h2>
					Châteaubriant - Derval
				</h2>
             </header>
		';
	}
	/****************************** Affichage du menu ***************************************/	
	
	protected function affiche_menu() {
		echo '
                <hr class="hr">
				<ul >
					<li ><a   href="'.$this->path.'/Accueil" >Accueil</a></li>
				</ul>';
	}
	protected function affiche_menu_connexion() {
		
		if(!(isset($_SESSION['id']) && isset($_SESSION['type'])))
		{	
			echo '
					<ul >
						<li><a  href="'.$this->path.'/Connexion">Connexion</a></li>
					</ul>';
		} 
		else
		{
			echo '
					<ul >
						<li><a  href="'.$this->path.'/Deconnexion">Déconnexion</a></li>
					</ul>';
		}
	}
	public function affiche_entete_menu() {
		echo '
		<div id="menu_horizontal">
			<nav >
				<div >

				';
						
	}
	public function affiche_footer_menu(){
		echo '
						
					
				</div>
			</nav>
		</div>';

	}
	
	/****************************************** Affichage du pied de la page ***************************/
	private function affiche_footer() {
		echo '
		<!-- Footer -->
			<footer>
				Site officiel de la 
				<a href="http://cc-chateaubriant-derval.fr/">Communauté de Commune Châteaubriant - Derval</a>
                &copy; 2019
				</p>
            </footer>
		';
	}

	
	/********************************************* Fonction permettant l'affichage de la page ****************/

	public function affiche() {
		
		
		?>
			<!DOCTYPE html>
			<html lang='fr'>
				<head>
					<title><?php echo $this->titre; ?></title>
					<meta http-equiv="content-type" content="text/html; charset=utf-8" />
					<meta name="description" content="<?php echo $this->metadescription; ?>" />
					
					<?php $this->affiche_keyword(); ?>
					<?php $this->affiche_javascript(); ?>
					<?php $this->affiche_style(); ?>
				</head>
				<body>
				<div class="global">

						<?php $this->affiche_entete(); ?>
						<?php $this->affiche_entete_menu(); ?>
						<?php $this->affiche_menu(); ?>
						<?php $this->affiche_menu_connexion(); ?>
						<?php $this->affiche_footer_menu(); ?>
						
  						<div style="clear:both;">
    						<div style="float:left;width:75%;">
     							<?php echo $this->left_sidebar; ?>
    						</div>
    						<div style="float:left;width:25%;">
								<?php echo $this->right_sidebar;?>
    						</div>
  						</div>
						<div style="clear:both;">
							<?php $this->affiche_footer(); ?>
						</div>
					</div>
				</body>
			</html>
		<?php
	}

}

?>
