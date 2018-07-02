<?php
/*

Nom classe 	:	recette/entete
Commentaire	:	Cette classe ...
Version		: 	2018A

________________________________________________________________________________________________________
--------------------------------------------------------------------------------------------------------
--------------------------------- Historique des révisions  --------------------------------------------
--------------------------------------------------------------------------------------------------------
Version        Date         Commentaire



________________________________________________________________________________________________________ 


Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2018A
function __construct()									: Cette méthode initialise l'objet.


*/

namespace modele\recette;

class entete  {
	private $id					= 0;
	private $libelle			= '';
	private $image				= 'no-image.jpg';
	private $type				= 0;
	private $lien				= '';
	private $valide				= 1;
	private $version			= 0;
	
	private $ordre				= 'milieu';
				
	/*********************************************************************************************
					*** FUNCTION __construct ***

	Cette fonction initialise l'objet d'accès des données. 

	Paramètre d'entrée:
	$donnees : données à inserer dans la BD
	 
	Résultat retourné: 
	aucun
	
	Version 	: V2018A
	*********************************************************************************************/
	function __construct($donnees=null) {
				
	if (is_array($donnees)) {		
		foreach ($donnees as $method => $value){
			
			if (method_exists($this, $method)){
				$this->$method($value);
			}
		}
	}
	
	}
	
	public function __call($name, $arguments) {}
	
	public function to_array(){
	foreach ($this as $key => $value) {
		
		if (!is_array($value)) {
			$donnees[$key] = $value;
		}else{
			foreach ($value as $key2 => $value2) {
				$donnees[$key][$key2] = $value2->to_array();
			}	
		}		
	}
	return $donnees;
	}
	
	public function to_html($param=[]){return \conversion::to_html($this->to_array(),$param);}
	
	public function to_xml(){return \conversion::to_xml(substr(__class__,strrpos(__class__,'\\',-1)+1),$this->to_array());}
	
	// Liste des getters/setters
	public function ordre($valeur=null)
	{
	if ($valeur == null) {
		return $this->ordre;
	}else{
		 if (is_string($valeur)){
			$this->ordre = $valeur;
		}
	}		
	}
	
	public function id($valeur=null)
	{
	if ($valeur == null) {
		return $this->id;
	}else{
		
		$id = (int) $valeur;
		 if ($id > 0){
			$this->id = $id;
		}
	}		
	}
		
	public function libelle($valeur=null)
	{
	if ($valeur == null) {
		return $this->libelle;
	}else{
		
		 if (is_string($valeur)){
			$this->libelle = $valeur;
		}
	}		
	}
	
	public function image($valeur=null)
	{
	if ($valeur == null) {
		return $this->image;
	}else{
		 if (is_string($valeur)){
			$this->image = $valeur;
		}
	}		
	}
	
	public function type($valeur=null)
	{
	if ($valeur == null) {
		return $this->type;
	}else{
		
		$type = (int) $valeur;
		 if ($type > 0){
			$this->type = $type;
		}
	}		
	}
	
	public function lien($valeur=null)
	{
	if ($valeur == null) {
		return $this->lien;
	}else{
		 if (is_string($valeur)){
			$this->lien = $valeur;
		}
	}		
	}
	
	public function valide($valeur=null)
	{
	if ($valeur == null) {
		return $this->valide;
	}else{
		
		$valide = (int) $valeur;
		 if ($valide > 0){
			$this->valide = $valide;
		}
	}		
	}
	
	public function version($valeur=null)
	{
	if ($valeur == null) {
		return $this->version;
	}else{
		
		$version = (int) $valeur;
		 if ($version > 0){
			$this->version = $version;
		}
	}		
	}
	
}

