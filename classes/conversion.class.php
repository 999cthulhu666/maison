<?php
/*

Nom classe 	:	conversion
Commentaire	:	Cette classe contient des méthodes diverses de conversions.
Version		: 	2017A
 
Elle contient les méthodes suivantes :
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
static function DateMySql_to_DateString($date)				: Cette méthode converti une date sql en chaine.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Version : 2017A
static function cherche_nom_fichier(string $valeur='')  		: Cette méthode isole le nom du fichier dans un chemin complet.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
static function numero_ip($ip)                                          : Cette méthode isole le dernier chiffre de l'adresse IP.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
static function format_chaine($valeur)                                  : Cette méthode formater une chaine de caractère.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Version : 2017A
static function cherche_chemin_fichier(string $valeur='')  		: Cette méthode permet de chercher le répertoire dans lequel se trouve le fichier.

*/

class conversion{
	
    /*********************************************************************************************
                                                    *** FUNCTION DateMySqlToDateString ***

    Cette méthode converti une date sql en chaine.

    Paramètres d'entrés:
    $date : date en format MySQL (2009-05-27 09:04:50) 

    Résultats retournés:
    La méthode retourne la date au format string (13/05/2009 11:00:00)

    Version		: 	2017A
    *********************************************************************************************/
    static function DateMySql_to_DateString($date) { 

    //On verifie si l'horodate est complet, ou juste la date
    if (strlen($date) > 10) {
            $chaineDate = explode("-",$date); 
            $annee = $chaineDate[0];
            $mois = $chaineDate[1];
            $jour = substr ($chaineDate[2],0,2);
            $heure = substr ($chaineDate[2],-8,2);
            $minute = substr ($chaineDate[2],-5,2);
            $seconde = substr ($chaineDate[2],-2);
            $resultat = $jour."/".$mois."/".$annee." ".$heure.":".$minute.":".$seconde;

    }
    else {
            $chaineDate = explode("-",$date); 
            $annee = $chaineDate[0];
            $mois = $chaineDate[1];
            $jour = substr ($chaineDate[2],0,2);
            $resultat = $jour."/".$mois."/".$annee;

    }

    //La fonction retourne le résultat 
    return $resultat;
    }

    /******************************************************************************************
                            *** FUNCTION cherche_nom_fichier ***

    Cette méthode isole le nom du fichier dans un chemin complet.

    Paramètres d'entrées:
    $valeur	: dans le cas d'une écriture

    Résultat retourné:
    Valeur du membre

    Version 	: V2017A
    ******************************************************************************************/
    static function cherche_nom_fichier(string $valeur='') {
	return substr(strstr(strrchr($valeur,'\\'),'.',true),1); 
    }
	
	/******************************************************************************************
                            *** FUNCTION is_fichier ***

    Cette méthode détermine si le paramètre d'entré est un fichier.

    Paramètres d'entrées:
    $fichier	: le fichier

    Résultat retourné:
    TRUE = il s'agit d'un fichier

    Version 	: V2017A
    ******************************************************************************************/
    static function is_fichier(string $fichier='') {
	if (strpos($fichier,'.') === false) {
		return false;
	}	
	return true;
    }
    
    /******************************************************************************************
                            *** FUNCTION numero_ip ***

    Cette méthode isole le dernier chiffre de l'adresse IP.

    Paramètres d'entrées:
    $ip	: adresse IP a.b.c.d

    Résultat retourné:
    d

    Version 	: V2017A
    ******************************************************************************************/
    static function numero_ip($ip) {
    return substr(strrchr($ip,'.'),1);
    }

    /******************************************************************************************
                            *** FUNCTION cherche_chemin_fichier ***

    Cette méthode permet de chercher le répertoire dans lequel se trouve le fichier.

    Paramètres d'entrées:
    $valeur	: dans le cas d'une écriture

    Résultat retourné:
    Valeur du membre

    Version 	: V2017A
    ******************************************************************************************/
    static function cherche_chemin_fichier(string $valeur='') {
	
    return substr($valeur,0,strripos($valeur, "/")+1); 
    }

    /******************************************************************************************
                            *** FUNCTION format_chaine ***

    Cette méthode formater une chaine de caractère.

    Paramètres d'entrées:
    $valeur	: chaine

    Résultat retourné:
    Chaine formater

    Version 	: V2017A
    ******************************************************************************************/
    static function format_chaine($valeur) {
    return htmlspecialchars(trim($valeur),ENT_QUOTES); 
    }
    
    /******************************************************************************************
                            *** FUNCTION tableau_to_html ***

    Cette méthode converti un tableau de données en un tableau HTML.

    Paramètres d'entrées:
    $donnees                        : les données du tableau
    $parametres['ID_tableau']       : ID du tableau 
    $parametres['titres_colonnes']  : titres des colonnes
    $parametres['attribut_lignes']  : la valeur de l'attribut d'une ligne
    $parametres['nom_attribut_lignes'] : le nom de l'attribut d'une ligne
     
    Résultat retourné:
    Chaine formater

    Version 	: V2017A
    ******************************************************************************************/
    static function tableau_to_html($donnees,$parametres=null, $options=0) {
    
    $tableau = new tableau_html($donnees,$parametres,$options);
    
    return $tableau->afficher();
    }
    
    /******************************************************************************************
                            *** FUNCTION tableau_to_html ***

    Cette méthode converti un tableau de données en un tableau JSON.

    Paramètres d'entrées:
    $donnees                        : les données du tableau
        
    Résultat retourné:
    Chaine formater

    Version 	: V2017A
    ******************************************************************************************/
    static function tableau_to_json($donnees) {
    
    foreach($donnees as $index => $ligne){
      $Ttableau['data'][$index] = array_values($ligne);
    }
    return json_encode($Ttableau);
    }
    
    /*********************************************************************************************
                                *** function temps_execution ***

    Cette méthode calcul le temps d'éxecution de la page, d'un script, etc ...

    Paramètres d'entrés:
    $tempsDebut : temps de début
    $tempsFin   : temps de fin

    Résultats retournés:
    Un tableau avec $TtempsPage[0] = temps début, $TtempsPage[1] = temps de fin et $TtempsPage[2] = durée exécution

    Version 	: V2017A
    *********************************************************************************************/
    static function temps_execution($tempsDebut,$tempsFin) {
                
    //Durée
    $dureePage = $tempsFin - $tempsDebut;
      
    $TtempsPage[0] = date("H:i:s", $tempsDebut);    //Temps de Début
    $TtempsPage[1] = date("H:i:s", $tempsFin);  //Temps de fin
    $TtempsPage[2] = number_format($dureePage, 3);  //Durée
    
    return  $TtempsPage;    
    }
    
    
    /*********************************************************************************************
                                *** function to_html ***

    Cette méthode crée un tableau HTML

    Paramètres d'entrés:
    $tableau : tableau contenant les valeurs de la ligne
    $param : paramètres du tableau, attributs, class ...

    Résultats retournés:
    Un tableau HTML

    Version 	: V2018A
    *********************************************************************************************/
    static function to_html($tableau,$param){
	$tableau_html = '';
	
	if ($tableau['ordre'] == 'premier') {$tableau_html ='<table '.$param['table'].'>';}
	
	$tableau_html .='<tr>';	
	
	foreach ($tableau as $key => $value) {
		$attr = '';
		
		if (is_array($param['attributs'])){
			foreach ($param['attributs'] as $cle => $attribut) {
				$attr .= $cle.'="'.$attribut.'"';
			}	
		}
		
		if (is_array($param['colonnes'])){	
			if ( in_array($key,$param['colonnes']) ) {
				$tableau_html .= '<td '.$attr.' >'.$value.'</td>';	
			}	
		}	
	}
	
	if ($tableau['ordre'] == 'dernier') {$tableau_html.='</table>';}
	
	return $tableau_html .='</tr>';	
	}

	
	/*********************************************************************************************
                                *** function to_xml ***

    Cette méthode crée un tableau HTML

    Paramètres d'entrés:
    $nom : libelle du XML
    $tableau : tableau contenant les valeurs XML

    Résultats retournés:
    Une chaine XML

    Version 	: V2018A
    *********************************************************************************************/
    static function to_xml($nom,$tableau){
	
	if (!is_array($tableau)) {return false;}
	
	$tableau_xml = '';
	
	if ($tableau['ordre'] == 'premier') {$tableau_xml ='<root>';}
	
	$tableau_xml .='<'.$nom.'>';	
	
	foreach ($tableau as $key => $value) {
		$tableau_xml .= '<'.$key.'>'.$value.'</'.$key.'>';	
	}
	
	if ($tableau['ordre'] == 'dernier') {$tableau_xml.='</root>';}
	
	return $tableau_xml .='</'.$nom.'>';	
	}
	
    /*********************************************************************************************
                                *** function ordre_liste ***

    Cette méthode met à jour le propriété ordre dans un tableau d'objet. L'élément 0 = premier, le dernier élément du tableau = dernier 

    Paramètres d'entrés:
    $obj : un tableau 
    
    Résultats retournés:
    On rajoute ['ordre']='premier' pour le premier élément du tableau et ['ordre']='dernier' pour le dernier élément.

    Version 	: V2018A
    *********************************************************************************************/		
	static function ordre_liste($obj){
	
	if (is_array($obj[0][0])){		
			$obj[0][0]['ordre']					= 'premier';	
			$obj[0][count($obj[0])-1]['ordre']	= 'dernier';			
	}
		
	return $obj;
	}
		
}
?>
