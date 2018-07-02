<?php
/*********************************************************************************************
                            *** AJAX rAjax_profils ***

Version		: 	2017A

Cette requete ajax vérifie si l'utilisateur est présent dans la base et que son compte est activé.
On autorise 3 tentavives avant de rediriger l'utilisateur sur une page d'erreur.

Paramètres POST:
$_POST['utilisateur']   : nom de l'utilisateur
$_POST['mot_de_passe']  : mot de passe


Résultats retournés:(sous forme HTML)
"X" 		: X tentatives de connexion, on arrête
"NOK" 		: utilisateur ou mot de passe invalide
"OK" 		: Connexion OK
*********************************************************************************************/

//Spécification type de réponse à la requete ajax : format texte
header('Content-Type: text/html; charset=utf-8;Cache-Control: no-cache, must-revalidate');

//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);


$Tjson['autorisation'] = $usine->utilisateurs->connexion($_POST['utilisateur'],$_POST['mdp']);
        
$Tjson['nbr_tentavive_max'] = $_POST['utilisateur']['id']; 	
$Tjson['nbr_tentavive']     = $_SESSION['S_tentative_connexion']; 	

$Tjson['rapport']           = $usine->rapport();  //Création du raaport d'erreur	

echo json_encode($Tjson);

?>
