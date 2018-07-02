<?php
/*
Nom classe 	: maison
Commentaire	: Classe principal du site, elle gère l'initialisation et les classes dépendantes.
Version		: 2017Aa

________________________________________________________________________________________________________
--------------------------------------------------------------------------------------------------------
--------------------------------- Historique des révisions  --------------------------------------------
--------------------------------------------------------------------------------------------------------
Version        Date         Commentaire



________________________________________________________________________________________________________ 

Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __construct()				: Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __destruct()				: Cette méthode est appellé lors de la destruction de  l'objet. On ferme la connection au serveur SQL.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public function __call($name, $arguments)	: Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public static function __callStatic($name, $arguments)	: Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public root(string $valeur='')                  : Ces méthodes permettent de lire/écrire les membres de la classe.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public version()                                : Cette méthode renvoie le numéro de version de l'application.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public temps_execution()                        : Cette méthode calcul le temps d'éxecution de la page.

*/


//Include automatique des classes 
spl_autoload_register(function ($class) {
	//echo PHP_CLASS_ROOT.'  	'.$class.'.class.php</br>';
    include PHP_CLASS_ROOT.'/'.str_replace('\\','/',$class).'.class.php';
});

class maison{
	
    //Constantes de la classes
    const VERSION								= 'V2018';
    const REVISION_MAJEUR                       = 'A';
    const REVISION_MINEUR                       = 'a';

    //Variables public
    public $utilisateurs                        = NULL;	
	public $log                                 = NULL;
    public $erreur								= NULL;
    public $multimedia							= NULL;
    
    //Variables privées
    private $root                                = '';
    private $page                                = '';
    private $fichier                             = '';
    private $tempsDebutPage;
    private $autorisation_acces                  = false;
    
    /*********************************************************************************************
                                    *** FUNCTION __construct ***

    Cette méthode initialise l'objet.

    Paramètres d'entrés:
    $context['root'] : répertoire racine du site
    $context['page'] : nom de la page courante 
     
    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function __construct($context) {
    
    //Temps de départ du script
    $this->tempsDebutPage = microtime(true);
		
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    //Contexte de l'application
    $this->root($context['root']);  //Emplacement du site
    $this->page($context['page']);  //Nom de la page courante
        
    $this->configuration(); //constantes 
    $this->session();       //Variables de sessions
    	
    if (!isset($context['multimedia'])){$context['multimedia'] = $_SESSION['S_multimedia'];}
        
    //Méthodes de la classe
    $this->utilisateurs = new utilisateurs();                   //Gestion des utilisateurs							
    $this->erreur 		= erreur::creation();                   //Création du gestionnaire des erreurs
    $this->log 			= log::creation($this->utilisateurs);	//Création des logs
    $this->multimedia	= new gestion_multimedia($context['multimedia']); 
    $this->recette		= new gestion_recette(); 
    
    $this->fichier(conversion::cherche_nom_fichier($this->page())); //Nom du fichier
    
    //Sur la page de connexion du site on ne demande pas encore d'authentification
    $page = fichier::ini_lit("PAGE");
    
	
	
    if ($page['premiere'] !=  $this->fichier) {
        $this->autorisation_acces = $this->utilisateurs->authentification();
    }else{
        $this->autorisation_acces = true;   //Premier page
    }
    
    }
       
    
    /*********************************************************************************************
                                *** function __destruct ***

    Cette méthode est appellé lors de la destruction de  l'objet. On ferme la connection au serveur SQL.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function __destruct() {}


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
    $this->erreur->afficher(['numero'=>2,'['.__CLASS__.'::'.$name.']'],$this->log);	
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
    
    /******************************************************************************************
                            *** Accesseur / Mutateur de la classe ***

    Ces méthodes permettent de lire/écrire les membres de la classe.

    Version 	: V2017A
    ******************************************************************************************/
    function root(string $valeur='') {
    if ($valeur=='') {return $this->root;}else{return $this->root = $valeur;}
    }
    
    function page(string $valeur='') {
    if ($valeur=='') {return $this->page;}else{return $this->page = $valeur;}
    }
    
    function fichier(string $valeur='') {
    if ($valeur=='') {return $this->fichier;}else{return $this->fichier = $valeur;}
    }
    
    /*********************************************************************************************
                                *** function version ***

    Cette méthode renvoie le numéro de version de l'application.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function version() {
    return  maison::VERSION.maison::REVISION_MAJEUR.maison::REVISION_MINEUR;   
    }
   
    /*********************************************************************************************
                                *** function temps_execution ***

    Cette méthode calcul le temps d'éxecution de la page.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function temps_execution() {
                
    list($TtempsPage['debut'],$TtempsPage['fin'],$TtempsPage['duree']) = conversion::temps_execution( $this->tempsDebutPage,  microtime(true));
        
    return  $TtempsPage;    
    }
    
    /*********************************************************************************************
                                    *** FUNCTION rapport ***

    Cette méthode crée un rapport sur les logs, les erreurs contenu dans la page courante.

    Paramètre d'entrée:
    aucun

    Résultats retournés:
    $rapport['page']		: non de la page qui a généré le rapport
    $rapport['trace']		: log de la page pour affichage dans la console
    $rapport['erreur']		: erreur de la page pour affichage dans la page

    Version 	: V2017A
    *********************************************************************************************/
    function rapport() {

    $page['page'] 		= $this->page();	
    $log['trace'] 		= $this->log->liste();
    $erreur['erreur'] 	= $this->erreur->liste();
    $temps['temps'] 	= $this->temps_execution();
    
    $rapport['rapport'] = array_merge($page,$log,$erreur,$temps);
	
    return $rapport;
    }
    
    /*********************************************************************************************
                                        *** FUNCTION configuration ***

    Cette méthode définie toutes les constantes du projets. 

    Paramètres d'entrés:
	aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function configuration() {
       
    define("PHP_SESSIONS_ROOT_COMMUN"	,$this->root()."/tmpses");                          //Répertoire contenant les fichiers de sessions	
    define("PHP_CLASS_ROOT"				,$this->root()."/classes");                         //Répertoire contenant les classes communes
    define("JS_ROOT"                    ,$this->root()."/js");                              //Répertoire contenant les classes communes
    define("VUES_STD_ROOT"              ,$this->root()."/vues/std");                        //Répertoire contenant les vues standards
    define("VUES_ROOT"                  ,$this->root()."/vues/vue_");                        //Répertoire contenant les vues standards
    define("PHP_ROOT_INI"				,$this->root()."/admin/configuration.ini");         //Répertoire contenant le fichier .ini	
    define("PHP_ROOT_LANGUE"			,$this->root()."/langue/");                         //Répertoire contenant les fichiers de traductions	
    define("PHP_ROOT_LOG"				,$this->root()."/log/");                            //Répertoire contenant les fichiers de traductions	
    define("PHP_INCLUDE_ROOT"			,$this->root()."/includes");                        //Répertoire contenant les includes
    define("INCLUDE_ROOT"				,"/includes");                                      //Répertoire contenant les includes		
    define("IMAGES_ROOT"				,"/images");                                        //Répertoire contenant les includes		
    define("PLUGINS_ROOT"				,"/includes/plugins");                              //Répertoire contenant les plugins
    define("FRAMEWORK_ROOT"				,"/includes/framework/v3.2.1/jquery-3.2.1.min.js"); //Répertoire contenant le framework jquery : version 3.2.1	
    define("CSS_ROOT"					,"/css");                                           //Répertoire contenant les fichiers css
    define("PLUGINS_ROOT_UI"            ,"/includes/plugins/JqueryUI/v1.12.1");             //Répertoires JQUERY UI : version 1.12.1
    define("CSS_ROOT_UI"				,"/css/JqueryUI/v1.12.1");                          //Répertoires JQUERY UI : version 1.12.1
    define("PLUGINS_ROOT_BS"			,"/includes/plugins/bootstrap/v3.3.7/js");          //Répertoires JQUERY BOOTSTRAP : version 3.3.7
    define("CSS_ROOT_BS"				,"/includes/plugins/bootstrap/v3.3.7/css");         //Répertoires JQUERY BOOTSTRAP : version 3.3.7
    define("PHP_LOG_ROOT"				,$this->root()."/log");                             //Répertoire contenant les fichiers de log
    
    //Divers
    define('ANNEE_COURANTE'		,date("Y"));                                        //Année courante
    define('NBR_MAX_TENTATIVE_CONNEX'	,10);                                               //Nombre maximun de tentative de connexion
        
    //Log : log.class
    define('LOG_PRODUCTION'             ,'prod');                                               
    define('LOG_SQL'                    ,'sql');                                              
    define('LOG_ERREUR'                 ,'erreur');   
    
    //SQL : BD.class
    define('JEUX_RESULTAT_ASSOCIATIF'   ,true);                                             //Résultat de la requete SQL sous forme simplifié (un seul jeux de résultat)   
    
    //Tableau : tableau_html.class
    define('AFFICHE_TOUS'                 ,0);  
    define('AFFICHE_BODY'                 ,1);  
    
    }
	
    /*********************************************************************************************
                                        *** FUNCTION session ***

    Cette méthode initialise les variables de session 

    Paramètres d'entrés:
	aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function session() {
        
    session_save_path(PHP_SESSIONS_ROOT_COMMUN);	//On stock les variables de session dans le repertoire /tmpses du serveur.

    session_name('Client');	//Nom de la session

    session_start();	//D�marrage et initialisation des variables de session

    if (!isset($_SESSION['S_tentative_connexion'])) {$_SESSION['S_tentative_connexion']     = 0 ;} 
    if (!isset($_SESSION['S_utilisateur']))         {$_SESSION['S_utilisateur']             = NULL;} 
    if (!isset($_SESSION['S_multimedia']))         	{$_SESSION['S_multimedia']             	= 'FILMS';} 
    
    }
    
    /*********************************************************************************************
                                        *** FUNCTION html_head ***

    Cette méthode affiche dans la page l'entête du fichier HTML 

    Paramètres d'entrés:
    $Tparametres['titre']      : titre de la page
    $Tparametres['charset']    : type de codage de la page (optionnel)
    $Tparametres['scripts']    : scripts additionnelles
      
    Résultats retournés:
    L'entête <head>...</head> de la page.

    Version 	: V2017A 
    *********************************************************************************************/
    function html_head(array $Tparametres) {
    
    ob_start();
    
    $titre      = $Tparametres['titre'];    //Titre de la page
    $codage     = $Tparametres['charset'];  //Codage de la page
        
    $contenu    = $this->link();            //Fichiers .css
    
    //Insertion des scripts spécifiques à la page
    if (is_array($Tparametres['css'])) {
        foreach($Tparametres['css'] as $fichier_CSS) {
            $contenu .= '<link type="text/css" href="'.$fichier_CSS.'" rel="stylesheet" />'."\n";
        }
    }
      
    $contenu    .= $this->script($Tparametres['scripts']);         //Scripts communs
      
    $contenu    .= "<!--Fin script coté client-->\n";               //Commentaire   
        
    require PHP_INCLUDE_ROOT.'/head.html';  //Fichier HEAD  
        
    return ob_get_clean();
    }
    
    /*********************************************************************************************
                                *** FUNCTION link ***

    Cette méthode insert les balises <link>...</link>.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    les fichier .css et tout le contenu entre les balises <link>...</link>

    Version 	: V2017A
    *********************************************************************************************/
    function link() {
    ob_start();
    
    require PHP_INCLUDE_ROOT.'/link.html';
    
    return ob_get_clean();
    }
    
    /*********************************************************************************************
                                *** FUNCTION script ***

    Cette méthode insert les balises <script>....</script> dans la page avec les scripts commun + le script propre à la page.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Les scripts communs à la page <script>....</script> ainsi que le scripte propre à la page.

    Version 	: V2017A
    *********************************************************************************************/
    function script($scripts) {
      
    ob_start();
    
    require PHP_INCLUDE_ROOT.'/script.html';
    
    $contenu = ob_get_clean();
    
    //Insertion des scripts spécifiques à la page
    if (is_array($scripts)) {
        foreach($scripts as $fichier_script) {
            $contenu .= '<script type="text/javascript" src="'.$fichier_script.'"></script>';
        }
    }
    
    $contenu .=$this->js_page();
        
    return $contenu;
    }
    
    /*********************************************************************************************
                                *** FUNCTION js_page ***

    Cette méthode insert les scripts javascript propre à la page. 

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Les scripts propre à la page (nom page.js)

    Version 	: V2017A
    *********************************************************************************************/
    function js_page() {
    $fichier = fichier::is_file(JS_ROOT.'/'.$this->fichier.'.js');
    
    $contenu = "\n<!--Début script coté client-->\n"; 
    $contenu .= '<script>'; 
    
    ob_start();    
    
    require PHP_INCLUDE_ROOT.'/initialisation.js';  //Script d'initialisation
     
    if ($fichier !== false){ require $fichier;}     //Script propre à la page 
    
    require PHP_INCLUDE_ROOT.'/fin.js';             //Script de fin
    
    $contenu .= ob_get_clean();
    
    //Si le fichier n'existe pas, on supprimer l'appel à la fonction main() dans le script
    if ($fichier === false){$contenu = str_replace("main();"," ",$contenu);}    
    
    $contenu .= "</script>\n"; 
        
    return $contenu; 
    
    }
      
    
    /*********************************************************************************************
                                *** FUNCTION fenetres ***

    Cette méthode insert les fenêtres de dialogues dans la page. 

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Le code HTML des fenêtres ( fenêtre de dialogue, fenêtre de login)

    Version 	: V2017A
    *********************************************************************************************/
    function fenetres() {
    ob_start();        
    
    //require VUES_STD_ROOT.'/fen_login.php';
    require VUES_STD_ROOT.'/fen_dialogue.php';
    
    return ob_get_clean();
    }
    
    /*********************************************************************************************
                                *** FUNCTION vue ***

    Cette méthode insert la vue courante dans la page. 

    Paramètres d'entrés:
    $variables : tableau contenant les variables à afficher dans la page.

    Résultats retournés:
    Le code HTML de la vue (vue_NOM_DE_LA_PAGE.php).

    Version 	: V2017A
    *********************************************************************************************/
    function vue($variables=null) {
            
    //On vérifie si l'utilisateur à les droits d'accès au site    
    if ($this->autorisation_acces) {
        $fichier = fichier::is_file(VUES_ROOT.$this->fichier.'.php');
    }else{
        $fichier = 'aucun_acces.html';  //Aucun accès au site
    }    
        
    if (!$fichier){return '';}  //Le fichier n'existe pas
    
    if (is_array($variables)){
        extract($variables);    //Extraction des variables de la page
    }    
        
    ob_start();    
    
    require $fichier;   //Inclusion du fichier
    
    return $this->fenetres().ob_get_clean();
    }
   
}
?>
