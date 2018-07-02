<?php
/*

Nom classe 	:	recettes
Commentaire	:	Cette classe assure la gestion de la base de données des recettes
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


*/

namespace modele\multimedia;

class multimedia  {
	private $id				= 0;
	private $titre			= '';
	private $auteur			= null;
	private $support		= null;
	private $genre			= null;
	private $horodatage		= 0;
	private $commentaire	= '';
	private $annee			= 2018;
	private $critique		= 0;
	private $image			= '';
	private $chemin			= '';
	private $fichier		= '';
	private $lien			= '';
	private $valide			= 1;
	private $type			= 0;
	private $option			= 0;
	
	
			
	/*********************************************************************************************
					*** FUNCTION __construct ***

	Cette fonction initialise l'objet d'accès des données. 

	Paramètre d'entrée:
	$donnees : données à inserer dans la BD
	 
	Résultat retourné: 
	aucun
	
	Version 	: V2018A
	*********************************************************************************************/
	function __construct($donnees) {
		
	//Initialisation des variables	
	$param = [];
	$this->auteur();
	$this->genre();
	$this->support();
			
	if (is_array($donnees)) {		
		foreach ($donnees as $method => $value){
									
			switch ($method) {
				case 'auteur':	
					unset($value);
					if (is_array($donnees['auteur'])) {
						$value['id'] 		= $donnees['auteur']['id'];
						$value['libelle'] 	= $donnees['auteur']['libelle'];
					}else{
						$value['id'] 		= $donnees['id_auteur'];
						$value['libelle'] 	= $donnees['auteur'];
					}	
						
				break;
				
				case 'genre':	
					unset($value);
					if (is_array($donnees['genre'])) {
						$value['id'] 		= $donnees['genre']['id'];
						$value['libelle'] 	= $donnees['genre']['libelle'];
						$value['image'] 	= $donnees['genre']['image'];
					}else{
						$value['id'] 		= $donnees['id_genre'];
						$value['libelle'] 	= $donnees['genre'];
						$value['image'] 	= $donnees['image_genre'];
					}
							
				break;
				
				case 'support':	
					unset($value);
					if (is_array($donnees['support'])) {
						$value['id'] 		= $donnees['support']['id'];
						$value['libelle'] 	= $donnees['support']['libelle'];
					}else{
						$value['id'] 		= $donnees['id_support'];
						$value['libelle'] 	= $donnees['support'];	
					}
							
				break;
				
				default:
				
			}
				
			if (method_exists($this, $method)){
				$this->$method($value);
			}
	
		}
	}
	
	}
	
	public function __call($name, $arguments) {}
	
	/*********************************************************************************************
					*** FUNCTION to_array ***

	Cette méthode converti l'objet en un tableau. 

	Paramètre d'entrée:
	aucun
	 
	Résultat retourné: 
	aucun
	
	Version 	: V2018A
	*********************************************************************************************/    
    public function to_array(){
	foreach ($this as $key => $value) {
		
		if (!is_object($value)) {
			$donnees[$key] = $value;
		}else{
		
			$donnees[$key] = $value->to_array();
		}		
	}
	return $donnees;
	}
	
	// Liste des getters/setters
	public function id($valeur=null)
	{
	if ($valeur == null) {
		return $this->id;
	}else{
		
		$id = (int) $valeur;
		 if ($id >= 0){
			$this->id = $id;
		}
	}		
	}
	
	public function titre($valeur=null)
	{
	if ($valeur == null) {
		return $this->titre;
	}else{
		
		 if (is_string($valeur)){
			$this->titre = strtolower(trim($valeur));
		}
	}		
	}
	
	public function horodatage($valeur=null)
	{
	if ($valeur == null) {
		return $this->horodatage;
	}else{
		$this->horodatage =  $valeur;
	}		
	}
	
	public function commentaire($valeur=null)
	{
	if ($valeur == null) {
		return  $this->commentaire;
	}else{
		 if (is_string($valeur)){
			$this->commentaire = htmlspecialchars(strtolower(trim($valeur)),ENT_COMPAT);
		}
	}		
	}
	
	public function annee($valeur=null)
	{
	if ($valeur == null) {
		return $this->annee;
	}else{
		
		$annee = (int) $valeur;
		 if ($annee >= 0){
			$this->annee = $annee;
		}
	}		
	}
	
	public function critique($valeur=null)
	{
	if ($valeur == null) {
		return $this->critique;
	}else{
		
		$critique = (int) $valeur;
		 if ($critique >= 0){
			$this->critique = $critique;
		}
	}		
	}
	
	public function image($valeur=null)
	{
	if ($valeur == null) {
		return $this->image;
	}else{
		 if (is_string($valeur)){
			$this->image = strtolower(trim($valeur));
		}
	}		
	}
	
	public function chemin($valeur=null)
	{
	if ($valeur == null) {
		return $this->chemin;
	}else{
		 if (is_string($valeur)){
			$this->chemin = strtolower(trim($valeur));
		}
	}		
	}
	
	public function fichier($valeur=null)
	{
	if ($valeur == null) {
		return $this->fichier;
	}else{
		 if (is_string($valeur)){
			$this->fichier = strtolower(trim($valeur));
		}
	}		
	}
	
	public function lien($valeur=null)
	{
	if ($valeur == null) {
		return $this->lien;
	}else{
		 if (is_string($valeur)){
			$this->lien = strtolower(trim($valeur));
		}
	}		
	}
	
	public function valide($valeur=null)
	{
	if ($valeur == null) {
		return $this->valide;
	}else{
		
		$valide = (int) $valeur;
		 if ($valide >= 0){
			$this->valide = $valide;
		}
	}		
	}
	
	public function type($valeur=null)
	{
	if ($valeur == null) {
		return $this->type;
	}else{
		
		$type = (int) $valeur;
		 if ($type >= 0){
			$this->type = $type;
		}
	}		
	}
	
	public function option($valeur=null)
	{
	if ($valeur == null) {
		return $this->option;
	}else{
		
		$option = (int) $valeur;
		 if ($option >= 0){
			$this->option = $option;
		}
	}		
	}
	
	public function auteur($valeur=null)
	{
	if ($valeur == null) {
		return $this->auteur;
	}else{
		 if (is_array($valeur)){
			$this->auteur = new auteur($valeur);
		}
	}		
	}
	
	public function genre($valeur=null)
	{
	if ($valeur == null) {
		return $this->genre;
	}else{
		 if (is_array($valeur)){
			$this->genre = new genre($valeur);
		}
	}		
	}
	
	public function support($valeur=null)
	{
	if ($valeur == null) {
		if ($this->support == null) {
			return $this->support = new support();
		}else{
			return $this->support;
		}	
	}else{
		 if (is_array($valeur)){
			$this->support = new support($valeur);
		}
	}		
	}
		
}

