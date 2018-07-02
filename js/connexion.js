
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

gestionnaireEvenements();   //Gestion des evenements de la page

initialisationPage();

}

//***************************************************************************	
//Cette fonction initialise la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function initialisationPage(){

$("body").css({"background-image": 'url("../images/fond.png")'});

$(".liste-choix").selectmenu({
  select: function( event, ui ) {
		var element = $(event.target);
		
		//On change l'avatar
		if (element.hasClass('sites')) {	
			$("#connexion .avatar").attr({src:$(this).find("option:selected").attr("data-avatar-img")});
			//console.log($(this).find("option:selected").attr("data-avatar-img"));
		}
	}
});

}


//***************************************************************************	
//Cette fonction centralise tous les evements de la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function gestionnaireEvenements(){
	
$("body").intercepteur({
    type            : "click",
    cible           : "button",
    evenements      :{
                    "#bp-connexion"           :function(){reqVerificationAcces($("#utilisateur").val(),$("#mdp").val());}
    }
});

$("body").intercepteur({
    type            : "click",
    cible           : "form",
    evenements      :function(element,evt){
		evt.preventDefault()
                    
    }
});

}


//***************************************************************************	
//Cette fonction lance une requète ajax pour vérifier si l'utilisateur à les droits d'accès. 
//
//Argument		: 
// - identifiant    : utilisateur
// - mdp            :  mot de passe 
//
//Retour 		: N.A.
//
//Version 		: V2017A
//***************************************************************************	
function reqVerificationAcces(identifiant,mdp)
{

$().requeteAjax({
    url         : "/ajax/rAjax_connexion.php",
    parametres  : {utilisateur:identifiant,mdp:mdp},
    reussie     : function(reponse){verificationAcces(reponse);}
});

}


//***************************************************************************	
//Requete ajax terminé avec succés
//
//Argument		: 
//  	- Jreponse : résultat de la requete sous forme JSON
//
//Retour 		: aucun
//***************************************************************************	
function verificationAcces(reponse){

if (reponse.connexion == 'OK') { window.location.href =$(".liste-choix").val()+'.php?type='+$("#sites option:selected").attr("data-site");}

}


