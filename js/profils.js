
//***************************************************************************	
//Cette fonction est excecuté à la fin du chargement de la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function main(){

animations();
 
}


//***************************************************************************	
//Cette fonction anime tous les éléments sur la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function animations(){

boutons();  //On affiche les boutons de la page

}


//***************************************************************************	
//Cette fonction affiche les boutons de la page.
//
//Argument		: 
// p.grise (optionnel): TRUE/FALSE on grise/on affiche le bouton 
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function boutons(p){
// Paramètres
var p = $.extend({
	//Options
	grise       : null
},p);
        
//-------------------------------------------------	
//On grise/on active tous les boutons de la page
if (p.grise != null) {
    $(".btn").each(function(){ $(this).bouton({grise:p.grise});});
    return true;
}

//Création des bontons ajout ligne
$("#bpChangementMpd").bouton({
    icone       : "glyphicon-edit",
    bootstrap   : "btn-danger btn-lg",
    sur_clique  : function(){modificationUtilisateur();}
});   

}

//***************************************************************************	
//Cette fonction envoie les données de l'utilisateur au serveur.
//
//Argument		: aucun
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function modificationUtilisateur(){
var form =  $("#utilisateur").serializeJSON();

//Vérification des nouveaux mot de passe
if (form.utilisateur.mdp.nouveau1 != form.utilisateur.mdp.nouveau2){
    msg.erreur({libelles:"Erreur de saisie| La confirmation du nouveau mot de passe n'est pas correcte."}); 
    return false;
}

$().requeteAjax({
    url         : "/ajax/rAjax_profils.php",
    parametres  : {utilisateur:chargeUtilisateur(form)},
    reussie     : function(reponse){ RequeteAjaxOK(reponse);}
});
}
 
//***************************************************************************	
//Cette fonction cherche les données de l'utilisateur.
//
//Argument		: aucun
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function chargeUtilisateur(form){

var utilisateur = {
    id			:form.utilisateur.id,
    identifiant         :'',
    nom			:'',
    groupe              :'',
    mot_de_passe        :form.utilisateur.mdp.nouveau1,
    droit		:'',

};

return utilisateur;
}

//***************************************************************************	
//Requete ajax terminé avec succés
//
//Argument		: 
//  - Jreponse : résultat de la requete sous forme JSON
//
//Retour 		: aucun
//***************************************************************************	
function RequeteAjaxOK(Jreponse){
  
 popup.dialogue({
    titre   :'Changement du mot de passe',
    msg     :'Changement du mot de passe effectué.',
    type    :'INFO'
});

}