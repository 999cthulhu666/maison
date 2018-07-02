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

namespace modele\recette;

class ingredient{
	private $id					= 0;
	private $libelle			= '';
	private $unite				= 'g';
	private $fcv				= 0;
	private $fiche				= '';
	private $image				= '';
	private $quantite			= 0;
	private $version			= 0;
	private $lien				= '';
	private $valide				= 1;
	
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
		$donnees[$key] = $value;
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
			$this->libelle = htmlspecialchars($valeur,ENT_QUOTES);
		}
	}		
	}
	
	public function unite($valeur=null)
	{
	if ($valeur == null) {
		return $this->unite;
	}else{
		 if (is_string($valeur)){
			$this->unite = htmlspecialchars($valeur,ENT_QUOTES);
		}
	}		
	}
	
	public function fiche($valeur=null)
	{
	if ($valeur == null) {
		return $this->fiche;
	}else{
		 if (is_string($valeur)){
			$this->fiche = htmlspecialchars($valeur,ENT_QUOTES);
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
	
	public function quantite($valeur=null)
	{
	if ($valeur == null) {
		return $this->quantite;
	}else{
		$quantite = (int) $valeur;
		 if ($quantite > 0){
			$this->quantite = $quantite;
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
	
}

