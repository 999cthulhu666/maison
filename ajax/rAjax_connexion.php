<?php
/*********************************************************************************************
                            *** AJAX req_verif_mdp ***

Version		: 	2017A

Cette requete ajax vérifie si l'utilisateur est présent dans la base et que son compte est activé.
On autorise 3 tentavives avant de rediriger l'utilisateur sur une page d'erreur.

Paramètres POST:
$_POST['utilisateur']   : nom de l'utilisateur
$_POST['mdp']           : mot de passe


Résultats retournés:(sous forme HTML)
"OK" 		: Connexion OK
*********************************************************************************************/

//Spécification type de réponse à la requete ajax : format texte
header('Content-Type: text/html; charset=utf-8;Cache-Control: no-cache, must-revalidate');

//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);

//Le mot de passe ou l'identifiant de connexion ne sont pas valide ( $Donnees_utilisateur = false )
if ($maison->utilisateurs->connexion($_POST['utilisateur'],$_POST['mdp'])=== false){
	
    $_SESSION['S_tentative_connexion'] ++;
    
    //Si plus de X tentavives consécutives de connexions ont échoué, on ne permet plus de tentative de connexion		
    if ($_SESSION['S_tentative_connexion'] >= NBR_MAX_TENTATIVE_CONNEX) {
	
		$Tjson['connexion']='X'; //X tentatives de connexion, on arrête
        $maison->erreur->afficher(['numero'=>16]);
        
    }
    else{
    
       $Tjson['connexion']='NOK'; //Utilisateur ou mot de passe invalide
       $maison->erreur->afficher(['numero'=>15,NBR_MAX_TENTATIVE_CONNEX - $_SESSION['S_tentative_connexion']]);
       
    }
     $Tjson['nom']= 'Aucun utilisateur connecté'; 	
}
else{
    //Connexion réussie, on met à jour on sérialize l'objet salarié
    $Tjson['nom']						= $maison->utilisateurs->utilisateur->nom(); 	
    $_SESSION['S_utilisateur'] 			= serialize($maison->utilisateurs->utilisateur);
    $_SESSION['S_tentative_connexion'] 	= 0;
    $Tjson['connexion']='OK'; //Connexion réussi	
}	


$Tjson['rapport'] = $maison->rapport();  //Création du raaport d'erreur	

echo json_encode($Tjson);

?>
