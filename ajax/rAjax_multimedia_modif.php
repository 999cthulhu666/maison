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


switch ($_POST["fonction"]) {
    case 'ajouter':
        $id = $maison->multimedia->ajouter_document($_POST["document"]);
    break;
	    
    case 'critique':
        $note = $maison->multimedia->critique($_POST["document"]);
    break;
    
    case 'supprimer':

	break;
	
	case 'liste_maj':
		$Tjson['nouveaux_documents'] = $maison->multimedia->liste_nouveau()->to_html(['titre',['auteur'=>'libelle'],'annee']);
		$Tjson['supprimer_documents'] = $maison->multimedia->liste_supprimer()->to_html(['titre',['auteur'=>'libelle'],'annee']);
		$Tjson['confirmation'] = 'oui';
		
	break;
	
	case 'maj':
		$maison->multimedia->liste_nouveau()->maj();
		$maison->multimedia->liste_supprimer()->maj();
		$Tjson['confirmation'] = 'non';
	break;
  
}

$Tjson['id'] 					= $id ;  
$Tjson['note'] 					= $note ;  
$Tjson['rapport'] 				= $maison->rapport();  //Création du raaport d'erreur	

echo json_encode($Tjson);


?>
