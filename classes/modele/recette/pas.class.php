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

class pas  {
	private $id					= 0;
	private $libelle			= '';
	private $numero				= 1;
	
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
	
	public function numero($valeur=null)
	{
	if ($valeur == null) {
		return $this->numero;
	}else{
		$numero = (int) $valeur;
		 if ($numero > 0){
			$this->numero = $numero;
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
}
