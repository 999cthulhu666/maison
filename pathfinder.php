<?php
//Classe de base
include($_SERVER["DOCUMENT_ROOT"].'/classes/maison.class.php');

$maison = new maison(['root'=>$_SERVER["DOCUMENT_ROOT"],'page'=>__FILE__]);
	
echo $maison->html_head([
    titre       => 'Pathfinder',
    charset     => 'UTF-8',
    scripts =>[ PLUGINS_ROOT.'/datatables/v1.10.16/datatables.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/js/dataTables.bootstrap.min.js',
                PLUGINS_ROOT.'/datatables/v1.10.16/datatables-sort.js'
              ],
    css     =>[ PLUGINS_ROOT.'/datatables/v1.10.16/DataTables-1.10.16/css/dataTables.bootstrap.min.css']
]);


$contenu = $maison->vue([
    'version'           => $maison->version(),
]);

require VUES_STD_ROOT.'/gabarit.php'; 
