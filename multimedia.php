<?php
//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__,'multimedia'=>'FILMS']);

//Liste des genres de films 
$liste_stat 		= $maison->multimedia->stat();
$liste_genre		= $maison->multimedia->liste_genres()->to_array();
$liste_support		= $maison->multimedia->liste_supports()->to_array();

foreach($maison->multimedia->liste_auteurs as $cle => $auteur){
	$auto_complete_liste_auteurs[$cle]['value'] 	= $auteur->libelle();
	$auto_complete_liste_auteurs[$cle]['label'] 	= $auteur->libelle();
	$auto_complete_liste_auteurs[$cle]['id'] 		= $auteur->id();
}
	
echo $maison->html_head([
    titre       => 'Multimedia',
    charset     => 'UTF-8',
    scripts =>[ PLUGINS_ROOT.'/datatables/v1.10.16/datatables.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/js/dataTables.bootstrap.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/datatables-sort.js'
              ],
    css     =>[ PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/css/dataTables.bootstrap.min.css']
]);


$contenu = $maison->vue([
    'version'           => $maison->version(),
    'liste_genre'    	=> $liste_genre,
    'type_multimedia' 	=> 'films',
    'liste_support' 	=> $liste_support,
    'liste_auteurs' 	=> $auto_complete_liste_auteurs,
    'stat' 				=> $liste_stat,
    'chemin_image'		=> $maison->multimedia->chemin_images
]);

require VUES_STD_ROOT.'/gabarit.php'; 
