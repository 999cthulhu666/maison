<?php
/*
Nom classe 	:	BD
Commentaire	:	Cette classe assure la connection à la base de données ainsi que la gestion des requetes.
Version		: 	2017A

________________________________________________________________________________________________________
--------------------------------------------------------------------------------------------------------
--------------------------------- Historique des révisions  --------------------------------------------
--------------------------------------------------------------------------------------------------------
Version        Date         Commentaire



________________________________________________________________________________________________________ 


Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __construct()									: Cette méthode initialise l'objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
function __destruct()									: Cette méthode est appellé lors de la destruction de  l'objet. On ferme la connection au serveur SQL.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public function __call($name, $arguments)				: Cette méthode __call() est appelée lorsque l'on invoque des méthodes inaccessibles dans un contexte objet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
public static function __callStatic($name, $arguments)	: Cette méthode __callStatic() est lancée lorsque l'on invoque des méthodes inaccessibles dans un contexte statique.

*/

class BD {
	
    //Constantes de la classes
    const VERSION				= '[Microsoft][ODBC Driver 13 for SQL Server]';
    
    //Variables public 
    public $erreur						= NULL;	
    public $log                         = NULL;	
    public $SQL_id_insert				= null;
    public $SQL_nbr_lignes_modifier		= 0;
    
    //Variables privées
    private $SQL 						= NULL;
    private $SQL_req_erreur				= false;

    private static $BD					= NULL;
    private static $SQL_connection_erreur= false;	
    private static $SQL_err_no			= 0;	
    private static $SQL_err_msg			= 'Aucune erreur';	

    private $temps_debut_SQL			= 0;
    private $temps_fin_SQL				= 0;
    private $duree_SQL                  = 0;
    private $jeux_resultat_associatif;
        
    /*********************************************************************************************
                                                    *** FUNCTION __construct ***

    Cette méthode initialise l'objet.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    protected function __construct() {
    
    // Désactiver le rapport d'erreurs
    error_reporting(0);
    
    $this->log 		= log::creation();                              //Création objet log
    $this->erreur 	= erreur::creation();							//Création objet affichage erreur
    $this->SQL 		= self::creation_BD($this->erreur,$this->log);	//Accès à la base de donnée

    // Rapporte les erreurs d'exécution de script
    error_reporting(E_ERROR | E_WARNING | E_PARSE);		
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
    function __destruct() {
    if (is_resource($this->SQL)) {$this->SQL->close();}	
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

    }
       
    /*********************************************************************************************
                                        *** FUNCTION SQL_erreur ***

    Cette méthode verifie si une erreur s'est produite dans la connection à la base ou dans une requete.

    Paramètre d'entrée:
    aucun

    Résultats retournés:
    FALSE aucune erreur

    Version 	: V2017A
    *********************************************************************************************/
    public function SQL_erreur() {

    return $this->SQL_req_erreur || self::$SQL_connection_erreur;

    }
   

    /*********************************************************************************************
                                                    *** FUNCTION creation_BD ***

    Cette méthode crée l'instance de l'objet mysql.

    Paramètres d'entrés:
    $erreur	: gestion des erreurs 
    $log	: gestion du log

    Résultats retournés:
    L'instance de l'objet.

    Version 	: V2017A
    *********************************************************************************************/  
    private static function creation_BD($erreur,$log) {
	
	if (self::$BD=== null) {
		// Récupération des paramètres de configuration BD
		$config = fichier::ini_lit("BD");
			 				
		// Création de la connexion
		self::$BD= new mysqli(trim($config['serveur']),trim($config['identifiant']),trim($config['mdp']),trim($config['nom']));
		
		var_dump(htmlspecialchars(self::$BD->connect_error,ENT_QUOTES))	;
			
		if (self::$BD->connect_errno) {
			erreur::creation()->afficher([numero=>1,self::$BD->connect_errno,self::$BD->connect_error],log::creation());
			self::$SQL_connection_erreur = true;
		}

	}
	return self::$BD;
    
    }
    

    /*********************************************************************************************
                                    *** FUNCTION SQL_exec_requete ***

    Execution de la requete SQL.

    Paramètres d'entrés:
    $strRequete					: requete SQL
    $parametres					: tableau de paramètres ou objet de paramètres
	$jeux_resultat_associatif	: TRUE on simplifie le résultat de la requete
	
    Résultats retournés: 
    Le resultat de la requete ou FALSE si erreur

    Version		: 	2017A
    *********************************************************************************************/
    protected function SQL_exec_requete(string $strRequete,$parametres=[],$jeux_resultat_associatif = false) {
                       
    if (self::$SQL_connection_erreur) {return false;}	//Erreur de connexion à la base
        
    if (is_bool($parametres)) {
		$this->jeux_resultat_associatif = $parametres;
	}else{
		$this->jeux_resultat_associatif = $jeux_resultat_associatif;
	}	
        
    //On vérifie si il s'agit d'une procédure stocker
    if ($this->is_procedure_stocker($strRequete) && is_array($parametres)) {
        $requete = conversion::format_chaine($strRequete).' '.$this->liste_parametres($parametres);
    }else{
        $requete = $strRequete;
    }
        
    //Temps de début de la requete
    $this->temps_debut_SQL = microtime(true);
               
    //Lancement de la requete 
    return $this->resultat_requete($this->SQL->query($requete),$requete);	//Lancement de la requete
  
    }
  
    
    /*********************************************************************************************
                                                    *** FUNCTION resultat_requete ***

    Cette méthode vérifie le résultat de la requete.

    Paramètres d'entrés:
    $resultat 		: résultat de la requete SQL
    $requete 		: requete SQL
    $Tparametres 	: tableau de paramètres ou objet de paramètres

    Résultats retournés: 
    TRUE=procedure stocker, FALSE=requete simple

    Version		: 	2017A
    *********************************************************************************************/
    private function resultat_requete($resultat,$requete,$Tparametres=[]) {
			
    //Résultat de la requete				
    if ($resultat === false ) {
        //Erreur
        $this->SQL_req_erreur = true;
        $this->SQL_log(1,'ERREUR',$requete,$Tparametres,$this->SQL->errno,$this->SQL->error);	//On trace la requete
        return false ;
    }else{
        //OK
        return $this->requete_OK($resultat,$requete,$Tparametres);
    }

    }


    /*********************************************************************************************
                                        *** FUNCTION requete_OK ***

    Execution de la requete SQL correcte.

    Paramètres d'entrés:
    $SQLresultat	: résultat de la requete SQL 
    $SQLstrRequete	: requete SQL sous forme de chaine
    $SQLTparametres	: paramètres requete SQL

    Résultats retournés:
    Résultat de la requete

    Version		: 	2017A
    *********************************************************************************************/
    private function requete_OK($SQLresultat, string $SQLstrRequete, array $SQLTparametres) {
		 		
	//Requetes de type INSERT ou UPDATE ou DELETE
	if (!$this->is_select($SQLstrRequete)) {

		$this->SQL_id_insert 			= $this->SQL->insert_id;		//Retourne l'identifiant automatiquement généré par la dernière requête INSERT
		$this->SQL_nbr_lignes_modifier	= $this->SQL->affected_rows;	//Retourne le nombre de lignes affectées par une requête UPDATE ou DELETE.

		if ($this->SQL_id_insert !== 0) {
			$nbr = $this->SQL_id_insert;
		}else{
			$nbr = $this->SQL_nbr_lignes_modifier;
		}	
		
		$this->SQL_log(2,'OK',$SQLstrRequete,$SQLTparametres,$nbr,$this->duree_SQL);	//On trace la requete
		return $nbr; 
	}
	
	//Requetes de type SELECT
	 
    //Initialisation des variables	
    $Tresultat              = [];
    $this->SQL_req_erreur   = false;
    $Tnbr_resultat 			= [];  
    $num_jeux_resultat 		= 0;
    $num_enregistrement     = 0;
        
    //Temps execution de la requete
    list($this->temps_debut_SQL,$this->temps_fin_SQL , $this->duree_SQL) = conversion::temps_execution( $this->temps_debut_SQL,  microtime(true));
			 
    do {
        //Mise en forme du résultat dans un tableau
        while( $row = $SQLresultat->fetch_array(MYSQLI_ASSOC) ) {
            foreach( $row as $key => $value) {
                $Tresultat[$num_jeux_resultat][$num_enregistrement][$key] = $value;
            }
            $num_enregistrement++;
        }
        $Tnbr_resultat[$num_jeux_resultat] = $num_enregistrement;      
        $num_jeux_resultat ++;
        $num_enregistrement = 0;
        
    }while ($this->SQL->next_result() );
    
    $Tresultat = conversion::ordre_liste($Tresultat);//On détermine le premier et le dernier élément du tableau en rajouter ['ordre'] = premier et ['ordre'] = dernier   
			
    $Tresultat = $this->simplifie($Tresultat);  //On simplifie le résultat de la requete
       
    $this->SQL_log(2,'OK',$SQLstrRequete,$SQLTparametres,$Tnbr_resultat,$this->duree_SQL);	//On trace la requete
    
    return $Tresultat;
    }
      
    
    
    /*********************************************************************************************
                                    *** FUNCTION simplifie ***

    Cette méthode supprimer l'index numérique d'un enregistrement unique. Si this->jeux_resultat_associatif = 1, on remlace l'index numérique du jeux de résultat
    par les 3 premières lettre du première enregistrement.
      
    --Premiere simplification--
    Normalement un résultat est sous la forme suivante :
        resultat[numéro du jeux][numéro de l'enregistrement] = donnée
    
        Si il n'y a qu'un seul numéro d'enregistrement (index = 0) , on supprimer cette index => resultat[numéro du jeux] = donnée
        
        Si il n'y a qu'un seul numéro du jeux (index = 0) , on supprimer cette index => resultat = donnée
    
    --Deuxième simplification--  
    De plus suivant la valeur de  this->jeux_resultat_associatif :
    Exemple :
      1er jeux :
        USR_ID		
        USR_IDENTIFIANT	
      2eme jeux :
        GRP_ID
        GRP_NOM
      
    Résultat avec  this->jeux_resultat_associatif = 0 :
        resultat[0]['USR_ID'] et resultat[0]['USR_IDENTIFIANT']
        resultat[1]['GRP_ID'] et resultat[1]['GRP_NOM']
    
    Résultat avec  this->jeux_resultat_associatif = 1 :
        resultat['USR']['USR_ID'] et resultat['USR']['USR_IDENTIFIANT']
        resultat['GRP']['GRP_ID'] et resultat['GRP']['GRP_NOM']
         
    Paramètres d'entrés:
    $Tresultat	: le résultat de la requete

    Résultats retournés: 
    Un tableau dont les index inutiles ont été supprimé.

    Version		: 	2018A
    *********************************************************************************************/
    private function simplifie($Tresultat) {
    
    if (!$this->jeux_resultat_associatif || count($Tresultat) == 0) {return $Tresultat;}    
        
    //Nombre de jeux de résultat    
    $nbr_jeux_resultat = count($Tresultat);
        
    //Nombre d'enregistrment par jeux de résultat
    foreach( $Tresultat as $num_jeux => $enregistrement) {
        $nbr_enregistrement[$num_jeux] = count($enregistrement);
    }
      
    //On parcours les jeux de résultat, dans le cas ou un seul enregistrement a été recu dans le jeux on simplifie
    foreach( $Tresultat as $num_jeux => $enregistrement) {
        if ($nbr_enregistrement[$num_jeux] == 1) {
            $Tsimplifie[$num_jeux] = $enregistrement[0];
        }else{
            $Tsimplifie[$num_jeux] = $enregistrement;
        }    
    }
    $Tresultat = $Tsimplifie;
           
    //Dans le cas ou un seul jeux de résultat a été recu
    if ($nbr_jeux_resultat == 1) {$Tresultat = $Tresultat[0];}
    
    if ($this->jeux_resultat_associatif && $nbr_jeux_resultat <> 1 ){
       $Tresultat = $this->jeux_resultat_associatif($Tresultat);
    }
    
    return $Tresultat;
    }
    
    
    /*********************************************************************************************
                                    *** FUNCTION jeux_resultat_associatif ***

    Cette méthode remplace les index nombre de jeux de résultat par les 3 premiers caractère de l'index de premier enregistrement.

    Paramètres d'entrés:
    $strRequete	: requete SQL

    Résultats retournés: 
    TRUE=procedure stocker, FALSE=requete simple

    Version		: 	2017A
    *********************************************************************************************/
    private function jeux_resultat_associatif(array $Tresultat) {
       
    foreach( $Tresultat as $num_jeux => $enregistrement) {
        
        if (is_array($enregistrement[0])) {
             $Tcle_assoc = array_keys($enregistrement[0]);
        }else{
            $Tcle_assoc = array_keys($enregistrement);
        }
       
        $premiere_cle_assoc = substr($Tcle_assoc[0],0,3);
        $Tresulat_assoc[$premiere_cle_assoc] = $enregistrement;
    }
    return $Tresulat_assoc;
    }
    
    /*********************************************************************************************
                                   *** FUNCTION is_procedure_stocker ***

    Cette méthode vérifie si la requete est une procédure stocker.

    Paramètres d"entrés:
    $strRequete	: requete SQL

    Résultats retournés: 
    TRUE = procedure stocker, FALSE = requete simple

    Version		: 	2017A
    *********************************************************************************************/
    private function is_procedure_stocker(string $SQLstrRequete	) {
 
    if ($this->is_select($SQLstrRequete) || $this->is_insert($SQLstrRequete) || $this->is_update($SQLstrRequete)) {
        return false;
    }

    return true;
    }
	
	/*********************************************************************************************
                                   *** FUNCTION is_select ***

    Cette méthode vérifie si la requete est une procédure stocker.

    Paramètres d"entrés:
    $strRequete	: requete SQL

    Résultats retournés: 
    TRUE = requete de type SELECT, FALSE = requete autre

    Version		: 	2017A
    *********************************************************************************************/
    private function is_select(string $SQLstrRequete) {

    if (stripos($SQLstrRequete,'SELECT') === false) {
        return false;
    }

    return true;
    }
	
	/*********************************************************************************************
                                   *** FUNCTION is_insert ***

    Cette méthode vérifie si la requete est une procédure stocker.

    Paramètres d"entrés:
    $strRequete	: requete SQL

    Résultats retournés: 
    TRUE = requete de type SELECT, FALSE = requete autre

    Version		: 	2017A
    *********************************************************************************************/
    private function is_insert(string $SQLstrRequete) {

    if (stripos($SQLstrRequete,'INSERT') === false) {
        return false;
    }

    return true;
    }

	/*********************************************************************************************
                                   *** FUNCTION is_update ***

    Cette méthode vérifie si la requete est une procédure stocker.

    Paramètres d"entrés:
    $strRequete	: requete SQL

    Résultats retournés: 
    TRUE = requete de type SELECT, FALSE = requete autre

    Version		: 	2017A
    *********************************************************************************************/
    private function is_update(string $SQLstrRequete) {

    if (stripos($SQLstrRequete,'UPDATE') === false) {
        return false;
    }

    return true;
    }

    
    /*********************************************************************************************
                                                    *** FUNCTION liste_parametres ***

    Cette méthode crée une chaine de caractère avec tous les paramètres de la requete.

    Paramètres d'entrés:
    $SQLTparametres	:  Tableau contenant les paramètres de la requetes

    Résultats retournés: 
    Une chaine avec tous les paramètres de la requete.

    Version		: 	2017A
    *********************************************************************************************/
    private function liste_parametres(array $SQLTparametres) {

    //On filtre le tableau des paramètres
    foreach($SQLTparametres as $key => $valeur) {
        if(	substr(trim($key),0,1) =='@'){
                $parametresRequete .= conversion::format_chaine($key).'=?,';
        }else{
                $parametresRequete .= '@'.conversion::format_chaine($key).'=?,';
        }
    }
    return substr($parametresRequete,0,-1);
    }


    /*********************************************************************************************
                                                    *** FUNCTION valeur_parametres ***

    Cette méthode supprime tous les caractères non désirés.

    Paramètres d'entrés:
    $SQLTparametres	:  Tableau contenant les paramètres de la requetes

    Résultats retournés: 
    Tableau contenant les valeurs des paramètres purgé des caractères non désirés.

    Version		: 	2017A
    *********************************************************************************************/
    private function valeur_parametres($SQLTparametres) {

    //Initialisation des variables    
    $TparametresFiltres =[];

    //On filtre le tableau des paramètres
    foreach($SQLTparametres as $key => $valeur) {
        $TparametresFiltres[] = $valeur; 
    }
    return $TparametresFiltres;
    }

    /*********************************************************************************************
                                                    *** FUNCTION SQL_log ***

    On trace la requete réussi. On remplace les arguments et leur valeurs dans la chaine composant la requete.

    Paramètres d'entrés:
    $code		: code du message dans le fichier de traduction
    $libelle            : Resultat de la requete ( OK ou ERREUR )
    $Tparametres        : tableau contenant les paramètres de la requete
    $param1		: paramètre n°1
    $param2		: paramètre n°2
    $param3		: paramètre n°2

    Résultats retournés: aucun
    
    Version		: 	2017A
    *********************************************************************************************/
    private function SQL_log($code,$libelle,$str_SQL,$Tparametres, $param1='', $param2='' , $param3='') {
    $str = '';    
    $nbr_parametres = substr_count($str_SQL,'?');
    
    //On cherche si le paramètre est une chaine XML
    foreach($Tparametres as $key => $valeur) {
        $pos = strpos($valeur, '<root>');
        if (strpos($valeur, '<root>') !== false){
            $Tparametres[$key] = 'xml';
        }
    }
       
    if ($nbr_parametres <= 10){
        //On remplace les ? (valeur des arguements) par des %s afin de pouvoir appliqué le sprintf puis on met à jour tous les arguments
        $requete = sprintf(str_replace('?', '%s',$str_SQL),$Tparametres[0],$Tparametres[1],$Tparametres[2],$Tparametres[3],$Tparametres[4],$Tparametres[5],$Tparametres[6],$Tparametres[7],$Tparametres[8],$Tparametres[9]);	
    }else{
        $requete = $str_SQL;
    }

    switch ($code) {
    case 1:	//NOK
        $this->log->ligne(['numero'=>1,$libelle,$requete,$param1,$param2]);	
        break;
    
    case 2:	//OK
               
		//On met en forme le nombre d'enregistrement par jeux de résultat
		if (is_array($param1) ) {
			foreach($param1 as $key => $valeur) {
				$str .= '['.$valeur.'-'.count($param1).']';
			}
		}else{
			$str = '['.$param1.']';
		}	
			
        $this->log->ligne(['numero'=>2,$libelle,$requete,$str,$param2]);	
        break;
    }
    }
    
   
}
?>
