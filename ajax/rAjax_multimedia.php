<?php
/*********************************************************************************************
                            *** AJAX rAjax_multimedia ***

Version		: 	2018A

Cette requete ajax alimente le tableau contenant la liste des documents multimedia.

*********************************************************************************************/

//Spécification type de réponse à la requete ajax : format texte
header('Content-Type: text/html; charset=utf-8;Cache-Control: no-cache, must-revalidate');

//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);

//Liste des documents multimedia
foreach($maison->multimedia->liste_multimedias as $key=>$document){
		$tableau[$key][0] = $document->genre()->libelle();		//Colonne cachée
		$tableau[$key][1] = $document->to_array();					//Colonne cachée
		$tableau[$key][2] = ucfirst($document->auteur()->libelle());
		$tableau[$key][3] = ucfirst($document->titre());
		$tableau[$key][4] = $document->annee();
		$tableau[$key][5] = $document->support()->libelle();
}

echo conversion::tableau_to_json($tableau);

?>
