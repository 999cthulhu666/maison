<?php
/*
Nom classe 	:	utilisateur.class.php qui hérite de Gestion_BD
Commentaire	:	classe utilisateur, on gère la connexion, l'activation, rappel mot de passe, etc...., de l'utilisateur
Version		: 	2017A

 * --------------------------------------------------------------------------------------------------------
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

*/

class utilisateurs extends BD {
	
    //Propriétés public de la classe
    public $utilisateur     = null; //Objet utilisateur
    
    private $nom_table		= 'maison.UTI_utilisateurs';
    

    /*********************************************************************************************
                                                    *** FUNCTION __construct ***

    Constructeur de la classe, initialisation de l'objet et connexion à la base de donnée.

    Paramètres d'entrés:
    $base_info	: tableau contenant les informations de connexion à la base de donnée

    Résultats retournés:
    aucun
    *********************************************************************************************/
    function __construct () {
       
    //On appelle le constructeur du parent
    parent::__construct();
    
    //On initialise l'instance utilisateur
    $this->utilisateur = $this->cree_utilisateur();
    
    }

    /*********************************************************************************************
                                                    *** function __destruct ***
    Destruction de l'objet

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    aucun
    *********************************************************************************************/
    function __destruct() {//Destruction de l'objet
    //On appelle le destructeur du parent
    parent::__destruct();
    }


    /*********************************************************************************************
                                    *** FUNCTION __call ***

    Cette méthode est appelée lorsque l'on appel une méthode inaccessibles dans un contexte objet. 

    Paramètre d'entrée:
    $name	: nom de la méthode
    $arguments	: tableau d'argument de la méthode

    Résultat retourné:
    aucun

    Version    	: V2017A
    *********************************************************************************************/	
    function __call($name, $arguments) {
    $this->erreur->afficher(['numero'=>2,'['.__CLASS__.'::'.$name.']'],$this->log);		
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
    erreur::creation()->afficher(['numero'=>2,'['.__CLASS__.'::'.$name.']']);
    }

    /*********************************************************************************************
                                                    *** méthode __sleep ***

    Cette méthode magique est appellé lors de l'appel de la fonction serialize. On se déconnecte à la base de donnée et on mémorise les propriét&s de la classe.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Les propriétés de l'objet.
    *********************************************************************************************/
    function __sleep(){
    return ['utilisateur'];
    }

    /*********************************************************************************************
                                                    *** méthode __wakeup ***

    Cette méthode magique est appellé lors de l'appel de la fonction unserialize.

    Paramètres d'entrés:
    aucun

    Résultats retournés:

    *********************************************************************************************/
    function __wakeup(){
    //On appelle le destructeur du parent
    parent::__destruct();
    }
    
    /*********************************************************************************************
                                *** FUNCTION authentification ***

    Cette méthode verifie si l'utilisateur peut se connecter au site. Si oui, on met à jour les propriétée de l'utilisateur. 

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    TRUE si authentification réussi

    Version 	: V2017A
    *********************************************************************************************/
    function authentification() {
        
    //On vérifie que l'instance salarie existe
    if (isset($_SESSION['S_utilisateur']) && $_SESSION['S_utilisateur'] != ''){
        
        //Objet salarié
        $this->utilisateur = unserialize($_SESSION['S_utilisateur']);

        //Vérification si le salarié à accès au site
        if ($this->utilisateur->acces() > 0 ) {
            return true;
        }else{
            return false;                
        }
    }
    else{
        return false;  
    }

    }
    /*********************************************************************************************
                                        *** FUNCTION connexion ***

    Cette méthode verifie si l'utilisateur peut se connecter au site. Si oui, on met à jour les propriétée de l'utilisateur. 

    Paramètres d'entrés:
    $identifiant	: indentifiant de connexion
    $mot_de_pass        : mot de passe

    Résultats retournés:
    TRUE si connexion OK

    Version 	: V2017A
    *********************************************************************************************/
    function connexion(string $identifiant,string $mot_de_passe) {
    
    //Requete vérification si l'utilisateur existe
	$Tresultat = $this->SQL_exec_requete('SELECT * FROM '.$this->nom_table.' WHERE  ( identifiant ="'.$identifiant.'" AND mdp ="'.md5($mot_de_passe).'") ',JEUX_RESULTAT_ASSOCIATIF);
		          
    if (count($Tresultat)!= 0 && !$this->SQL_erreur()) {
        //Le mot de passe est valide 
        $this->utilisateur = $this->cree_utilisateur([  'id'            => $Tresultat['id'],
                                                        'nom'           => $Tresultat['nom'],
                                                        'prenom'        => $Tresultat['prenom'],
                                                        'identifiant'   => $Tresultat['identifiant'],   
                                                        'mot_de_passe'  => $Tresultat['mdp'],
                                                        'courriel'      => $Tresultat['courriel'],
                                                        'acces'         => $Tresultat['acces']        
        ]);
        
        //On trace la connexion de l'utilisateur
        $this->log->ligne(['numero'=>1,$this->utilisateur->identifiant(),$this->utilisateur->acces()],LOG_PRODUCTION);	
        return true;
    } else {
        //On trace la connexion de l'utilisateur
        $this->log->ligne(['numero'=>2,$identifiant],LOG_PRODUCTION);	
        //Le mot de passe est invalide
        return false;
    }
    }
    
     /*********************************************************************************************
                                    *** FUNCTION cree_utilisateur ***

    Cette méthode met à jour un utilisateur.

    Paramètres d'entrés:
    $Tdonnees : un tableau contenant les données d'un utilisateur

    Résultats retournés:
    aucun

    Version 	: V2017A
    *********************************************************************************************/
    function cree_utilisateur($Tutilisateur=null) {

    if ($Tutilisateur == null) {    //Utilisateur par défaut
        $Tutilisateur['id']             = 0;
        $Tutilisateur['nom']            = 'Aucun utilisateur';
        $Tutilisateur['identifiant']    = 'Aucun';
        $Tutilisateur['mot_de_passe']   = 'Aucun';
        $Tutilisateur['groupe']         = 'Aucun';
        $Tutilisateur['droit']          = 0;
    }
            
    $utilisateur = new utilisateur();
    
    $ecrit_membre = $utilisateur->accesseurs();
    
    foreach ($Tutilisateur as $key => $value) {
        $ecrit_membre($key,$value);
    }
     
    return $utilisateur;
    }
    
    /*********************************************************************************************
                                    *** FUNCTION mise_a_jour ***

    Cette méthode met à jour un utilisateur dans la table.

    Paramètre d'entrée:
    $identifiant	: indentifiant de connexion
    $motDePasse		: mot de passe
    $nomComplet		: nom complet de l'utilisateur

    Résultats retournés:
    FALSE si erreur ou TRUE si réussi. 

    Version 	: V2017A
    *********************************************************************************************/
    function modification(array $utilisateur){
    
    if (array_key_exists('mot_de_passe', $utilisateur)) {
        $mot_de_passe = password_hash(conversion::format_chaine($utilisateur['mot_de_passe']),PASSWORD_BCRYPT);
        $this->log->ligne(['numero'=>3,'du mot de passe ',$this->utilisateur->nom()],LOG_PRODUCTION);	
    }else{
        $mot_de_passe = $this->utilisateur->mot_de_passe();
    }
    
    if (array_key_exists('identifiant', $utilisateur)) {
        $identifiant = conversion::format_chaine($utilisateur['identifiant']);
        $this->log->ligne(['numero'=>3,'de l\'identifiant ',$this->utilisateur->nom()],LOG_PRODUCTION);
     }else{
        $identifiant = $this->utilisateur->identifiant();
    }
    
    if (array_key_exists('nom', $utilisateur)) {
        $nom = conversion::format_chaine($utilisateur['nom']);
        $this->log->ligne(['numero'=>3,'du nom complet ',$this->utilisateur->nom()],LOG_PRODUCTION);
     }else{
        $nom = $this->utilisateur->nom();
    }
        
    //Mise à jour de l'utilisateur 
    $Tresultat = $this->SQL_exec_requete("P_USR_UTILISATEUR_SET" ,[
                                                                '@Id'           => $this->utilisateur->id(),
                                                                '@Identifiant'	=> $identifiant,
                                                                '@MotPasse'     => $mot_de_passe,
                                                                '@NomComplet'	=> $nom
                                                                ]
    );
            
    return $Tresult;
    }
    
    /*********************************************************************************************
                                *** méthode ajoute ***

    Cette méthode récupère la liste des membres de la class.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Tous les membres de la class
    *********************************************************************************************/
    function ajoute(string $identifiant='',string $motDePasse='',string $nomComplet='') {
    
    if (func_num_args() != 3){
        $this->erreur->afficher(['numero'=>3,__METHOD__.'(string $identifiant, string $motDePasse, string $nomComplet)',3]);
        return false;			
    }
     //Création d'un nouvelle utilisateur 
    $Tresultat = $this->SQL_exec_requete("P_USR_UTILISATEUR_SET" ,[
                                                                '@Identifiant'	=> $identifiant,
                                                                '@MotPasse'     => password_hash($motDePasse,PASSWORD_BCRYPT),
                                                                '@NomComplet'	=> $nomComplet
                                                                ]
    );
    }
    
    /*********************************************************************************************
                                *** méthode liste_utilisateur ***

    Cette méthode récupère la liste des membres de la class.

    Paramètres d'entrés:
    aucun

    Résultats retournés:
    Tous les membres de la class
    *********************************************************************************************/
    function liste_utilisateur() {
   
    return $this->SQL_exec_requete("P_USR_UTILISATEUR_GET");
    }

    
    /******************************************************************************************
                            *** FUNCTION xml ***

    Cette méthode permet de crée une chaine XML de l'objet.

    Paramètres d'entrées:
    aucun

    Résultat retourné:
    Un chaine XML

    Version 	: V2017A
    ******************************************************************************************/
    function xml() {
    
    return;    
    $xml ='<DATA>';
    
    foreach ($this as $key => $value) {
        //$xml =$xml.'<'.$key.'>'.$value.'</'.$key.'>';
    }
    $xml =$xml.'</DATA>'; 
    return $xml;
    } 
    
}

class utilisateur{
	
    //Propriétés privées de la classe
    private $id;
    private $identifiant;
    private $nom;	
    private $prenom;
    private $courriel; 			
    private $mot_de_passe;			
    private $acces;
    
    
    /******************************************************************************************
                            *** Accesseur / Mutateur de la classe ***

    Ces méthodes permettent de lire/écrire les membres de la classe.

    Version 	: V2017A
    ******************************************************************************************/
    function id(string $valeur='') {
    if ($valeur=='') {return $this->id;}else{return $this->id = $valeur;}
    }
    
    function identifiant(string $valeur='') {
    if ($valeur=='') {return $this->identifiant;}else{return $this->identifiant = $valeur;}
    }
        
    function nom(string $valeur='') {
    if ($valeur=='') {return $this->nom;}else{return $this->nom = $valeur;}
    }
    
    function prenom(string $valeur='') {
    if ($valeur=='') {return $this->prenom;}else{return $this->prenom = $valeur;}
    }
    
    function groupe(string $valeur='') {
    if ($valeur=='') {return $this->groupe;}else{return $this->groupe = $valeur;}
    }

    function mot_de_passe(string $valeur='') {
    if ($valeur=='') {return $this->mot_de_passe;}else{return $this->mot_de_passe = $valeur;}
    }

    function courriel(string $valeur='') {
    if ($valeur=='') {return $this->courriel;}else{return $this->courriel = $valeur;}
    }
    
    function acces(int $valeur=0) {
    if ($valeur=='') {return $this->acces;}else{return $this->acces = $valeur;}
    }
    
    /******************************************************************************************
                            *** Accesseur automatique de la classe ***

    Cette méthode permet de lire/écrire les membres de la classe.

    Version 	: V2017A
    ******************************************************************************************/
    function accesseurs() {
    return function($nom,$param){
                return $this->$nom = trim($param);
            };
    }
    
    /******************************************************************************************
                            *** FUNCTION xml ***

    Cette méthode permet de crée une chaine XML de l'objet.

    Paramètres d'entrées:
    aucun

    Résultat retourné:
    Un chaine XML

    Version 	: V2017A
    ******************************************************************************************/
    function xml() {
        
    $xml ='<DATA>';
    foreach ($this as $key => $value) {
        $xml =$xml.'<'.$key.'>'.$value.'</'.$key.'>';
    }
    $xml =$xml.'</DATA>'; 
    return $xml;
    } 
    
}    
?>
