<?php
//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);

echo $maison->html_head([
    titre       => 'Connexion',
    charset     => 'UTF-8'
]);


$contenu = $maison->vue([
    'version'           => $maison->version(),
    'type_connexion'    => $_GET['spie'],
]);

require VUES_STD_ROOT.'/gabarit_simple.php'; 
