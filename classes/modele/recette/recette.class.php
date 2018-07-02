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

class recette  {
	private $entete				= null;
	private $ingredients		= [];
	private $pas				= [];
	
	private $qte_total			= 0;
	
			
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
	$this->ingredients();
	$this->pas();
			
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
			if (is_object($value)) {
				$donnees[$key] = $value->to_array();
			}else{
				$donnees[$key] = $value;
			}		
		}else{
			foreach ($value as $key2 => $value2) {
				$donnees[$key][$key2] = $value2->to_array();
			}	
		}		
	}
	return $donnees;
	}
	
	// Liste des getters/setters
	public function entete($valeur=null)
	{
		
	if ($valeur == null) {
		if ($this->entete == null) {
			return $this->entete = new entete();
		}else{
			return $this->entete;
		}	
	}else{
		 if (is_array($valeur)){
			$this->entete = new entete($valeur);
		}
		
	}		
	}
	
	
	public function ingredients($valeur=null)
	{
	if ($valeur == null) {
		if ($this->ingredients == null) {
			return $this->ingredients[0] = new ingredient();
		}else{
			return $this->ingredients;
		}	
	}else{
		 if (is_array($valeur)){
			foreach ($valeur as $cle => $ingredient){
				$this->ingredients[$cle] = new ingredient($ingredient);
			}
		}
		
	}		
	}
	
	public function pas($valeur=null)
	{
	if ($valeur == null) {
		if ($this->pas == null) {
			return $this->pas[0] = new pas();
		}else{
			return $this->pas;
		}	
	}else{
		 if (is_array($valeur)){
			foreach ($valeur as $cle => $pas){
				$this->pas[$cle] = new pas($pas);
			}
		}
	}		
	}
	
	public function qte_total($valeur=null)
	{
	if ($valeur == null) {
		return $this->qte_total;
	}else{
		
		$qte_total = (int) $valeur;
		 if ($qte_total > 0){
			$this->qte_total = $this->qte_total + $qte_total;
		}
	}		
	}
	
}

