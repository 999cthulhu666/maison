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


class gestion_recette extends BD {
	private $nom_table					='maison.REC_recette';
	private $nom_table_ingredient		='maison.REC_ingredient';
	private $nom_table_pas				='maison.REC_pas';
	private $nom_table_type				='maison.REC_type';
	private $nom_table_liste_ingredient	='maison.REC_liste_ingredient';
	private $nom_table_unite			='maison.REC_unite';
	
	private $recette;
	private $liste_type					= array();
	private $liste_ingredient			= array();
	private $liste_unite				= array();
	private $liste						= array();
	
	private $dernier_objet				= array();
	private $dernier_methode			= array();
			
	/*********************************************************************************************
					*** FUNCTION __construct ***

	Cette fonction initialise l'objet. Elle utilise une fonction de la classe parent Gestion_BD.

	Paramètre d'entrée:
	aucun
	 
	Résultat retourné: 
	aucun
	
	Version 	: V2018A
	*********************************************************************************************/
	function __construct() {
	
		
	//On appelle le constructeur du parent
	parent::__construct($this->nom_table);
			
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
	
	if (method_exists($this, $propriete)){
		return $this->$propriete()->liste;
	}else{
		return false;
	}		
	}
	
	
	function object_to_array($data)
	{
	
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = $this->object_to_array($value);
            echo $result[$key];
        }
        return $result;
    }
    return $data;
	}

	/*********************************************************************************************
					*** FUNCTION lire ***

	Cette méthode recherche une recette dans la table à l'aide de son ID.

	Paramètre d'entrée:
	$id	:	id dans la table recette
	 
	Résultat retourné: 
	Les enregistrements de la table suivant le tri demandé
	
	Version 	: V2018A
	*********************************************************************************************/
	function lire($id) {
		
	//Initialisation des variables	
	$HTMLingredients = [];
	$HTMLpas = [];
	$cle = 0;
			
	if (!is_numeric($id) ) {
		$this->erreur->afficher(['numero'=>3,__METHOD__,func_num_args(),'(int $id)']);return $this;	
	}
		
	//On cherche le nom, la photo, lien de la recette, version ....
	$requete = 'SELECT * FROM '.$this->nom_table.' WHERE id='.$id;
	$recette['entete'] =  $this->SQL_exec_requete($requete,JEUX_RESULTAT_ASSOCIATIF);
	if($this->SQL_Erreur()) {$this->erreur->afficher(['numero'=>3,__METHOD__,2,'(int $id)']);return $this;}
			
	//On cherche la liste des ingrédients
	$requete = 'SELECT '.$this->nom_table_liste_ingredient.'.libelle ,'.$this->nom_table_liste_ingredient.'.unite ,'.$this->nom_table_ingredient.'.quantite ,'.$this->nom_table_liste_ingredient.'.id ,'.$this->nom_table_liste_ingredient.'.image,'.$this->nom_table_liste_ingredient.'.fiche  FROM '.$this->nom_table_ingredient.' INNER JOIN '.$this->nom_table_liste_ingredient.' ON '.$this->nom_table_ingredient.'.id_ingredient = '.$this->nom_table_liste_ingredient.'.id	WHERE '.$this->nom_table_ingredient.'.id_recette = '.$id.' AND  '.$this->nom_table_ingredient.'.version = '.$recette['entete']['version'];
	$recette['ingredients'] =  $this->SQL_exec_requete($requete,JEUX_RESULTAT_ASSOCIATIF);
    if($this->SQL_Erreur()) {$this->erreur->afficher(['numero'=>3,__METHOD__,2,'(int $id)']);return $this;}
	
	//On cherche la liste des pas de la recette
	$requete = 'SELECT id,numero,libelle FROM '.$this->nom_table_pas.' WHERE id_recette='.$id.' AND version = '.$recette['entete']['version'].' ORDER BY numero ASC';
	$recette['pas'] =  $this->SQL_exec_requete($requete,JEUX_RESULTAT_ASSOCIATIF);
			
	$this->recette = new \modele\recette\recette($recette);
	
	//var_dump($this->recette);
							
	//Poids total de la recette
	foreach ($this->recette->ingredients() as $ingredient){
				
		if ($ingredient->unite() == 'g') {
			$this->recette->qte_total($ingredient->quantite());
		}
		//Conversion "pièce" -> "g" : jaune d'oeuf
		if ($ingredient->id() == 2) {	//Un jaune d'oeuf = 20g
			$this->recette->qte_total($ingredient->quantite()*20);
		}
		
		
	}
		
	return $this->recette;
	}
	
	/******************************************************************************************
									*** FUNCTION liste ***
							
	Cette méthode liste des données d'après un paramètre d'entré.

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	function liste($tri='recette',$parametres=null)
	{
	
	switch ($tri) {
		case 'type':
			$this->liste = $this->liste_type();
		break;
		
		case 'unite':
			$this->liste = $this->liste_unite();
		break;
		
		case 'ingredient':
			$this->liste = $this->liste_ingredient();
		break;
		
		case 'recette':
			$this->liste = $this->liste_recette($parametres);
		break;
		
		default:
		   
		}
	return $this->liste;
	}
	

	/******************************************************************************************
									*** FUNCTION liste_type ***
							
	Cette méthode liste des types de recette.

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	private function liste_type()
	{
	//Initialisation des variables	
	$this->liste = [];
		
	$requete = "SELECT libelle,id FROM ".$this->nom_table_type." WHERE 1 ORDER BY id ASC";	
	
	$Tresultat  = $this->SQL_exec_requete($requete);
			
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $type){
			$this->liste[$cle]= new \modele\recette\type($type);
		}
	}
				
	return $this->liste ;
	}
	
	/******************************************************************************************
									*** FUNCTION liste_unite ***
							
	Cette méthode liste des types de recette.

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	private function liste_unite()
	{
	//Initialisation des variables	
	$this->liste = [];
		
	$requete = "SELECT libelle,id FROM ".$this->nom_table_unite." WHERE 1 ORDER BY id ASC";	
	
	$Tresultat  = $this->SQL_exec_requete($requete);
			
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $unite){
			$this->liste[$cle]= new \modele\recette\unite($unite);
		}
	}
		
	return $this->liste;
	}
	
	/******************************************************************************************
									*** FUNCTION liste_ingredient ***
							
	Cette méthode liste des types de recette.

	Paramètres d'entrées:
	aucun

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	private function liste_ingredient()
	{
	//Initialisation des variables	
	$this->liste = [];
		
	$requete = "SELECT * FROM ".$this->nom_table_liste_ingredient." WHERE 1 ORDER BY id ASC";	
	
	$Tresultat  = $this->SQL_exec_requete($requete);
		
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $ingredient){
			$this->liste[$cle]= new \modele\recette\ingredient($ingredient);
		}
	}
		
	return $this->liste;
	}
	
	
	/******************************************************************************************
									*** FUNCTION liste_recette ***
							
	Cette méthode liste des types de recette.

	Paramètres d'entrées:
	$categorie : sorte de recette (glace, sorber, patisserie, etc ...)

	Résultat retourné:
	Un tableau contenant la liste des genres
	
	Version 	: V2018A
	**********************************************************auteur***********************************/
	private function liste_recette($categorie=0)
	{
	//Initialisation des variables		
	$this->liste = [];
		
	if ($categorie==0){
		$requete = ("SELECT id,libelle, (SELECT libelle FROM ".$this->nom_table_type." WHERE id=T1.type) as _libelleType FROM ".$this->nom_table." AS T1 WHERE valide=1 ORDER BY id ASC");	
	}
	else{
		$requete = ("SELECT * FROM ".$this->nom_table." WHERE type=".$categorie['sorte']." AND valide=1 ORDER BY id ASC");
	}	
		
	$Tresultat  = $this->SQL_exec_requete($requete);
		
	if (is_array($Tresultat[0])) {
		foreach($Tresultat[0] as $cle => $entete){
			$this->liste[$cle]= new \modele\recette\recette(['entete'=>$entete]);
		}
	}
		
	return $this->liste;
	}
	

/******************************************************************************************
			*** FUNCTION Ajout ***
						
Cette méthode ajoute une recette.

Paramètres d'entrées:
$recette	: contenu de la recette
$maj		: mise à jour de la recette
* 		
Résultat retourné:
TRUE si pas d'erreur 
**********************************************************auteur***********************************/
function Ajout($recette) {

$this->Charger($recette);		//On charge la recette dans les données membres

//Ajout de la recette 
$requete ='INSERT INTO '.$this->nom_table_recette.'
			(libelle,image,type,lien,valide,version) 
			VALUES ("'.$this->nom.'","'.$this->photo.'","'.$this->type.'","'.$this->lien.'",1,"'.$this->version.'")';
$this->id = $this->SQL_exec_requete($requete);

if($this->SQL_Erreur()) {return false;}//Erreur requette

$this->AjoutIngredient();			//On rajoute les ingrédients
$this->AjoutPas();					//On rajoute les pas

//La fonction retourne la liste des ingrédients
return true;
}

/******************************************************************************************
			*** FUNCTION AjoutIngredient ***
						
Cette méthode ajoute les ingredients dans une recette (appel sans paramètres) ou un ingrédient (avec paramètres).

Paramètres d'entrées:
$Ingredient		: tableau contenant les données de l'ingrédients (optionnel)
					$Ingredient['libelle']	: nom de l'ingrédient
					$Ingredient['unite']	: unité
					$Ingredient['fiche']	: fiche de l'ingrédient
					$Ingredient['image']	: image de version de l'ingrédient
					$Ingredient['fcv']		: fcv
					$Ingredient['version']	: numéro de version de l'ingrédient
  
Résultat retourné:
TRUE si pas d'erreur 
**********************************************************auteur***********************************/
function AjoutIngredient($Ingredient=NULL) {

if ($Ingredient == NULL) {
	foreach ($this->ingredients as $index => $ingredient){
		$requete ='INSERT INTO '.$this->nom_table_liste_ingredients.'
					(id_ingredient,id_recette,quantite,version) 
					VALUES ("'.$ingredient.'","'.$this->id.'","'.$this->quantite[$index ].'","'.$this->version.'")';
		$this->SQL_exec_requete($requete);
		if($this->SQL_Erreur()) {return false;}//Erreur requette
	}
}else{
	if (is_array($Ingredient)) {
		return parent::AjoutIngredient($Ingredient);
	}else{
		return false;
	}		
}

return true;
}

/******************************************************************************************
			*** FUNCTION AjoutPas ***
						
Cette méthode ajoute les pas dans une recette.

Paramètres d'entrées:
N.A.
 
Résultat retourné:
TRUE si pas d'erreur 
**********************************************************auteur***********************************/
function AjoutPas() {

foreach ($this->pas as $index => $pas){
	$requete ='INSERT INTO '.$this->nom_table_pas.'
				(numero,id_recette,libelle,version) 
				VALUES ("'.$index.'","'.$this->id.'","'.$pas.'","'.$this->version.'")';
	$this->SQL_exec_requete($requete);
	if($this->SQL_Erreur()) {return false;}//Erreur requette
}

return true;
}

/******************************************************************************************
			*** FUNCTION Supprime ***
						
Cette méthode supprime une recette.

Paramètres d'entrées:
$Tid	: 	tableau contenant la liste des ID de la table.
		
Résultat retourné:
TRUE si pas d'erreur 
**********************************************************auteur***********************************/
function Supprime($id) {
$this->SQL_exec_requete('UPDATE '.$this->nom_table_recette.' SET valide=0 WHERE id="'.$id.'" LIMIT 1');
if($this->SQL_Erreur()) {return false;}//Erreur requette
return true;
}

/******************************************************************************************
			*** FUNCTION incremente_version ***
						
Cette méthode incremente la version de la recette.

Paramètres d'entrées:
N.A.
		
Résultat retourné:
N.A.
**********************************************************auteur***********************************/
private function incremente_version() {

$this->SQL_exec_requete('UPDATE '.$this->nom_table_recette.' SET version='.$this->version.',libelle="'.$this->nom.'",image="'.$this->photo.'",lien="'.$this->lien.'" WHERE id="'.$this->id.'" LIMIT 1');

}

/******************************************************************************************
			*** FUNCTION Modifier ***
						
Cette méthode met à jour une recette.

Paramètres d'entrées:
$recette	: contenu de la	recette.
		
Résultat retourné:
TRUE si pas d'erreur 
**********************************************************auteur***********************************/
function Modifier($recette) {

$this->Charger($recette);		//On charge la recette dans les données membres
$this->IncrementeVersion();			//On incremente la version de la recette
$this->AjoutIngredient();			//On rajoute les ingrédients
$this->AjoutPas();					//On rajoute les pas

return true;
}


}
?>
