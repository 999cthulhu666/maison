<?php
//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);

//Liste des recettes 
$liste_recette		= $maison->recette->liste('recette',['sorte'=>1]);
$liste_categorie	= $maison->recette->liste('type');
$liste_ingredient	= $maison->recette->liste('ingredient');
$liste_unite		= $maison->recette->liste('unite');

//var_dump($liste_categorie);
/*
foreach ( $liste_unite	 as $key => $ingredient) {
		
		$tableau_html .= $ingredient->to_html([
				'colonnes'	=>['id','libelle','unite'],
				'table'		=>'class="table-striped table-bordered"',
				'attributs'	=>['data-id'=>$ingredient->id(),'data-libelle'=>$ingredient->libelle(),'data-unite'=>$ingredient->unite(),'class'=>'text-right','style'=>'width:100px;'],
		]);
	
}
foreach ( $liste_ingredient	 as $key => $ingredient) {
	$xml.= $ingredient->to_xml();
}

*/

foreach($liste_ingredient as $cle => $ingredient){
	$auto_complete_liste_ingredient[$cle]['value'] 	= $ingredient->libelle();
	$auto_complete_liste_ingredient[$cle]['label'] 	= $ingredient->libelle();
	$auto_complete_liste_ingredient[$cle]['id'] 	= $ingredient->id();
}

foreach($liste_unite as $cle => $unite){
	$auto_complete_liste_unite[$cle]['value'] 	= $unite->libelle();
	$auto_complete_liste_unite[$cle]['label'] 	= $unite->libelle();
	$auto_complete_liste_unite[$cle]['id'] 		= $unite->id();
}

		
echo $maison->html_head([
    titre       => 'Recettes',
    charset     => 'UTF-8',
    scripts =>[ PLUGINS_ROOT.'/datatables/v1.10.16/datatables.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/js/dataTables.bootstrap.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/datatables-sort.js'
              ],
    css     =>[ PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/css/dataTables.bootstrap.min.css']
]);


$contenu = $maison->vue([
    'version'           => $maison->version(),
    'liste_recette'    	=> $liste_recette,
    'liste_categorie'  	=> $liste_categorie,
    'liste_ingredient' 	=> $auto_complete_liste_ingredient,
    'liste_unite' 		=> $auto_complete_liste_unite
]);

require VUES_STD_ROOT.'/gabarit.php'; 
