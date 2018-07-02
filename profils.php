<?php
//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/heineken.class.php');

$usine = new heineken(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);

//Chargement de l'entête de la page HTML
echo $usine->html_head([
    titre   => 'Profils',
    charset => 'UTF-8'
]);

//Chargement de la vue
$contenu = $usine->vue([
    'idBBB'            => $usine->utilisateurs->utilisateur->id(),  
    'nom'           => $usine->utilisateurs->utilisateur->nom(),
    'identifiant'   => $usine->utilisateurs->utilisateur->identifiant(),
    'groupe'        => $usine->utilisateurs->utilisateur->groupe()
]);

//Données envoyées dans le gabarit
$utilisateur        = $usine->utilisateurs->utilisateur->nom();
$niveau_acces       = $usine->utilisateurs->utilisateur->droit();

require VUES_STD_ROOT.'/gabarit.php'; 

