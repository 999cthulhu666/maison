<?php
/*********************************************************************************************
                            *** AJAX rAjax_recette ***

Version		: 	2018A

Cette requete ajax ...

*********************************************************************************************/

//Spécification type de réponse à la requete ajax : format texte
header('Content-Type: text/html; charset=utf-8;Cache-Control: no-cache, must-revalidate');

//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);


switch ($_POST["fonction"]) {
    case 'categorie':
		$liste_recettes = $maison->recette->liste('recette',['sorte'=>$_POST["option"]]);
       
		foreach ( $liste_recettes as $key => $recette) {
			$Tjson['recettes'][$key] = $recette->to_array();
		}
       
    break;
	
	case 'lire': 
       $recette	= $maison->recette->lire($_POST["option"]);
       $Tjson['recette'] = $recette->to_array();
    break;
    
}
 
$Tjson['rapport']= $maison->rapport();  //Création du raport d'erreur	

echo json_encode($Tjson);

?>
