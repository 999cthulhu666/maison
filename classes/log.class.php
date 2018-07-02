<?php
/*Cette classe écrit dans un fichier texte les informations de log.

Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
public static function creation($FichierLog='')			: Cette méthode crée un singleton de l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
public function __call($name, $arguments)				: Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public static function __callStatic($name, $arguments)	: Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
private function __construct($FichierLog)				: Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __destruct()  									: Cette méthode écrit dans le fichier puis détruit l'instance de l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function fichier($valeur='')                : Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::fichier).

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function chemin($valeur='')                 : Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::chemin).

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function nom($valeur='')                    : Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::chemin).

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function ligne($entete,$corps,$fichier='')  : Cette méthode ajoute une ligne dans le fichier de log.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function liste()                            : Cette méthode lit un membre de la classe (log::lignes).

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function ecriture_lignes()                  : Cette méthode écrit une/des lignes dans le fichier de log.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function lit_fichier($fichier)              : Cette méthode lit un fichier de log..

  
*/

class log{
	
    //Constantes de la classes
    const FICHIER_LOG			= 'sql';
    const EXTENSION_FICHIER_LOG	= '.txt';
    const LONGUEUR_LIGNE_LOG	= 150;

    //Propriétées privées de la classe
    private $lignes			= [];
    private $fichier		= '';	//Fichier de log (chemin/nom.txt)
    private $nom			= '';	//Nom du fichier de log
    private $chemin			= '';	//Chemin du fichier 
    private $nom_client		= '';	//Nom du client 
    
    //Propriétées static de la classe
    private static $_instance 	= null;
    private static $_utilisateurs= null;	//Objet utilisateur 

    /*********************************************************************************************
                                    *** FUNCTION creation ***

    Cette méthode crée un singleton de l'objet. 

    Paramètre d'entrée:
    $log : nom du log 'sql', 'erreur', 'prod'

    Résultat retourné:
    L'instance de l'objet

    Version 	: V2017A
    *********************************************************************************************/	
    public static function creation( $_utilisateurs = null) {

    if(is_null(self::$_instance)) {
        self::$_instance = new log(log::FICHIER_LOG); 
    }
    
    self::$_utilisateurs = $_utilisateurs;
    
    return self::$_instance;
    }

    /*********************************************************************************************
                                    *** FUNCTION __call ***

    Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet. 

    Paramètre d'entrée:
    $name	: nom de la méthode
    $arguments	: tableau d'argument de la méthode

    Résultat retourné:
    aucun

    Version 	: V2017A
    *********************************************************************************************/	
    public function __call($name, $arguments) {
        $this->ligne(['numero'=>2,__CLASS__.'::'.$name],'erreur');
    }

    /*********************************************************************************************
                                    *** FUNCTION __callStatic ***

    Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique. 

    Paramètre d'entrée:
    $name	: nom de la méthode
    $arguments	: tableau d'argument de la méthode

    Résultat retourné:
    aucun

    Version 	: V2017A
    *********************************************************************************************/	
    public static function __callStatic($name, $arguments) {
        log::creation()->ligne(['numero'=>2,__CLASS__.'::'.$name],'erreur');	
    }

    /*********************************************************************************************
                                *** FUNCTION __construct ***

    Cette méthode initialise l'objet.

    Paramètre d'entrée:
    $log : nom du fichier log
    
    Résultat retourné:
    aucun
      
    Version 	: V2017A
    *********************************************************************************************/
    private function __construct(string $log) {

    $this->fichier(PHP_ROOT_LOG.$log.log::EXTENSION_FICHIER_LOG);	
    $this->chemin(PHP_ROOT_LOG);
    $this->nom($log);
    //$this->nom_client = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    }

    /*********************************************************************************************
                                *** function __destruct ***

    Cette méthode écrit dans le fichier puis détruit l'instance de l'objet.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun
    *********************************************************************************************/
    function __destruct() {
    $this->ecriture_lignes();
    }

    /******************************************************************************************
                            *** FUNCTION fichier ***

    Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::fichier).

    Paramètres d'entrées:
    $valeur	: dans le cas d'une écriture

    Résultat retourné:
    Valeur du membre

    Version 	: V2017A
    ******************************************************************************************/
    function fichier(string $valeur='') {

    if ($valeur=='') {
            //GETTER
            return $this->fichier;
    }
    else{
            //SETTER
            return $this->fichier = $valeur; 
    }
    }

    /******************************************************************************************
                            *** FUNCTION chemin ***

    Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::chemin).

    Paramètres d'entrées:
    $valeur	: dans le cas d'une écriture

    Résultat retourné:
    Valeur du membre

    Version 	: V2017A
    ******************************************************************************************/
    function chemin(string $valeur='') {

    if ($valeur=='') {
            //GETTER
            return $this->chemin;
    }
    else{
            //SETTER
            return $this->chemin = $valeur;
    }
    }

    /******************************************************************************************
                            *** FUNCTION nom ***

    Cette méthode permet d'accéder au membre de la classe en lecture/écriture (log::nom).

    Paramètres d'entrées:
    $valeur	: dans le cas d'une écriture

    Résultat retourné:
    Valeur du membre

    Version 	: V2017A
    ******************************************************************************************/
    function nom(string $valeur='') {

    if ($valeur=='') {
            //GETTER
            return $this->nom;
    }
    else{
            //SETTER
            return $this->nom = $valeur; 
    }
    }



    /*********************************************************************************************
                                                    *** FUNCTION ligne ***

    Cette méthode ajoute une ligne dans le fichier de log.

    Paramètre d'entrée:
    $entete			: entete ligne log
    $corps			: texte 
    $fichier		: chemin/fichier.txt si different de la valeur par défaut (log::FICHIER_LOG)

    Résultat retourné:
    aucun

    Version 	: V2017A 
    *********************************************************************************************/
    function ligne(array $Tparametres,string $log='') {
	
    if ($log != ''){
            $nomLog = $log;	
    }else{
            $nomLog = $this->nom();
    }	

    //On cherche le message
    list($entete,$corps) = message::cherche_texte($Tparametres,$nomLog);

    //Nom du log : xx_nom avec xx dernier chiffre de l'adresse IP du client 
    $nomLog = conversion::numero_ip($_SERVER['REMOTE_ADDR']).'_'.$nomLog;
    
    //On récupère l'utilisateur courant
    if (method_exists(self::$_utilisateurs->utilisateur,'nom')){
        $nom = self::$_utilisateurs->utilisateur->nom();
    }else{
        $nom ='systeme';
    }
    
    //Ligne de base du fichier de log 
    $ligne_base_log = date('d/m/Y H\:i\:s').' | '.conversion::format_chaine($nom).' | '.conversion::format_chaine($entete).' | ';
        
    //Ajout ligne
    $this->lignes[$nomLog][] = $ligne_base_log.conversion::format_chaine($corps);
       
    }

    /*********************************************************************************************
                                *** FUNCTION liste ***

    Cette méthode lit un membre de la classe (log::lignes). 
    Le nom du log est sous la forme : xx_nom ou xx est le dernier chiffre de l'adresse IP du client.
    On enleve le xx_.

    Paramètre d'entrée:
    Aucun

    Résultat retourné:
    Le tableau contenant les logs sous la forme $log[nom du log] = contenu du log.

    Version 	: V2017A 
    *********************************************************************************************/
    function liste() {

    //Initialisation des variables        
    $log =[];
    
    foreach ($this->lignes as $key => $contenuLog) {
        $nomLog = substr(strrchr($key,'_'),1);
        $log[$nomLog] = $contenuLog;
    }
    return $log;

    }

    /*********************************************************************************************
                                *** FUNCTION ecriture_lignes ***

    Cette méthode écrit une/des lignes dans le fichier de log.

    Paramètre d'entrée:
    Aucun

    Version 	: V2017A 
    *********************************************************************************************/
    function ecriture_lignes() {
		
    foreach ($this->lignes as $nomLog => $contenuLog) {

        $ligne = '';

        foreach ($contenuLog as $key => $value) {
            $ligne .= str_pad(htmlspecialchars_decode($value,ENT_QUOTES),log::LONGUEUR_LIGNE_LOG)."\n";
        }

        //Nom du fichier
        $fichier = $this->chemin.$nomLog.log::EXTENSION_FICHIER_LOG;
				
        //Ecriture fichier log
        if ($handle = fopen($fichier, 'a')) {
            // Ecrivons la ligne dans le fichier
            fwrite($handle, $ligne );
            fclose($handle);
        }else{
            return false;
        }
    }

    }

    /*********************************************************************************************
                                *** FUNCTION lit_fichier ***

    Cette méthode lit un fichier de log. 
    
    Paramètre d'entrée:
    $fichier : nom du fichier à récupérer

    Résultat retourné:
    Le tableau contenant le contenu du log.

    Version 	: V2017A 
    *********************************************************************************************/
    function lit_fichier($fichier) {
    
    //conversion::is_file('test.php');    
    //$this->ligne(['numero'=>10,'/log/90_prod.txt',__METHOD__],LOG_ERREUR);
    
    $log_prod = fichier::lit_fichier('/log/90_prod.txt');
    $log_sql = fichier::lit_fichier('/log/90_sql.txt');
    $log_erreur = fichier::lit_fichier('/log/90_erreur.txt');
    
    foreach ($log_prod as $key => $ligne) {
       list($date,$utilisateur,$fonction,$commentaire) = explode("|", $ligne);
       if (trim($date) != ''){
            $temp[0] = trim($date);
            $temp[1] = 'production';
            $temp[2] = trim($utilisateur);
            $temp[3] = trim($fonction);
            $temp[4] = trim($commentaire);
            $contenu[] = $temp;
       }
    }
    
    foreach ($log_sql as $key => $ligne) {
       list($date,$utilisateur,$fonction,$commentaire) = explode("|", $ligne);
       if (trim($date) != ''){
            $temp[0] = trim($date);
            $temp[1] = 'SQL';
            $temp[2] = trim($utilisateur);
            $temp[3] = trim($fonction);
            $temp[4] = substr(trim($commentaire),0,130);
            $contenu[] = $temp;
       }
    }
    
    foreach ($log_erreur as $key => $ligne) {
       list($date,$utilisateur,$fonction,$commentaire) = explode("|", $ligne);
       if (trim($date) != ''){
            $temp[0] = trim($date);
            $temp[1] = 'erreur';
            $temp[2] = trim($utilisateur);
            $temp[3] = trim($fonction);
            $temp[4] = substr(trim($commentaire),0,130);
            $contenu[] = $temp;
       }
    }
       
    return $contenu;
    
    }

    
}
?>
