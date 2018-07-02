<?php
/*
Nom classe 	:	tableau_html
Commentaire	:	Cette classe ...
Version		: 	2017A

Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __construct()									: Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __destruct()									: Cette méthode est appellé lors de la destruction de  l'objet. On ferme la connection au serveur SQL.


*/

class tableau_html {
    
    //Variables privées
    private  	$tableau_id             = 'IDtableau'; 
    private  	$tableau_class          = 'table table-striped'; 
    private  	$tableau_attributs      = ''; 
    private  	$tableau_libelle_vide   = 'Aucun document'; 
    private  	$CLASS_colonnes         = ''; 
    private 	$donnees_tableau;
    private     $titres_colonnes        = [];
	
    /*********************************************************************************************
                                    *** FUNCTION __construct ***

    Cette méthode initialise l'objet.

    Paramètres d'entrés:
    $donnees                        : les données du tableau
    $parametres['ID_tableau']       : ID du tableau 
    $parametres['titres_colonnes']  : titres des colonnes
    $parametres['attribut_lignes']  : la valeur de l'attribut d'une ligne
    $parametres['nom_attribut_lignes'] : le nom de l'attribut d'une ligne
       
    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function __construct(array $donnees , $parametres=NULL, $options=0) {
        
    $this->options =  $options;
           
    //Paramètres par défaut
    if (is_array($parametres)) {
        if(isset($parametres['tableau']['id'])  &&  $parametres['tableau']['id'] != '')            {$this->tableau_id          = $parametres['tableau']['id'];}
        if(isset($parametres['tableau']['class']) &&  $parametres['tableau']['class'] != '')       {$this->tableau_class       = $parametres['tableau']['class'];}
        if(isset($parametres['tableau']['attributs']))     {$this->tableau_attributs   = $parametres['tableau']['attributs'];}

        if(isset($parametres['CLASS_colonnes']))        {$this->CLASS_colonnes      = $parametres['CLASS_colonnes'];}
        if(isset($parametres['attribut_ligne']))        {$this->attribut_ligne      = $parametres['attribut_ligne'];}
        if(isset($parametres['nom_attribut_ligne']))    {$this->nom_attribut_ligne  = $parametres['nom_attribut_ligne'];}
        if(isset($parametres['titres_colonnes']))       {$this->titres_colonnes     = $parametres['titres_colonnes'];}
    }
	
	//$this->tableau_attributs ='';
	
    $this->donnees_tableau = $donnees;

    }
    
     /*********************************************************************************************
                                    *** FUNCTION tableau_vide ***

    Cette méthode affiche un tableau HTML.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Le tableau HTML

    Version 	: V2017A
    *********************************************************************************************/
    function tableau_vide() {
   
    //Création du tableau
    switch ($this->options) {
        case AFFICHE_BODY:
             return '<tbody><tr><td>'.$this->tableau_libelle_vide.'</td></tr></tbody>';   
        break;
        default:
			return '<table id="'.$this->tableau_id.'" class="'.$this->tableau_class.'" '.$this->tableau_attributs.'>
                        <thead>'.$this->entete().'</thead>
                        <tfoot>'.$this->pied().' </tfoot>
                        <tbody><tr><td>'.$this->tableau_libelle_vide.'</td></tr></tbody>
                    </table>';
            
    }

    }
    
    /*********************************************************************************************
                                    *** FUNCTION afficher ***

    Cette méthode affiche un tableau HTML.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Le tableau HTML

    Version 	: V2017A
    *********************************************************************************************/
    function afficher() {
    
    if(!is_array($this->donnees_tableau) || count($this->donnees_tableau) == 0 ){return $this->tableau_vide();}    
    
    //Création du tableau
    switch ($this->options) {
        case AFFICHE_BODY:
             return '<tbody>'.$this->corps().'</tbody>';   
        break;

        default:
			return '<table id="'.$this->tableau_id.'" class="'.$this->tableau_class.'"  '.$this->tableau_attributs.'>
                        <thead>'.$this->entete().'</thead>
                        <tfoot>'.$this->pied().' </tfoot>
                        <tbody>'.$this->corps().'</tbody>
                    </table>';
            
    }

    }

    /*********************************************************************************************
                                *** FUNCTION entete ***

    Cette méthode affiche le titre des colonnes dans l'entete du tableau.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    private function entete() {

    $StrData = '';
    
    if ($this->CLASS_colonnes != '') {
        $class = 'class="'.$this->CLASS_colonnes.'"';  
    }else{
        $class = '';
    }
       
    if(is_array($this->titres_colonnes)) {
        foreach($this->titres_colonnes as $index => $titre){
            $StrData .= '<th '.$class.' >'.$titre.'</th>';
        }
    }else{
        $StrData = '<th>'.$this->titres_colonnes.'</th>' ;       
    }    
       
    return '<tr>'.$StrData.'</tr>';

    }


    /*********************************************************************************************
                                    *** FUNCTION corps ***

    Cette méthode affiche le corps du tableau.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    private function corps() {

    $StrData = '';
      
    foreach($this->donnees_tableau as $index => $lignes){
        $StrData .= '<tr '.$this->data_ligne($index).' >'.$this->lignes($lignes).'</tr>';
    }   

    return $StrData;
    }

    /*********************************************************************************************
                                    *** FUNCTION lignes ***

    Cette méthode ajout des lignes dans le tableau.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    private function lignes($lignes) {

    $StrData = '';
    if ($this->CLASS_colonnes != '') {
        $class = 'class="'.$this->CLASS_colonnes.'"';  
    }else{
        $class = '';
    }
    
    if(is_array($lignes)) {
        foreach($lignes as $index => $ligne){
            $StrData .= '<td '.$class.'>'.$ligne.'</td>';
        }   
    }else{
         $StrData = '<td '.$class.'>'.$lignes.'</td>';
    }
    
    return $StrData;
    }


    /*********************************************************************************************
                                    *** FUNCTION afficher ***

    Cette méthode initialise l'objet.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    private function pied() {

    return;
    
    }

    /*********************************************************************************************
                                    *** FUNCTION data_ligne ***

    Cette méthode ajout d'un attribut dans la ligne du tableau.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    private function data_ligne($indexLigne) {

    if (!is_array($this->attribut_ligne)) {return '';}

    return $this->nom_attribut_ligne.'='.$this->attribut_ligne[$indexLigne];
    }
}
?>
