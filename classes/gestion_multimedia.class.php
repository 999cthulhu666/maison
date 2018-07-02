<?php
/*
Nom classe 	:	multimedia
Commentaire	:	Cette classe assure la gestion de la base de données des docuements multimedia (films, musiques, etc ...)
Version		: 	2018A

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

class gestion_multimedia extends BD {
	public $chemin_images				= '';	

	private $nom_table					='maison.MUL_multimedia';
	private $nom_table_genre			='maison.MUL_genre';
	private $nom_table_support			='maison.MUL_support';
	private $nom_table_auteur			='maison.MUL_auteur';

	private $fichiers_locaux			= array();	
	private $fichiers_ftp				= array();
	private $type_documents_multimedia	= 0;
	private $ID3 						= NULL;
	private $liste						= array();
	private $HTML_liste					= array();
	private $donnees					= array();
	private $document					= array();	
	private $liste_multimedias			= array();
	private $liste_auteurs				= array();
	private $liste_genres				= array();
	private $liste_supports				= array();
	private $liste_fichiers				= array();
	private $dernier_objet				= array();
	private $dernier_methode			= array();
	private $liste_nouveau				= array();
	private $liste_supprimer			= array();
	
	/*********************************************************************************************
					*** FUNCTION __construct ***

	Cette fonction initialise l'objet. Elle utilise une fonction de la classe parent Gestion_BD.

	Paramètre d'entrée:
	$type : 'MUSIQUE','FILM','SERIE' 
	$Tparametres : tableau de paramètres
	 
	Résultat retourné: 
	aucun
	
	Version 	: V2018A
	*********************************************************************************************/
	function __construct ($type='MUSIQUES',$Tparametres=null) {
		
	//Récupération des paramètres de configuration FTP
	$this->fichiers_ftp = fichier::ini_lit("FTP");
    
    //Récupération des paramètres de configuration fichiers local
	$this->fichiers_locaux = fichier::ini_lit("FICHIER_LOCAL");
	    			    			
	if (is_array($Tparametres)) {
		if(isset($Tparametres['chemin']))				{$this->fichiers_locaux['chemin_fichier']		= $Tparametres['chemin'];} 				
		if(isset($Tparametres['chemin_img_films']))		{$this->fichiers_locaux['chemin_images_films']	= $Tparametres['chemin_img_films'];} 	
		if(isset($Tparametres['chemin_img_musiques']))	{$this->fichiers_locaux['chemin_images_musiques']= $Tparametres['chemin_img_musiques'];}
		
		if(isset($Tparametres['ftp']['serveur']))		{$this->fichiers_ftp['serveur']					= $Tparametres['ftp']['serveur'];}		
		if(isset($Tparametres['ftp']['identifiant']))	{$this->fichiers_ftp['identifiant']				= $Tparametres['ftp']['identifiant'];}	
		if(isset($Tparametres['ftp']['mot_de_passe']))	{$this->fichiers_ftp['mot_de_passe']			= $Tparametres['ftp']['mot_de_passe'];}	
		if(isset($Tparametres['ftp']['racine']))		{$this->fichiers_ftp['racine']					= $Tparametres['ftp']['racine'];}	
	}
		
	switch (strtoupper($type)) {
		case 'FILMS':	//Films
			$this->type_documents_multimedia 		= 0;
			if ($this->fichiers_locaux['chemin_fichier'] != '') {
				$this->fichiers_locaux['chemin_fichier'] .= 'videos';
			}	
			
			$this->chemin_images 					= $this->fichiers_locaux['chemin_images_films'];

		break;
		
		case 'MUSIQUES':	//Musiques
			$this->type_documents_multimedia 		= 1;
			if ($this->fichiers_locaux['chemin_fichier'] != '') {
				$this->fichiers_locaux['chemin_fichier'] .= 'musiques';
			}	
			$this->chemin_images 					= $this->fichiers_locaux['chemin_images_musiques'];
			
		break;
		
		default:
			$this->type_documents_multimedia 		= 1;
			if ($this->fichiers_locaux['chemin_fichier'] != '') {
				$this->fichiers_locaux['chemin_fichier'] .= 'musiques';
			}	
	}
			
	//Création de l'instance utilsé pour récuperer les tag ID3 des fichiers de musique
	$this->ID3 = new getID3;
	
	//On appelle le constructeur du parent
	parent::__construct($this->nom_table);
	
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
	$this->erreur->afficher([numero=>2,'['.__CLASS__.'::'.$name.']'],$this->log);	
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
					*** FUNCTION __get ***

	Cette méthode __get() est lancée lorsque l'on invoque des propriétés inaccessibles. 

	Paramètre d'entrée:
	$propriete		: nom de la propriete

	Résultat retourné:
	aucun

	Version 	: V2017A
	*********************************************************************************************/	
	public function __get($propriete){
	
	switch ($propriete) {
		case 'liste_auteurs':	
			return $this->liste_auteurs()->liste_auteurs;
		break;
			
		case 'liste_genres':	
			return $this->liste_genres()->liste_genres;
		break;
		
		case 'liste_supports':	
			return $this->liste_supports()->liste_supports;
		break;
		
		case 'liste_multimedias':	
			return $this->liste_multimedias()->liste_multimedias;
		break;
		
		case 'liste_fichiers':	
			return $this->liste_fichiers()->liste_fichiers;
		break;
				
		default:
			return false;
	}
	}
	
	/******************************************************************************************
									*** FUNCTION to_html ***
						
	Cette méthode renvoi un tableau HTML

	Paramètres d'entrées:
	$Tcolonnes : nom des propriétés de l'objet multimedia

	Résultat retourné:
	Un tableau HTML

	Version 	: V2018A
	**********************************************************auteur***********************************/
	function to_html($Tcolonnes)
	{
	
	//Initialisation des variables
	$index = 0;
	$html = [];
	
	foreach($this->dernier_objet as $cle => $objet1){
		foreach($Tcolonnes as $colonne){
			
			//Initialisation des variables
			$method1 = '';
			$method2 = '';
									
			if (is_array($colonne)) {
				$method1 = key($colonne);
				$method2 = $colonne[key($colonne)];
			}else{
				$method1 = $colonne;
			}
						
			if (method_exists($this->dernier_objet[$cle], $method1)) {
				
				$objet2 = $objet1->$method1();
											
				if ($method2 != '') {
					if (method_exists( $objet2, $method2)) {
						$html[$index][key($colonne)] = $objet2->$method2();	
					}	
				}else{
					$html[$index][$colonne] = $objet1->$method1();
				}	
				
			}	
		}
		$index ++;
	}	
	    
	return conversion::tableau_to_html($html);
	}

	/******************************************************************************************
									*** FUNCTION to_array ***
							
	Cette méthode renvoi les données sous forme d'un tableau

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau

	Version 	: V2018A
	**********************************************************auteur***********************************/
	function to_array()
	{
	//Initialisation des variables	
	$Tdonnees = [];
		
	foreach($this->dernier_objet as $cle => $objet){
			$Tdonnees[] = $objet->to_array();
	}
					
	return $Tdonnees;
	}

	/******************************************************************************************
									*** FUNCTION liste_genres ***
							
	Cette méthode liste les genres.

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	public function liste_genres()
	{
	//Initialisation des variables	
	$this->liste_genres = [];
			
	$requete = ("SELECT * FROM ".$this->nom_table_genre." WHERE type=".$this->type_documents_multimedia." ORDER BY id ASC");

	$Tresultat  = $this->SQL_exec_requete($requete);
		
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $genre){
			$this->liste_genres[$cle] = new \modele\multimedia\genre($genre);
		}
	}
	
	$this->dernier_objet = $this->liste_genres;	
	$this->dernier_methode	=__METHOD__;
			
	return $this;
	}
	
	
	/*********************************************************************************************
									*** FUNCTION liste_auteurs ***

	Cette méthode cherche la liste des auteurs. 

	Paramètre d'entrée: 
	aucun

	Résultat retourné:
	Un tableau contenant la liste des auteurs

	Version 	: V2018A
	*********************************************************************************************/	
	public function liste_auteurs()
	{
	//Initialisation des variables	
	$this->liste_auteurs = [];
		
	$requete = "SELECT libelle,id FROM ".$this->nom_table_auteur." WHERE type=".$this->type_documents_multimedia;

	$Tresultat  = $this->SQL_exec_requete($requete);
		
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $auteur){
			$this->liste_auteurs[$cle] = new \modele\multimedia\auteur($auteur);
		}
	}
	
	$this->dernier_objet = $this->liste_auteurs;
	$this->dernier_methode	=__METHOD__;
	
	return $this;
	}
	
	

	/*********************************************************************************************
									*** FUNCTION liste_supports ***

	Cette méthode cherche la liste des supports. 

	Paramètre d'entrée: 
	aucun
	Résultat retourné:
	Un tableau contenant la liste des supports

	Version 	: V2018A
	*********************************************************************************************/	
	public function liste_supports()
	{
	//Initialisation des variables	
	$this->liste_supports = [];
				
	$requete = ("SELECT id,libelle FROM ".$this->nom_table_support." WHERE type=".$this->type_documents_multimedia." ORDER BY id ASC");

	$Tresultat  = $this->SQL_exec_requete($requete);

	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $support){
			$this->liste_supports[$cle] = new \modele\multimedia\support($support);
		}
	}
	
	$this->dernier_objet = $this->liste_supports;
	$this->dernier_methode	=__METHOD__;
	
	return $this;
	}


	/*********************************************************************************************
									*** FUNCTION liste_multimedias ***

	Cette méthode cherche la liste des films présent dans la table. 

	Paramètre d'entrée:
	$parametres['tri']	:
	$parametres['limite']	:

	Résultat retourné:
	Un tableau contenant la liste des films.

	Version 	: V2018A
	*********************************************************************************************/	
	public function liste_multimedias($parametres=null)
	{
	//Initialisation des variables	
	$this->liste_multimedias = [];
		
	//Paramètres par défaut
	$tri		= 'HORODATAGE<';
	$limite		= '';
		
	if (is_array($parametres)) {
		if(isset($parametres['tri'])) 	{$tri	=$parametres['tri'];} 	
		if(isset($parametres['limite'])){$limite= 'LIMIT '.$parametres['limite'];}	
	}	
	
	switch (strtoupper($tri)) {
		case 'HORODATAGE>':	
			$order_by =  ' ORDER BY horodatage  DESC' ;
		break;

		case 'HORODATAGE<':	
			$order_by =  ' ORDER BY horodatage  ASC' ;
		break;

		case 'AUTEUR>':	
			$order_by =  ' ORDER BY auteur ASC' ;
		break;

		case 'AUTEUR<':	
			$order_by =  ' ORDER BY auteur DESC' ;
		break;
	}
	
	$requete = ("SELECT *,(SELECT libelle FROM ".$this->nom_table_auteur." WHERE id = a.id_auteur) as auteur,(SELECT type FROM ".$this->nom_table_auteur." WHERE id = a.id_auteur) as type_auteur,(SELECT libelle FROM ".$this->nom_table_genre." WHERE  id = a.id_genre ) as genre,(SELECT image FROM ".$this->nom_table_genre." WHERE  id = a.id_genre ) as image_genre,(SELECT libelle FROM ".$this->nom_table_support." WHERE  id = a.id_support ) as support FROM ".$this->nom_table." a WHERE valide=1 AND type=".$this->type_documents_multimedia." ".$order_by." ".$limite);	
			
	$Tresultat = $this->SQL_exec_requete($requete);
			
	foreach($Tresultat[0] as $cle => $multimedia){
		$this->liste_multimedias[] = new \modele\multimedia\multimedia($multimedia);
	}	
	
	$this->dernier_objet = $this->liste_multimedias;
	$this->dernier_methode	=__METHOD__;
	
	return $this;
	}
	
	
	/******************************************************************************************
						*** FUNCTION liste_fichiers ***
							
	Cette méthode recherche tous les films présents dans les répertoires du serveur ou dans la BD.

	Paramètres d'entrées: aucun
		
	Résultat retourné:
	Un tableau contenant la liste des documents.
	*************************************************0******************************************/
	function liste_fichiers() {
		
	if (count($this->liste_fichiers) != 0) {
		$this->dernier_objet = $this->liste_fichiers;	
		return $this;
	}
	
	if ($this->fichiers_ftp['serveur'] !== null) {
		//Connexion FTP
		$this->connexion_ftp(true);
		$this->lit_fichiers_ftp($this->fichiers_ftp['racine']);
		$this->connexion_ftp(false);
	}else{
		//Fichier locaux ou répertoire distant
		$this->lit_fichiers_locaux();
	}	
					
	switch ($this->type_documents_multimedia) {
		case 0:	//Films
			$this->liste_fichiers =  $this->decode_fichiers_films();
		break;
			
		case 1:	//Musiques
			$this->liste_fichiers =  $this->decode_fichier_musiques();
		break;
		
		default:
			
	}
	
	$this->dernier_objet = $this->liste_fichiers;	
	$this->dernier_methode	=__METHOD__;
	
	return $this;	
	}
	
		
	/******************************************************************************************
						*** FUNCTION liste_nouveau ***
							
	Cette méthode recherche les films qui sont présent dans les répertoires locaux mais pas dans la table.

	Paramètres d'entrées: 
	aucun
					
	Résultat retourné:
	La fonction retourne la liste des nouveaux documents
	********************************************************************************************/
	function liste_nouveau() {
		
	//Initialisation des variables	
	$Tdocuments_diff		= [];
	$Ttitres_BD				= [];
	$Ttitres_fichiers		= [];
	$Tliste_fichiers		= $this->liste_fichiers()->to_array();
	$Tliste_BD				= $this->liste_multimedias()->to_array();
							
	foreach($Tliste_fichiers as $cle => $fichier){
		$Ttitres_fichiers[$cle] = $fichier['titre'];
	}

	foreach($Tliste_BD as $cle => $document){
		$Ttitres_BD[$cle] = $document['titre'];
	}
		
	$Tdocuments_diff= array_diff($Ttitres_fichiers,$Ttitres_BD);
			
	if (count($Tdocuments_diff) > 0) {		
		foreach($Tdocuments_diff as $cle => $document){
			$this->liste_nouveau[] = $this->liste_fichiers[$cle];
		}
	}
	    
    $this->dernier_objet = $this->liste_nouveau;	
    $this->dernier_methode	=__METHOD__;
    	
	//La fonction retourne l'objet lui-même
	return $this;
	}
	
	/******************************************************************************************
				*** FUNCTION liste_supprimer ***
							
	Cette méthode recherche les films qui sont présent dans la table mais pas dans les répertoires locaux.

	Paramètres d'entrées: 
	aucun
					
	Résultat retourné:
	La fonction retourne la liste des nouveaux documents
	********************************************************************************************/
	function liste_supprimer() {
		
	//Initialisation des variables	
	$Tdocuments_diff		= [];
	$Ttitres_BD				= [];
	$Ttitres_fichiers		= [];
	$Tliste_fichiers		= $this->liste_fichiers()->to_array();
	$Tliste_BD				= $this->liste_multimedias()->to_array();
							
	foreach($Tliste_fichiers as $cle => $fichier){
		$Ttitres_fichiers[$cle] = $fichier['titre'];
	}

	foreach($Tliste_BD as $cle => $document){
		$Ttitres_BD[$cle] = $document['titre'];
	}
		
	$Tdocuments_diff= array_diff($Ttitres_BD,$Ttitres_fichiers);
			
	if (count($Tdocuments_diff) > 0) {		
		foreach($Tdocuments_diff as $cle => $document){
			$this->liste_supprimer[] = $this->liste_multimedias[$cle];
		}
	}
	    
    $this->dernier_objet = $this->liste_supprimer;	
    $this->dernier_methode	=__METHOD__;
    		
	//La fonction retourne l'objet lui-même
	return $this;
	}
	
	/*********************************************************************************************
									*** FUNCTION ajouter_document ***

	Cette méthode ajoute un document dans la table. 

	Paramètre d'entrée:
	$document	: objet document multimedia à insérer dans la table

	Résultat retourné:
	L'ID de la table

	Version 	: V2018A
	*********************************************************************************************/	
	function ajouter_document($document) {
		
	if (!is_object($document)) {
		$document = new \modele\multimedia\multimedia($document);
	}
			
	if($document->auteur()->id() == 0) {
		$document->auteur()->id($this->ajouter_auteur($document->auteur()->libelle()));		
	}	
			
	if ($document->id() != 0) {
		return $this->modifier_document($document);
	}
		
	//On ajout le nouveau document		
	$requete ='INSERT INTO '.$this->nom_table.' (titre,id_auteur,id_support,id_genre,horodatage,commentaire,annee,critique,image,chemin,fichier,lien,valide,type) VALUES ("'.$document->titre().'",'.$document->auteur()->id().','.$document->support()->id().','.$document->genre()->id().',CURRENT_TIMESTAMP,"'.$document->commentaire().'",'.$document->annee().','.$document->critique().',"'.$document->image().'","'.$document->chemin().'","'.$document->fichier().'","'.$document->lien().'",1,"'.$this->type_documents_multimedia.'")';
	
	$this->SQL_exec_requete($requete);
	
	if ($this->SQL_erreur()) {return false;}
	
	return $this->SQL_id_insert;		
	}


	/*********************************************************************************************
									*** FUNCTION modifier_document ***

	Cette méthode modifie un document dans la table. 

	Paramètre d'entrée:
	$document	: objet document multimedia à insérer dans la table

	Résultat retourné:
	L'ID de la table

	Version 	: V2018A
	*********************************************************************************************/	
	function modifier_document($document) {
		
	//On modifie le document		
	$requete ='UPDATE '.$this->nom_table.' SET titre="'.$document->titre().'",id_auteur='.$document->auteur()->id().',id_support='.$document->support()->id().',id_genre='.$document->genre()->id().',commentaire="'.$document->commentaire().'",annee='.$document->annee().',critique='.$document->critique().',image="'.$document->image().'",lien="'.$document->lien().'" WHERE id='.$document->id().' LIMIT 1' ;
	
	$this->SQL_exec_requete($requete);

	if ($this->SQL_erreur()) {return false;}

	return $document->id();
	}
	
	/******************************************************************************************
								*** FUNCTION supprimer_document ***
							
	Cette méthode supprimer un document dans la table.

	Paramètres d'entrées: 
	$document	: objet document multimedia à insérer dans la table
			
	Résultat retourné	:
	TRUE si pas d'erreur
	**********************************************************auteur***********************************/
	function supprimer_document($document) {

	//On modifie le document		
	$requete ='UPDATE '.$this->nom_table.' SET valide = 0 WHERE  id='.$document->id().' LIMIT 1' ;
	$this->SQL_exec_requete($requete);
	
	if ($this->SQL_erreur()) {return false;}
	
	return true;
	}
	
	/*********************************************************************************************
									*** FUNCTION ajouter_auteur ***

	Cette méthode ajoute un auteur dans la table. 

	Paramètres d'entrées: 
	$auteur : nom de l'auteur
			
	Résultat retourné:
	La fonction retourne l'ID de l'auteur

	Version 	: V2018A
	*********************************************************************************************/	
	function ajouter_auteur($auteur) {
	
	$requete = ("SELECT id FROM ".$this->nom_table_auteur." WHERE libelle LIKE '".strtolower($auteur)."'");
	$resultat = $this->SQL_exec_requete($requete,JEUX_RESULTAT_ASSOCIATIF);

	if ($this->SQL_erreur()) {return false;}

	$id_auteur = $resultat['id'];

	//Si l'auteur n'existe pas dans la table, on le rajoute
	if($id_auteur == null || $id_auteur == 0){
		$requete 	= 'INSERT INTO '.$this->nom_table_auteur.'(libelle,type) VALUES ("'.strtolower($auteur).'","'.$this->type_documents_multimedia.'")';
		$this->SQL_exec_requete($requete);
		$id_auteur	= $this->SQL_id_insert;
		
		if ($this->SQL_erreur()) {return false;}
	}

	return $id_auteur;
	}


	/*********************************************************************************************
									*** FUNCTION critique ***

	Cette méthode modifie la note d'un document. 

	Paramètre d'entrée:
	$document	: document multimedia à insérer dans la table

	Résultat retourné:
	le document qui a été ajouter

	Version 	: V2018A
	*********************************************************************************************/	
	function critique($document) {
	
	if (!is_object($document)) {
		$document = new \modele\multimedia\multimedia($document);
	}
	
	$requete ='UPDATE '.$this->nom_table.' SET critique	= "'.$document->critique().'" WHERE id	='.$document->id().' LIMIT 1' ;
		
	$this->SQL_exec_requete($requete);	
	
	if ($this->SQL_erreur()) {return false;}
	
	return true;
	
	}


	/******************************************************************************************
				*** FUNCTION maj ***
							
	Cette méthode ajoute/supprimer des documents dans la table.

	Paramètres d'entrées: aucun
	
	Résultat retourné:
	TRUE si aucune erreur
	*******************************************************************************************/
	function maj() {
		
	if ($this->dernier_methode == 'gestion_multimedia::liste_nouveau'){
	
		//On cherche les nouveaux documents non présent dans la BD		
		$nouveaux_documents 	= $this->dernier_objet;
		
		//Mise à jour ID auteur et genre
		$Tdocuments_fichiers 	= $this->recherche_id_auteur($nouveaux_documents);
		$Tdocuments_fichiers 	= $this->recherche_id_genre($Tdocuments_fichiers);
										
		//Mise à jour des documents
		if (count($nouveaux_documents) > 0) {
			foreach($nouveaux_documents as $document){
				$this->ajouter_document($document);
			}	
		}
	}
		
	if ($this->dernier_methode == 'gestion_multimedia::liste_supprimer'){

		//On cherche les nouveaux documents non présent dans la BD		
		$supprimer_documents 	= $this->dernier_objet;

		//Mise à jour des documents
		if (count($supprimer_documents) > 0) {
			foreach($supprimer_documents as $document){
				$this->supprimer_document($document);
			}	
		}
	}
					
	//La fonction retourne TRUE si terminé correctement
	return true;
	
	}

	/******************************************************************************************
				*** FUNCTION lit_fichiers_locaux ***
							
	Cette méthode recherche tous les documents dans un répertoire local ou distant.

	Paramètres d'entrées:
	$repertoire	: 	répertoire racine dans lequel les documents vont être rechercher.

	Résultat retourné:
	Un tableau contenant la liste des documents ['nom'] et ['repertoire'].
	*************************************************0******************************************/
	function lit_fichiers_locaux($repertoire='') {
				
	//Répertoire courant de recherche
	$chemin = $this->fichiers_locaux['chemin_fichier'].$repertoire;
	
	if ($handle = opendir($chemin)) {
		while (false !== ($entry = readdir($handle)) ) {
			//Liste des répertoires    	
			if(is_dir($chemin.'/'.$entry) && $entry[0] != '.') {
				$this->lit_fichiers_locaux($repertoire.'/'.$entry);
			}
			else if ($entry[0] != '.'){
				$this->document['nom'][]= strtolower(trim($entry));
				$this->document['repertoire'][]= strtolower(trim($repertoire));
			}
		}
	closedir($handle);
	}
	}

	/******************************************************************************************
				*** FUNCTION lit_fichiers_ftp ***
							
	Cette méthode recherche tous les documents présents dans le répertoire et sous répertoire passé en paramètre .

	Paramètres d'entrées:
	$repertoire_courant	: 	répertoire racine dans lequel les documents vont être rechercher.

	Résultat retourné:
	Un tableau contenant la liste des documents ['nom'] et ['repertoire'].
	*************************************************0******************************************/
	function lit_fichiers_ftp($repertoire) {
					
	// Récupère la liste des fichiers de /
	$fichiers = ftp_nlist($this->fichiers_ftp['id'], $repertoire);
		
	foreach($fichiers as $cle => $valeur){
		if (conversion::is_fichier($valeur)) {
			$this->document['nom'][]		= conversion::cherche_nom_fichier($valeur);
			$this->document['repertoire'][]	= conversion::cherche_chemin_fichier($valeur);
		}else{
			$this->lit_fichiers_ftp($fichiers[$cle]);
			
		}	
	}
	return $this->document;
	}


	/******************************************************************************************
				*** FUNCTION connexion_ftp ***
							
	Cette méthode ouvre ou ferme une connexion FTP

	Paramètres d'entrées: 
	$ouvre : TRUE ou FALSE
	
	Résultat retourné: 
	FALSE = erreur
	*************************************************0******************************************/
	function connexion_ftp($ouvre) {

	if ($ouvre) {
		// Mise en place d'une connexion
		$this->fichiers_ftp['id'] = ftp_connect($this->fichiers_ftp['serveur']); 
			
		ftp_set_option($this->fichiers_ftp['id'],FTP_TIMEOUT_SEC, 10);
					
		if ($this->fichiers_ftp['id'] === false) {
			 $this->erreur->afficher(['numero'=>20,$this->fichiers_ftp['serveur']]);
			 return false;
		}	
			
		// Tentative d'identification
		if (!ftp_login($this->fichiers_ftp['id'],$this->fichiers_ftp['identifiant'], $this->fichiers_ftp['mot_de_passe'])) {
			 $this->erreur->afficher(['numero'=>21,$this->fichiers_ftp['identifiant'],$this->fichiers_ftp['serveur'],$this->fichiers_ftp['mot_de_passe']]);
			 ftp_close($this->fichiers_ftp['id']);
			 return false;
		}
		
	}else{	
		// Fermeture de la connexion
		ftp_close($this->fichiers_ftp['id']);
	}
	
	return true;

	}

	/*********************************************************************************************
							*** FUNCTION decode_fichiers_films ***
								
	Cette méthode décode une chaine de caractère :
	 ex: rambo - Ted Kotcheff (1983) => pour un film
	 en :  	$Tfilms[x]['nom']		= rambo
			$Tfilms[x]['auteur'] 	= Ted Kotcheff
			$Tfilms[x]['annee'] 	= 1983

	 ex: [01x07] Dexter - il faut tuer le pere noel => pour une série
	 en :  	$Tfilms[x]['nom'] 			= Dexter
			$Tfilms[x]['episode'] 		= il faut tuer le pere noel
			$Tfilms[x]['numero_episode']= 1
			$Tfilms[x]['saison']		= 7
			
	Paramètre d'entrée: aucun
	
	Résultat retourné:  
	Tableau donné en exemple ci-audessus						
	 
	Version : 2018A 
	*********************************************************************************************/
	function decode_fichiers_films() {

	//Initialisation des variables
	$Tfilms	= [];
			
	foreach($this->document['nom'] as $cle => $valeur){
		
		if (strpos($valeur,'[')=== false ) {	//On cherche si il s'agit d'un film ou d'une série
			//Films
			if(trim($this->document['repertoire'][$cle]) !== '') {
							
				//Film
				list($nom, $auteur_annee) 	= explode('-', $valeur);
				list($auteur,$annee) 		= explode('(', $auteur_annee);
									
				$pos = strpos($this->document['repertoire'][$cle],'/',1);
							
				if ($pos !== false) {
					$genre = substr($this->document['repertoire'][$cle],1,$pos-1);
				}
				else {
					$genre = substr($this->document['repertoire'][$cle],1);
				}
				
				$Tfilms['titre'] 	= strtolower(trim($nom));
				$Tfilms['auteur'] 	= strtolower(trim($auteur));
				$Tfilms['annee'] 	= intval(substr(trim($annee),0,4));
				$Tfilms['genre'] 	= strtolower($genre);
				$Tfilms['chemin'] 	= $this->document['repertoire'][$cle];
				$Tfilms['fichier'] 	= $valeur;
				$Tfilms['support'] 	= 7;	//Divx
				 
				$Ofilms[] = new \modele\multimedia\multimedia($Tfilms);
			}
		}
		else{
			//Serie
			/*list($num,$nom,$episode ) 		= split('[]-]', $valeur);
			list($numero_episode,$saison) 	= split('[x]', $num);
			
			$Tfilms['nom'][$cle] 		= strtolower(trim($nom));
			$Tfilms['episode'][$cle]	= strtolower(trim($episode));
			
			$numero_episode 				= str_replace('[','',$numero_episode);
			$Tfilms['numero_episode'][$cle] = intval($numero_episode);		
			$Tfilms['saison'][$cle] 	= intval($saison);*/
		}
	}
	
	return $Ofilms;
	}

/*********************************************************************************************
						*** FUNCTION decode_fichiers_musiques ***
Version : 2016A
						
Cette méthode décode un tag id3 d'un fichier audio:
 ex: 01 - You re Gonna Miss Me.mp3
 en :  	$this->document['repertoire'][x] 		= 
       	$this->document['nom'][x] 				= 01 - You re Gonna Miss Me.mp3
		$this->document['tagid3'][x]['genre'] 	= 
		$this->document['tagid3'][x]['titre'] 	= 
		$this->document['tagid3'][x]['album'] 	= 
		$this->document['tagid3'][x]['artiste'] 	= 

		
Paramètre d'entrée:
NA

Résultat retourné:  
Tableau donné en exemple ci-audessus						
*********************************************************************************************/
function decode_fichiers_musiques() {

//Initialisation des variables
unset($Tmusiques);
unset($repertoire_modifie);

//On supprime les répertoires qui contiennent [CD x] (compilation contenant plusieurs CD) 
foreach($this->document['repertoire'] as $cle => $valeur){
	$pos = stripos($valeur,'[');
	if ($pos!== false ) {
		$this->document['repertoire'][$cle] = trim(substr($valeur,0,$pos-1));
		$repertoire_modifie[$cle] = $valeur;    
	}
}
	
$TListeMusiques = array_unique($this->document['repertoire']);
	
foreach($TListeMusiques as $cle => $valeur){
	//On regarde si le répertoire contenait [CDx], si on oui on restaure l'ancien nom de répertoire
	if ($repertoire_modifie[$cle] != null) {$valeur = $repertoire_modifie[$cle];}
	
	$tag = $this->TagID3($valeur.'/'.$this->document['nom'][$cle]);
	$Tmusiques['repertoire'][]	= $valeur;
	$Tmusiques['nom'][] 		= strtolower(trim($tag['album']));
	$Tmusiques['auteur'][] 		= strtolower(trim($tag['auteur']));
	$Tmusiques['annee'][]		= intval($tag['annee']);
	$Tmusiques['genre'][] 		= strtolower(trim($tag['genre']));
	$Tmusiques['chemin'][] 		= $valeur;
	$Tmusiques['fichier'][] 	= $this->document['nom'][$cle];
	$Tmusiques['image'][] 		= $tag['image'];
}

$this->document = $Tmusiques;		
$this->Recherche_id_auteur();
$this->Recherche_id_genre();

return $this->document;
}

	/******************************************************************************************
				*** FUNCTION recherche_id_auteur ***
							
	Cette méthode cherche les ID de la table auteur, si il n'existe pas on rajoute l'auteur.

	Paramètres d'entrées: 
	$Tdocuments : liste des documents
				
	Résultat retourné:
	Ajout de ['auteur_id'] dans le tableau $Tdocuments
	**********************************************************auteur***********************************/
	private function recherche_id_auteur($Tdocuments) {

	$Tauteurs = $this->liste_auteurs()->liste_auteurs;
		
	//Remise en forme du tableau liste des auteurs
	foreach($Tauteurs as $cle => $auteur){
		$liste_auteurs[$auteur->id()] = $auteur->libelle();
	}	
						
	foreach($Tdocuments as $cle => $document){
		$key = array_search($document->auteur()->libelle(), $liste_auteurs);
			
		if($key === false) {
			$key=$this->ajouter_auteur($document->auteur()->libelle());
		}
		
		$document->auteur()->id($key);
	}
		
	return $Tdocuments;	
	}

	/******************************************************************************************
				*** FUNCTION recherche_id_genre ***
							
	Cette méthode cherche les ID de la table genre.

	Paramètres d'entrées: 
	$Tdocuments : liste des documents
				
	Résultat retourné:
	Ajout de ['genre_id'] dans le tableau $Tdocuments
	**********************************************************auteur***********************************/
	private function recherche_id_genre($Tdocuments) {

	//On recherche la liste des auteurs de la table
	$Tgenres = $this->liste_genres()->liste_genres;

	//Remise en forme du tableau liste des auteurs
	foreach($Tgenres as $cle => $genre){
		$liste_genres[$genre->id()] = $genre->libelle();
	}

	foreach($Tdocuments as $cle => $document){
		$key = array_search($document->genre()->libelle(), $liste_genres); 
		
		if($key === false) {
			$key=$this->ajouter_genre($document->genre()->libelle());
		}
		
		$document->genre()->id($key);
	}	
	return $Tdocuments;
	}


/******************************************************************************************
			*** FUNCTION TagID3 ***
						
Cette méthode recherche le tag ID3 du documents.

Paramètres d'entrées:
N.A.

Résultat retourné:
Un tableau contenant le tag ID3.
*************************************************0******************************************/
function TagID3($documents) {

$data = $this->ID3->analyze($this->fichiers_locaux['chemin_fichier'].$documents);

$audio['nom'] 		= $data['id3v2']['comments']['title'][0];
$audio['genre'] 	= $data['id3v2']['comments']['genre'][0];
$audio['auteur'] 	= $data['id3v2']['comments']['artist'][0];
$audio['album'] 	= $data['id3v2']['comments']['album'][0];
$audio['annee'] 	= $data['id3v2']['comments']['year'][0];
$audio['image']['data']	= $data['id3v2']['comments']["picture"][0]["data"];
$audio['image']['type']	= $data['id3v2']['comments']["picture"][0]["image_mime"];
$audio['image']['largeur']	= $data['id3v2']['comments']["picture"][0]["image_width"];
$audio['image']['hauteur']	= $data['id3v2']['comments']["picture"][0]["image_height"];

//$audio['test'] 	= $data['id3v2']['comments']["picture"][0]["data"];
//echo $documents;
return $audio;
}

	/******************************************************************************************
					*** FUNCTION stat ***
							
	Cette méthode calculs les statisques sur les supports multimedia.

	Paramètres d'entrées: aucun

	Résultat retourné:
	Un tableau contenant la liste des supports (clé) et le nombre de documents (valeur)
	*************************************************0******************************************/
	function stat() {
	
	if ($this->liste_supports == null) {$this->liste_supports();}
	
	foreach($this->liste_supports as $cle => $support){
		$requete = "SELECT count(*) as nbr FROM ".$this->nom_table." WHERE type=".$this->type_documents_multimedia." AND id_support=".$support->id()." AND valide=1 ORDER BY id ASC";
		$nombre = $this->SQL_exec_requete($requete,JEUX_RESULTAT_ASSOCIATIF);
		$nbr[$support->libelle()] = $nombre['nbr'];
	}
	
	return $nbr;
	}

	
}
?>
