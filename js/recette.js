var Objentete ={
	id				: 0,
	valide			: 1,
	libelle			: '',
	image			: 0,
	type			: '',
	lien			: '',
	version			: ''
}	

var Objpas ={
		id			: 0,
		libelle		: '',
		numero		: 0
}	

var Objingredient ={
		id			: 0,
		valide		: 1,
		libelle		: '',
		unite		: 0,
		fcv			: 0,
		fiche		: '',
		image		: '',
		quantite	: 0,
		version		: 0,
		lien		: ''
}	

var Objrecette ={
	entete			: Objentete,
	ingredients		: Objingredient,
	pas				: Objpas
}	


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
//Cette fonction charge le document du formulaire d'ajout
//
//Argument		: N.A.
//
//Retour 		:
//Le document multimedia 
//***************************************************************************	
function recetteCharge() {
var ingredients = [];
var pas = [];

Objrecette.entete =  $.extend({},Objentete,JSON.parse($("#recette").attr('data-recette')));	//Entete

$("#recette .liste-ingredient tbody tr:not(:last)").each(function(i,valeur) {
	ingredients[i] =  $.extend({},Objingredient,JSON.parse($(this).attr("data-ingredient")));
});

$("#recette .liste-pas tbody tr").each(function(i,valeur) {
	pas[i] =  $.extend({},Objpas,JSON.parse($(this).attr("data-pas")));
});

//var toto = JSON.parse($("#recette").attr('data-recette'));

Objrecette.ingredients	= ingredients;
//Objrecette.libelle		= $("#page h1").text();
Objrecette.pas			= pas;

console.log('recetteCharge');
console.log(Objrecette);

return Objrecette;

}

//***************************************************************************	
//Cette fonction met à jour l'ingrédient depuis le formulaire nouvelle ingrédient
//
//Argument		: N.A.
//
//Retour 		:
//l'ingrédient 
//***************************************************************************	
function ficheAjoutChargeNouvelIngredient() {
let ingredient = {};

ingredient.id			= $("#edition-liste-ingredient .libelle").attr('data-id');
ingredient.libelle		= $("#edition-liste-ingredient .libelle").val();
ingredient.quantite		= $("#edition-liste-ingredient .qte").val();
ingredient.unite		= $("#edition-liste-ingredient .unite").val();

$.extend(Objingredient,ingredient);

return Objingredient;

}

//***************************************************************************	
//Cette fonction met à jour le pas depuis le formulaire nouveau pas
//
//Argument		: N.A.
//
//Retour 		:
//Le pas de la recette 
//***************************************************************************	
function ficheAjoutChargePas() {
var dernierPas = $("#recette .liste-pas tbody").children("tr").length;

Objpas.id			= 0;
Objpas.libelle		= $("#edition-liste-pas .libelle").val();
Objpas.numero		= dernierPas +1;

return Objpas;

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

//Les boutons	
$("body").intercepteur({
    type            : "click",
    cible           : "button",
    evenements      :{
                    "#bp-enregistrer"           :function(){fenetreConfirmation('enregistrer');}

    }
});

//Le menu de droite
$("#menu-droite").intercepteur({
    type            : "click",
    cible           : "a",
    evenements      : function(element,event){
        var action = element.parents('div:first');
              
                      
        $('#menu-droite').find('a').removeClass("active");
        action.children('a').addClass("active");
                 
        //Menu genre       
        if (action.hasClass('recherche-genre')) {
			if ($("#menu-genre").is(":visible")) {
				modeListe();
			}else{
				$("#menu-genre").show();
			}	
        }
          
        //Liste       
        if (action.hasClass('liste')) {
			modeListe();
        }
        
        //Modifier       
        if (action.hasClass('modifier'))	 {
			modeEdition();	//On passe en mode edition
        }
		
		//Ajouter       
        if (action.hasClass('ajouter'))	 {
			ficheAjoutEfface();	//On efface la fiche
			modeEdition();	//On passe en mode edition
        }
        
        //Menu multiplicateur       
        if (action.hasClass('multi-ingredient')) {
			modeListe();
            recetteMultiplicateur(parseFloat(action.attr("data-multi")));
        }
	
		//Enregistrer
		if (action.hasClass('enregistrer')) {
			recetteCharge();
        }
        
    }
});

//Evenement change sur les INPUT et SELECT
$("body").intercepteur({
    type            : "change",
    cible           : "input",
    evenements      : function(element,event){
				
		//Controles des champs de saisie : INPUT
		if ( element.attr("type") != 'checkbox' && event.target.nodeName != 'SELECT' ) {    //On n'affiche pas de message d'erreur ni sur les CHECKBOX, ni sur les SELECT
			var erreur = (element).saisie();
			
            if(erreur !== true){
                msg.erreur({libelles:"Erreur de saisie|"+erreur});   
            }  
        }	
    }
});

//Evenement ajouter ingrédient ou pas
$(".edition .bouton").click(function(){
         
    //Ajouter un ingrédient      
	if ($(this).hasClass('ajouter-ingredient')) {
		recetteAjoutIngredient(ficheAjoutChargeNouvelIngredient());
	}

    //Ajouter un pas     
	if ($(this).hasClass('ajouter-pas')) {
		recetteAjoutPas(ficheAjoutChargePas());
	}


});

//Evenement supprimer ingrédient ou pas
$("#recette .liste-ingredient, #recette .liste-pas").intercepteur({
    type            : "click",
    cible           : ".bouton",
    evenements      : function(element,event){
		var action = element.parents('span:first');
						
		//Supprimer un ingrédient      
        if (action.hasClass('supprimer-ingredient')) {
			fenetreConfirmation('supprimer-ingredient',action);
		}
		
		//Modifier un ingrédient      
        if (action.hasClass('modifier-ingredient')) {
											   
			popupModifIngredient.dialogue({
				type    :'MODIF_INGREDIENT',
				valeur	:JSON.parse(element.parents('tr').attr('data-ingredient')),
				oui     :function(obj,nouvelIngredient){
										
					$.extend(Objingredient,nouvelIngredient);
					ficheModifIngredient(element.parents('tr'),Objingredient);
					}  
			});
		}
		
		//Supprimer un pas      
        if (action.hasClass('supprimer-pas')) {
			fenetreConfirmation('supprimer-pas',action);
		}
		
    }
});
	
}

//***************************************************************************	
//Affichage d'une fenetre de confirmation avant la suppression d'une ligne des tableaux
//
//Argument		: 
// - ligne  : ligne du tableau
// - option   : 
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************
function fenetreConfirmation(type,option){

switch(type) {
    case 'enregistrer':
        if (ficheAjoutVerification()){
            popup.dialogue({
                  titre   :'Enregistrement',
                  msg     :'Voulez-vous enregistrer le document <strong>'+$('#ajout .titre').val()+'</strong> ?',
                  type    :'CONFIRM',
                  oui     :function(){ficheAjoutRAjax();}  
            });
        }    
    break;
   
    case 'supprimer-ingredient':
		let ingredient = JSON.parse(option.parents('tr').attr("data-ingredient"));
    
		popup.dialogue({
			  titre   :'Supprimer ingrédient',
			  msg     :'Voulez-vous supprimer l\'ingrédient <strong>'+ingredient.libelle+'<strong> ?' ,
			  type    :'CONFIRM',
			  oui     :function(){option.parents("tr").remove();}  
		});
  
    break;
    
    case 'supprimer-pas':
		popup.dialogue({
			  titre   :'Supprimer pas',
			  msg     :'Voulez-vous supprimer ce pas ?' ,
			  type    :'CONFIRM',
			  oui     :function(){option.parents("tr").remove();}  
		});
  
    break;
    
    case 'ajouter-ingredient':
		popup.dialogue({
			  titre   :'Nouvelle ingrédient',
			  msg     :'Voulez-vous ajouter un nouvel ingrédient <strong>'+option.val()+'</strong> ?' ,
			  type    :'CONFIRM',
			  oui     :function(){alert('ajax - ajout ingredient');},  
			  non	  :function(){option.val('');}  	
		});
  
    break;
    
    case 'ajouter-unite':
		popup.dialogue({
			  titre   :'Nouvelle unité',
			  msg     :'Voulez-vous ajouter une ouvelle unité <strong>'+option.val()+'</strong> ?' ,
			  type    :'CONFIRM',
			  oui     :function(){alert('ajax - ajout ingredient');},
			  non	  :function(){option.val('');}   
		});
  
    break;
    
    default:
   
} 
}

//***************************************************************************	
//Cette fonction envoie les données au serveur : ajout
//
//Argument		: aucun
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function ficheAjoutRAjax(){
var document = ficheAjoutChargeDocument();
var fonction;

//console.log(document);
return;

if (document.id != 0) {
	fonction = 'modifier';
}else{
	fonction = 'ajouter';
}

$().requeteAjax({
	url         : "/ajax/rAjax_multimedia_modif.php",
	parametres  : {fonction:fonction,document:document},
	reussie     : function(reponse){}
});

}

//***************************************************************************	
//Cette fonction lance un requete AJAX pour mettre à jour la liste des recettes d'un certain type.
//
//Argument		: 
// categorie  : type de recette (sorbet, patisserie, etc ...)
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function recetteListeRAjax(categorie){
//console.log(categorie);
			 
$().requeteAjax({
	url         : "/ajax/rAjax_recette.php",
	parametres  : {fonction:'categorie',option:categorie},
	reussie     : function(reponse){recetteMaJListe(reponse);}
});

}

//***************************************************************************	
//Cette fonction met à jour la liste des recettes associé à une catégorie
//
//Argument		: 
// liste : la liste de recettes d'un certain type.
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function recetteMaJListe(liste){

$("#menu-genre .recette").children().remove();
			 
$.each(liste.recettes,function (index,recette) {
	$("#menu-genre .recette").append('<option value="'+recette.entete.id+'">'+recette.entete.libelle+'</option>');
});

$("#menu-genre .recette").selectmenu( "refresh" );

recetteLireRAjax(liste.recettes[0].entete.id);	//recette par défaut

}


//***************************************************************************	
//Cette fonction lance un requete AJAX pour lire une recette.
//
//Argument		: 
// categorie  : type de recette (sorbet, patisserie, etc ...)
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function recetteLireRAjax(id){
//console.log(id);
			 
$().requeteAjax({
	url         : "/ajax/rAjax_recette.php",
	parametres  : {fonction:'lire',option:id},
	reussie     : function(reponse){recetteAfficher(reponse);}
});

}

//***************************************************************************	
//Cette fonction met à jour la liste des recettes associé à une catégorie
//
//Argument		: 
// liste : la liste de recettes d'un certain type.
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function recetteAfficher(r){
//console.log(r.recette);
$("#recette .liste-ingredient tbody,#recette .liste-pas tbody").empty();	//On vide la recette en cours

$("#page-gauche img").attr('src','/images/recettes/'+r.recette.entete.image);	//Image

$("#page h1").html(r.recette.entete.libelle.toUpperCase());	//Titre

$("#recette").attr({'data-recette':JSON.stringify(r.recette.entete)});	//Entete

//Liste des ingrédients
for (i = 0; i < r.recette.ingredients.length; i++) {
	recetteAjoutIngredient(r.recette.ingredients[i]);
} 

//Quantité total des ingrédients de la recette
$("#recette .liste-ingredient tbody").append('<tr class="qte-total"><td class="text-right success">Poids total de la recette : </td><td class="text-center success" name="qte-total" >'+r.recette.qte_total+'</td><td class="text-left success">g</td><td class="text-left success"></td></tr>');

//Liste des pas
for (i = 0; i < r.recette.pas.length; i++) {
	recetteAjoutPas(r.recette.pas[i]);
} 

//Tooltip sur les ingrédients
$("#recette .liste-ingredient tbody td[name=libelle]").tooltip({
      items: "[data-ingredient]",
      content: function() {
        var element = $( this );
        var ingredient = JSON.parse(element.attr("data-ingredient"));
                 
        return "<img class='recette-vignette' alt='" + ingredient.image +"' src='../images/recettes/ingredients/"+ingredient.image+"'><h3>"+ingredient.libelle+"</h3><p class='text-justify'>"+ingredient.fiche+"</p>";
      }
});

modeListe();

//Pour les recettes de confiture
if (r.recette.entete.type == 5) { confiture();} 
}

//***************************************************************************	
//Cette fonction recalcul la quantité des ingrédients pour la confiture : on saisie la quantité de fruits et on en deduit la quantité des autres ingrédients.
//On recalcul le sucre également en fonction du °brix saisie.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************
function confiture()
{
qteMaxFruits = 3000;
	
$("#recette .liste-ingredient tbody td:contains('fruits')").next().empty().append('<input id="mesure-fruit" class="text-right" placeholder="1000" title="Veuillez saisir un nombre." />');  
$("#recette .liste-pas tbody tr:eq(5)").children("td:first").append('<input id="mesure-brix"  placeholder="°Brix mesurer" title="Veuillez saisir un nombre." />');

$("#mesure-brix").change(function() {
	$("#recette .liste-ingredient tbody td:contains('sucre')").next().empty().text(confitureCalculDegreBrix(parseFloat($(this).val())));
});

$("#mesure-fruit").change(function() {
	var ligne = $(this).parent().parent();
	var ingredient = JSON.parse(ligne.attr("data-ingredient"));
	
	if (parseFloat($(this).val()) > qteMaxFruits ) {
		msg.erreur({libelles:"Confiture|La quantitée de fruit saisie dépasse la capacité de la bassine"});
		$(this).val(qteMaxFruits);	
	}
	
	confitureReCalculIngredient($(this).val(),ingredient.quantite);
	
});

}

//***************************************************************************	
//Cette fonction recalcul la quantité des ingrédients pour la confiture
//
//Argument		: 
// - qteFruit : 
// - qteFruitOrigine : 
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function confitureReCalculIngredient(qteFruit,qteFruitOrigine)
{
var rapport = parseFloat(qteFruit)/parseFloat(qteFruitOrigine);
var qteTotal = 0;

$("#recette .liste-ingredient tbody tr").not(".qte-total").each(function(i,valeur) {
	var ingredient = JSON.parse($(this).attr("data-ingredient"));
	var qte = (parseFloat(ingredient.quantite) * rapport);
	
	qteTotal = qteTotal + qte;
	
	$(this).find("td:eq(1)").text(qte);
	
});

$("#recette .liste-ingredient tbody .qte-total").children('[name=qte-total]').text(qteTotal);
}

//***************************************************************************	
//Cette fonction met à jour le formulaire d'ajout à partir de la fiche de détails.
//
//Arguments     : 
// document : le details du document multimedia
// 
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function recetteAjoutIngredient(ingredient){

$("#recette .liste-ingredient tbody").prepend('<tr data-ingredient=\''+JSON.stringify(ingredient)+'\'><td name="libelle">'+ingredient.libelle+'</td><td class="text-center" name="quantite" >'+ingredient.quantite+'</td><td name="unite">'+ingredient.unite+'</td><td><span class="edition bouton supprimer-ingredient curseur"><i class="fas fa-trash-alt poubelle"></i></span> <span class="edition bouton modifier-ingredient curseur"><i class="fas fa-edit modifier"></i></span></td></tr>');

}

//***************************************************************************	
//Cette fonction met à jour l'ingrédient modifié.
//
//Arguments     : 
// ligne : la ligne modifiée
// ingredient : ingrédient modifier
// 
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function ficheModifIngredient(ligne,ingredient){

ligne.find("[name=libelle]").text(ingredient.libelle);
ligne.find("[name=quantite]").text(ingredient.quantite);
ligne.find("[name=unite]").text(ingredient.unite);	

ligne.attr({'data-ingredient':JSON.stringify(ingredient)});

}

//***************************************************************************	
//Cette fonction met à jour le formulaire d'ajout à partir de la fiche de détails.
//
//Arguments     : 
// document : le details du document multimedia
// 
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function recetteAjoutPas(pas){

$("#recette .liste-pas tbody").append('<tr data-pas=\''+JSON.stringify(pas)+'\'><td>'+pas.libelle+'</td><td><span class="edition bouton supprimer-pas curseur" ><i class="fas fa-trash-alt poubelle"></i></span> <span class="edition bouton modifier-ingredient curseur" ><i class="fas fa-edit modifier"></i></span></td></tr>');

}


//***************************************************************************	
//Cette fonction efface la fiche.
//
//Arguments     : aucun
// 
//Retour 		: aucun 
//
//Version 		: V2018A
//***************************************************************************	
function ficheAjoutEfface(){
$("#recette .liste-ingredient tbody").children().remove();
$("#recette .liste-pas tbody").children().remove();
$("#page h1").text('Nouvelle recette');


}


//***************************************************************************	
//Cette fonction vérifie si les données du type mout sont cohérentes.
//
//Arguments             : aucun
// 
//Retour 		: 
//FALSE/TRUE : données correctes ou pas
//
//Version 		: V2017A
//***************************************************************************	
function ficheAjoutVerification(){

if (!$("#ajout").find("[data-saisie]").saisie()){
    msg.erreur({libelles:"Erreur de saisie|Veuillez vérifier ou completer les champs manquants"});	
    return false;
}

return true;
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
function modeEdition(){
	

$("#menu-genre").hide();	
$(".edition").show();

}


//***************************************************************************	
//Cette affiche la liste des documents.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function modeListe(){

$("#menu-genre").hide();	
$(".edition").hide();

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

modeListe();

$(".liste-choix").selectmenu({
  select: function( event, ui ) {
		var element = $(event.target);
		
		//Tri sur les catégories de recette
		if (element.hasClass('categories')) {	
			recetteListeRAjax(ui.item.value);
		}
		
		//Tri sur les catégories de recette
		if (element.hasClass('recette')) {
			recetteLireRAjax(ui.item.value);
		}
	}
});

recetteLireRAjax(3);	//recette par défaut

ficheAjoutListeAutoComplete();

}

//***************************************************************************	
//Cette fonction met à jour l'auto-complete. 
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function ficheAjoutListeAutoComplete()
{
				
$( "#edition-liste-ingredient input[name=ingredient],#fen_modif_ingredient input[name=libelle]" ).autocomplete({
	source		:JSON.parse($("#liste-ingredient").val()),
	select		: function( event, ui ) {
		//Ingrédient existant
		$(this).attr({'data-id':ui.item.id});
	},
	change		: function( event, ui ) {
		if (ui.item == null) {
			//Nouvelle ingredient
			fenetreConfirmation('ajouter-ingredient',$(this))
		}	
	}
});

$( "#edition-liste-ingredient input[name=unite],#fen_modif_ingredient input[name=unite]" ).autocomplete({
	source		:JSON.parse($("#liste-unite").val()),
  	select		: function( event, ui ) {

	},
	change		: function( event, ui ) {
		if (ui.item == null) {
			//Nouvelle unite
			fenetreConfirmation('ajouter-unite',$(this))
		}	
	}	
});

}


//***************************************************************************	
//Cette fonction télécharge une image
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function ficheAjoutTelechargerImage() {

$('#fileupload').fileupload({
	dataType		: 'json',
	url				: '/upload_img/php/image_jaquettes.php',
	done			: function (e, data) {	//Terminé correctement
						$.each(data.result.files, function (index, file) {
							//console.log(data);	
							$("#ajout .image").attr("data-image-fichier",file.name);
							$("#ajout .image").attr("data-image-chemin",'images/jaquettes/');
							$("#ajout .image").val(file.name);
							$("#details .jaquette").attr('src','images/jaquettes/'+file.name);
							
						});
					},
	fail			: function (e, data) {	//Terminé avec erreur
						 alert(data.errorThrown+' - '+data.textStatus);
						
					},
	start			: function (e, data) {	//Démarrage
						//console.log('start');
					}
});

}

//***************************************************************************	
//Cette fonction calcul la quantité de sucre à rajouter dans la consiture d'après le degré Brix mesuré
//
//Argument		:
// - mesure 	: mesure en °brix
//
//
//Retour 		: aucun
// La quantité de sucre à ajouter à la recette de confiture
//
//Version 		: V2018A
//***************************************************************************	
function confitureCalculDegreBrix(mesure)
{
var qteTotal = 0;
var qteSucreAjouter = 0;

qteTotal 		= parseFloat($(".liste-ingredient .qte-total").children("td[name=qte-total]").text());
qteSucreAjouter = ((62 * qteTotal) - (mesure * qteTotal))/100;

if (isNaN(qteSucreAjouter) || qteSucreAjouter < 0 ) { return 0;}
	
return qteSucreAjouter;

}


//***************************************************************************	
//Cette fonction permet de faire de multiplier les quantitées de la recette
//
//Argument		:
// - multiplicateur 	: multiplicateur 
//
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function recetteMultiplicateur(multiplicateur)
{
var tableau 	= $("#recette .liste-ingredient tbody tr:not(:last)");
var qteTotal 	= 0;

tableau.each(function(i){
	
	ligne	= $(this);
			
	ingredient = JSON.parse(ligne.attr("data-ingredient"));
	  		
	qte =  multiplicateur * parseFloat(ingredient.quantite);
	
	if (ingredient.unite == 'g') {qteTotal = qteTotal + qte;}
	
	if (ingredient.unite == 'pièce') {
		switch (ingredient.id) {
		  case 1:
			qteTotal = qteTotal + (qte*50);	//Un d'oeuf = 50g
			break;
		  case 2:
			qteTotal = qteTotal + (qte*20);	//Un jaune d'oeuf = 20g
			break;
		  
		  default:
			
		}
	}
		
	ligne.find("td:eq(1)").text(qte);

});

//Quantité total de la recette
$("#recette .liste-ingredient tbody td[name=qte-total]").text(qteTotal);
 
}
