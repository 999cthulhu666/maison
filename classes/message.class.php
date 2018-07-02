<?php

/*Cette classe recherche les libellés des messages dans un fichier de traduction : 
 francais 	: erreur_fr.inc.php, SQL_fr.inc.php, prod_fr.inc.php 
 anglais 	: erreur_en.inc.php, SQL_en.inc.php, prod_en.inc.php 

Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
private static function creation(string $type='erreur')                           : Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
public static function cherche_texte(array $Tparametres,string $type='erreur')    : Cette méthode cherche un texte d'erreur d'après son index dans le tableau.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function nom_fichier()                              : Cette méthode permet de lire/écrire la propriété de l'objet (message::fichier).

*/
class message{
	
    //Constantes de la classes
    const FICHIER_TRADUCTION	= '%s_%s.inc.php';

    //Propriétées privées de la classe
    private static $Tmessages	= NULL;
    private static $fichier	= '';
    private static $type	= 'erreur';
    
    /*********************************************************************************************
                                    *** FUNCTION __construct ***

    Cette fonction initialise l'instance de l'objet. 

    Paramètre d'entrée:
    aucun

    Résultat retourné:
    aucun

    Version 2017A
    *********************************************************************************************/
    private static function creation() {
            
    //Récupération des paramètres de configuration BD
    $config = fichier::ini_lit("LANGUE");

    //Nom du fichier de traductions des erreurs
    self::$fichier = PHP_ROOT_LANGUE.sprintf(message::FICHIER_TRADUCTION,self::$type,strtolower($config['langue']));
            
    //On vérifie si le fichier existe
    if( !file_exists(self::$fichier) ) {return false;}

    require(self::$fichier);

    return $_histo_messages;

    }

    /*********************************************************************************************
                                    *** méthode cherche_texte ***

    Cette méthode cherche un texte d'erreur d'après son index dans le tableau. 

    Paramètres d'entrés:
    $Tparametres	: ['numero'] index du tableau d'erreurs, [0]->[4] 5 arguments possible.
    $type   (optionnel) : 'erreur' messages d'erreurs (erreur_fr.inc.php) ou 'prod' messages divers (prod_fr.inc.php)

    Résultats retournés:
    Libellé de l'erreur.

    Version 2017A
    *********************************************************************************************/	
    public static function cherche_texte(array $Tparametres,string $type='') {
    
    //On recharge le fichier de traduction si le type de fichier differe    
    if (self::$type !== $type || self::$fichier == '') {
        self::$type = strtolower($type);
        self::$Tmessages = self::creation();
    }
        
    if ($Tparametres['numero'] != NULL)     {$numero = $Tparametres['numero'];}	else{$numero=0;}
    if ($Tparametres[0] != NULL)            {$arg1 =  $Tparametres[0];}	else{$arg1='';}
    if ($Tparametres[1] != NULL)            {$arg2 =  $Tparametres[1];}	else{$arg2='';}
    if ($Tparametres[2] != NULL)            {$arg3 =  $Tparametres[2];}	else{$arg3='';}
    if ($Tparametres[3] != NULL)            {$arg4 =  $Tparametres[3];}	else{$arg4='';}
    if ($Tparametres[4] != NULL)            {$arg5 =  $Tparametres[4];}	else{$arg5='';}

    //Fichier de traduction introuvable
    if (!is_array(self::$Tmessages)) {
        $msg[0] = 'Fichier introuvable';
        $msg[1] = 'Le fichier contenant les traductions n\'existe pas ou n\'est pas dans le bon répertoire ('.self::$fichier.')';
    }else if ($numero){
        $msg = self::$Tmessages[$numero]	;	
    }		

    //Code erroné	
    if ($msg === NULL) {$msg = self::$Tmessages[0];}		

    $titre 		= $msg[0];
    $nombreParametres 	= substr_count($msg[1],'%');

    if ($nombreParametres > 5 ) {
        $titre = '['.__METHOD__.']';
        $details = 'Il y a '.($nombreParametres-5).' paramètres en trop dans le message numéro '.$numero;
    }else{
        $details = sprintf($msg[1],$arg1,$arg2,$arg3,$arg4,$arg5);			
    }
    return [$titre,$details];	

    }

    /*********************************************************************************************
                                *** méthode nom_fichier ***

    Cette méthode permet de lire la propriété de l'objet (message::nomFichier). 

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    La valeur de la propriété.

    Version 2017A
    *********************************************************************************************/	
    public static function nom_fichier() {
    return self::$fichier;
    }
	     
}

?>
