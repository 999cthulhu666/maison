<?php
/*

Nom classe 	:	conversion
Commentaire	:	Cette classe contient des méthodes diverses de conversions.
Version		: 	2017A
 
Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function DateMySql_to_DateString($date)					: Cette méthode converti une date sql.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function cherche_nom_fichier($valeur='')				: Cette méthode d'isoler le nom du fichier dans un chemin complet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
function cherche_chemin_fichier($valeur='')				: Cette méthode permet de chercher le répertoire dans lequel se trouve le fichier.


*/

class fichier{
    //Variables propre à la classe	
    private static $valeur_fichier_ini;	
        
    /*********************************************************************************************
                                    *** FUNCTION ini_lit ***

    Renvoie la valeur d'un paramètre de configuration

    Paramètres d'entrés:
    $nom                : nom de la section dans le fichier .ini
    $valeurParDefaut	: valeur

    Résultats retournés:
    La valeur lut dans le fichier ini
     
    Version 	: V2017A
    *********************************************************************************************/
    public static function ini_lit($nom, $valeurParDefaut = NULL) {
    if (isset(self::ini_fichier()[$nom])) {
      $valeur = self::ini_fichier()[$nom];
    }
    else {
      $valeur = $valeurParDefaut;
    }
    return $valeur;
    }

    /*********************************************************************************************
                                    *** FUNCTION ini_fichier ***

    Renvoie le tableau des paramètres en le chargeant au besoin

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun
      
    Version 	: V2017A 
    *********************************************************************************************/
    private static function ini_fichier() {
    if (self::$valeur_fichier_ini == NULL) {
        if (!file_exists(PHP_ROOT_INI)) {
            log::creation()->ligne(['numero'=>10,PHP_ROOT_INI,__METHOD__],'erreur');
        }
        else {
            self::$valeur_fichier_ini = parse_ini_file(PHP_ROOT_INI,true);
        }
    }
    return self::$valeur_fichier_ini;
    }
    
    /*********************************************************************************************
                                *** FUNCTION is_file ***

    Cette méthode test si le fichier est présent. 

    Paramètres d'entrés:
    $fichier : le fichier à tester

    Résultats retournés:
    Le nom du fichier si il est disponible sinon FALSE

    Version 	: V2017A
    *********************************************************************************************/
    static function is_file($fichier) {
    if(!file_exists($fichier)) {
        erreur::creation()->afficher(['numero'=>12,$fichier],log::creation()->ligne(['numero'=>10,$fichier,__METHOD__],LOG_ERREUR));
        return false;
    }
    return $fichier;
    }
    
    /*********************************************************************************************
                                *** FUNCTION is_file ***

    Cette méthode test si le fichier est présent. 

    Paramètres d'entrés:
    $fichier : le fichier à tester

    Résultats retournés:
    Le nom du fichier si il est disponible sinon FALSE

    Version 	: V2017A
    *********************************************************************************************/
    static function lit_fichier($fichier) {
    
    if(!self::is_file($_SERVER["DOCUMENT_ROOT"].$fichier)){
        return false;
    }
    
    $handle = @fopen($_SERVER["DOCUMENT_ROOT"].$fichier, "r");
    
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            $file[] = $buffer;
        }
        if (!feof($handle)) {
            return false;
        }
        fclose($handle);
    }
    
    return $file;
    }
    
}
?>
