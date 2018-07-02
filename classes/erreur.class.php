<?php
/*Cette classe ecrit dans un fichier texte les informations de log

Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
public static function creation()                       : Cette méthode crée un singleton de l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
public function __call($name, $arguments)		: Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public static function __callStatic($name, $arguments)	: Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
private function __construct()              		: Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __destruct()  					: Cette méthode écrit dans le fichier puis détruit l'instance de l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
afficher(array $Tparametres, $log=NULL)			: Cette méthode incrémente un tableau contenet les erreurs. Si le paramètre $log est renseigné, on met à jour le fichier de log.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function liste()					: Cette méthode lit un membre de la classe (log::lignes).


*/
class erreur{
	
    //Constantes de la classes
    const FICHIER_LOG		= 'erreur';

    //Propriétées privées de la classe
    private $lignes		= [];
    
    //Propriétées static de la classe
    private static $_instance 	= null;


    /*********************************************************************************************
                                    *** FUNCTION creation ***

    Cette méthode crée un singleton de l'objet. 

    Paramètre d'entrée:
    aucun

    Résultat retourné:
    L'instance de l'objet

    Version 	: V2017A
    *********************************************************************************************/	
    public static function creation() {

    if(is_null(self::$_instance)) {
            self::$_instance = new erreur(); 
    }	 

    return self::$_instance;
    }

    /*********************************************************************************************
                                    *** FUNCTION __call ***

    Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet. 

    Paramètre d'entrée:
    $name		: nom de la méthode
    $arguments	: tableau d'argument de la méthode

    Résultat retourné:
    aucun

    Version 	: V2017A
    *********************************************************************************************/	
    public function __call($name, $arguments) {
    $this->afficher(['numero'=>2,'['.__CLASS__.'::'.$name.']']);	
    }

    /*********************************************************************************************
                                    *** FUNCTION __callStatic ***

    Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique. 

    Paramètre d'entrée:
    $name		: nom de la méthode
    $arguments	: tableau d'argument de la méthode

    Résultat retourné:
    aucun

    Version 	: V2017A
    *********************************************************************************************/	
    public static function __callStatic($name, $arguments) {
        erreur::creation()->afficher(['numero'=>2,'['.__CLASS__.'::'.$name.']']);	
    }

    /*********************************************************************************************
                                                    *** FUNCTION __construct ***

    Cette méthode initialise l'objet.

    Paramètre d'entrée:
    aucun
     
    Résultat retourné:
    aucun
      
    Version 	: V2017A
    *********************************************************************************************/
    private function __construct() {
    }

    /*********************************************************************************************
                                                    *** function __destruct ***

    Cette méthode est appellé lors de la destruction de  l'objet.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun
    *********************************************************************************************/
    function __destruct() {
    
    }

    /*********************************************************************************************
                                                    *** FUNCTION afficher ***

    Cette méthode incrémente un tableau contenet les erreurs. Si le paramètre $log est renseigné, on met à jour le fichier de log.

    Paramètre d'entrée:
    $Tparametres['numero']  : numéro de l'erreur
    $Tparametres[x]         : argument de l'erreur (5 max), exemple : 'Erreur(%s) : %s' le message contient 2 arguments %s
    $log                    : objet log
     
    Résultats retournés:
    Le contenu du tableau d'erreurs

    Version 	: V2017A 
    *********************************************************************************************/
    function afficher(array $Tparametres, $log=NULL) {
           
    list($titre,$details) = message::cherche_texte($Tparametres,erreur::FICHIER_LOG); 
	
    //On ajoute le défaut dans le fichier log si paramètre renseigné
    if ($log != null) {	$log->ligne(['numero'=>4,$titre,$details],erreur::FICHIER_LOG);}

    //Ajout ligne
    array_push($this->lignes,conversion::format_chaine($titre.'|'.$details));

    return $this->lignes;

    }

    /*********************************************************************************************
                                                    *** FUNCTION liste ***

    Cette méthode retourne le tableau contenant les erreurs.

    Paramètre d'entrée:
    Aucun

    Résultats retournés:
    Le contenu du tableau d'erreurs

    Version 	: V2017A 
    *********************************************************************************************/
    function liste() {

    return $this->lignes;

    }

}

?>
