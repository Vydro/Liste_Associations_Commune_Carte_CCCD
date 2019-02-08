<?php
class page_base_securisee_admin extends page_base {

	public function __construct() {
		parent::__construct();
	}
	public function affiche() {
		if(!isset($_SESSION['login']) || !isset($_SESSION['type']))
		{
			echo '<script>document.location.href="Accueil"; </script>';

		}
		else
		{
			if($_SESSION['type']!='1')
			{
				echo '<script>document.location.href="Accueil"; </script>';
			}
			else
			{
				parent::affiche();
			}
		}
	}
	public function affiche_menu() {

		parent::affiche_menu();
        echo '
		<ul>
            <li><a href="'.$this->path.'/ajoutAssoc">Ajouter une association</a></li>
		</ul>';
	}
}
?>
