var ObjdocumentAuteur ={
		id			: 0,
		libelle		: ''
}		

var ObjdocumentGenre ={
		id			: 0,
		libelle		: ''
}	

var ObjdocumentSupport ={
		id			: 0,
		libelle		: '',
		type		: 0
}	

var Objdocument ={
	id				: 0,
	titre			: '',
	auteur			: ObjdocumentAuteur,
	support			: ObjdocumentSupport,
	genre			: ObjdocumentGenre,
	horodatage		: 0,
	commentaire		: '',
	annee			: 2018,
	critique		: 0,
	image			: '',
	chemin			: '',
	fichier			: '',
	lien			: '',
	valide			: 1,
	type			: 0,
	option			: 0
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

choixPage();
 
gestionnaireEvenements();   //Gestion des evenements de la page

tableauAffiche();

initialisationPage();

}

//Cette fonction charge le document du formulaire d'ajout
//
//Argument		: N.A.
//
//Retour 		:
//Le document multimedia 
function ficheAjoutChargeDocument() {

Objdocument.titre		= $("#ajout .titre").val();
Objdocument.auteur.libelle	= $("#ajout .auteur").val();
Objdocument.auteur.id	= $("#ajout .auteur").attr("data-id-auteur");
Objdocument.support.libelle= $("#ajout .supports").val();
Objdocument.support.id	= $("#ajout .supports").find('option:selected').attr("data-id");
Objdocument.genre.libelle	= $("#ajout .genres").val();
Objdocument.genre.id	= $("#ajout .genres").find('option:selected').attr("data-id");
Objdocument.commentaire= $("#ajout .commentaire").val();
Objdocument.annee		= $("#ajout .annee").val();
Objdocument.image		= $("#ajout .image").attr("data-image-fichier");
Objdocument.lien		= $("#ajout .lien").val();
Objdocument.note		= $("#details .liste-notes").attr("data-note");

return Objdocument;

}

//***************************************************************************	
//Cette fonction met à jour le note critique du document
//
//Argument		: aucun
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function documentsMajRAjax(fonction){
			 
$().requeteAjax({
	url         : "/ajax/rAjax_multimedia_modif.php",
	parametres  : {fonction:fonction},
	reussie     : function(reponse){
				if(reponse.confirmation == 'oui'){
					fenetreConfirmation('maj',reponse);
				}else{
					alert('test');
				}		
			}
});

}

	
	
//***************************************************************************	
//Cette fonction affiche le type de page demandé. 
//
//Argument		: aucun
//
//Retour 		: aucun
//***************************************************************************	
function choixPage(){
var chemin =  $("#entete img").attr('src')

switch($("#type_multimedia").val().toUpperCase()) {
    case 'FILMS':
        $("#entete img").attr({src:chemin+'/film.jpg'});
		$(".jaquette").css({height:213,width:160});
        break;
    case 'MUSIQUE':
        $("#entete img").attr({src:chemin+'/vinyle.jpg'});
		$("#details .note").hide();
		$("#menu_context_note").hide();
        break;
    default:
        
} 

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
$("body").intercepteur({
    type            : "click",
    cible           : "a",
    evenements      : function(element,event){
        var action;
                
        if (event.target.nodeName == 'svg') {
			action = element.parent();
		}else if ( event.target.nodeName == 'path'){
			action = element.parent().parent();
		}else{
			action = element;
		}			
        
        action.parent().children().removeClass("active");
                
        //Menu genre       
        if (action.hasClass('recherche-genre')) {
			if ($("#menu-genre").is(":visible")) {
				modeListe();
			}else{
				modeRechercherGenre();
			}	
            action.addClass("active");
        }
        
        //Ajouter       
        if (action.hasClass('ajouter'))	 {
			ficheAjoutEfface();	//On efface la fiche
			modeEdition();	//On passe en mode edition
            action.addClass("active");
        }
        
        //Liste       
        if (action.hasClass('liste')) {
			modeListe();
            action.addClass("active");
        }
        
        //Mise à jours de la liste des documents       
        if (action.hasClass('maj')) {
			action.addClass("active");
			documentsMajRAjax('liste_maj');
        }
        
    }
});

//Clique sur les images dans la fenêtre de détail
$("body").intercepteur({
    type            : "click",
    cible           : "img",
    evenements      : function(element,event){

        if (element.hasClass("note")) {	//Mise à jour de la note critique
			var note = $(this).data("num");	
			noteCritiqueMAJ(note);
		}
		
		if (element.hasClass("modifier")) {	//Modification de la fiche
			modeEdition();
			ficheAjoutAffiche();
		}
	
    }
});

//Evenement change sur les INPUT et SELECT
$("body").intercepteur({
    type            : "change",
    cible           : "input",
    evenements      : function(element,event){
									
		//Copie formulaire ajout => vue détail		
		if (element.hasClass('titre')) {	
			$("#details .titre h1 span:first").text(element.val());
		}
		
		if (element.hasClass('annee')) {	
			$("#details .titre h1 span:last").text(element.val());
		}
		
		if (element.hasClass('commentaire')) {	
			$("#details .commentaire").text(element.val());
		}
		
		if (element.hasClass('lien')) {
			if (element.val() != '') {	
				$("#details .lien").empty().append('<i class="fas fa-link"></i> <a href="'+element.val()+'" target="_blank">Fiche allociné</a>');
			}else{
				$("#details .lien").empty();
			}		
		}
				
		//Controles des champs de saisie : INPUT
		if ( element.attr("type") != 'checkbox' && event.target.nodeName != 'SELECT' ) {    //On n'affiche pas de message d'erreur ni sur les CHECKBOX, ni sur les SELECT
			var erreur = (element).saisie();
			
            if(erreur !== true){
                msg.erreur({libelles:"Erreur de saisie|"+erreur});   
            }  
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
    
    case 'maj':
    
		popup.dialogue({
			  titre   :'Mise à jour',
			  msg     :'Voulez-vous mettre à jour les documents suivants ?</br>Nouveaux documents:</br>'+option.nouveaux_documents+'</br>Supprimer les documents:</br>'+option.supprimer_documents,
			  type    :'CONFIRM',
			  oui     :function(){documentsMajRAjax('maj');}  
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

ficheAjoutChargeDocument();

$().requeteAjax({
	url         : "/ajax/rAjax_multimedia_modif.php",
	parametres  : {fonction:'ajouter',document:Objdocument},
	reussie     : function(reponse){
					tableauMAJ();
					}
});

}

//***************************************************************************	
//Cette fonction met à jour le note critique du document
//
//Argument		: aucun
//
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************
function noteCritiqueRAjax(document){
			 
$().requeteAjax({
	url         : "/ajax/rAjax_multimedia_modif.php",
	parametres  : {fonction:'critique',document:Objdocument},
	reussie     : function(reponse){}
});

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
function ficheAjoutAffiche(){

//Mise à jour de la fiche
$("#ajout .image").val(Objdocument.image);
$("#ajout .image").attr("data-image-fichier",Objdocument.image);

$("#ajout .titre").val(Objdocument.titre);
$("#ajout .auteur").val(Objdocument.auteur.libelle);
$("#ajout .auteur").attr("data-id-auteur",Objdocument.auteur.id);

$("#ajout .annee").val(Objdocument.annee);
$("#ajout .supports").val(Objdocument.support.libelle);
$("#ajout .genres").val(Objdocument.genre.libelle);
$("#ajout .commentaire").val(Objdocument.commentaire);
$("#ajout .lien").val(Objdocument.lien);

//Mise à jour des SELECT support/genre
$(".liste-choix").selectmenu( "refresh" );


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

$("#ajout input").val("");

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
	
$("#Tmultimedia_wrapper").hide();
$("#menu-genre").hide();	
$("#ajout").show();

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
$("#Tmultimedia_wrapper").show();
$("#menu-genre").hide();	
$("#ajout").hide();	

}

//***************************************************************************	
//Cette affiche le menu rechercher genre.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2017A
//***************************************************************************	
function modeRechercherGenre(){
$("#Tmultimedia_wrapper").show();
$("#menu-genre").show();	
$("#ajout").hide();	

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

$("#details .note").hide();

$("#menu-context-note").hide();

ficheAjoutListeAuteursAutoComplete();

ficheAjoutTelechargerImage();

$("#details .titre h1").hide();

//Valeur par défaut du SELECT support
$(".liste-choix.supports option[value=divx]").attr({selected:'selected'});

$(".liste-choix").selectmenu({
  select: function( event, ui ) {
		var element = $(event.target);
		
		//Tri sur les colonnes du tableau
		if (element.hasClass('genres')) {	
			var table = $('#Tmultimedia').DataTable();  
				
			if (ui.item.value != 'Tous') {
				table.columns(0).search(ui.item.value).draw();
			}else{
				table.clear().draw();
			}		
		}
	}
});

}


//***************************************************************************	
//Cette fonction affiche le tableau de sélection des mouts
//
//Argument		: aucun
//
//Retour 		: aucun
//***************************************************************************	
function tableauAffiche(){
var table;
	
//Si la tableau existe déjà, on le détruit
if (  $.fn.dataTable.isDataTable( '#Tmultimedia' ) ) {
    table = $('#Tmultimedia').DataTable();
    table.destroy();
}

//Initialisation de la table liste des documents multimedia
table = $('#Tmultimedia').DataTable( {
    "paging"    	: true,
    "info"      	: true,
    "searching" 	: true,
    "ordering"		: true,
    "autoWidth"		: false,
	"language"		: {
					"decimal"		: ",",
					"thousands"		: " ",
					"lengthMenu"    : "Afficher _MENU_ documents",
					"info"			: "Montrer les documents de _START_ à _END_ sur un total de _TOTAL_ ",
					"search"        : "Rechercher:",
					"emptyTable"    : "Pas de documents trouvés",
					"paginate"		: {
										"first"		: "Premier",
										"last"		: "Dernier",
										"next"		: "Suivant",
										"previous"	: "Précédent"
									},
					"infoFiltered":   "",							
					
					},
    "columnDefs"	: [	
						{ "visible": false, "targets": [0,1] },
						{ "width": "20%", "targets": [2] },
						{ "width": "60%", "targets": [3] },
						{ "width": "10%", "targets": [4,5] }
					],	
	
    "ajax"			: {
						"url"   : "../ajax/rAjax_multimedia.php",
						"type"  : "POST",
						"data"  :{type:$("#type_multimedia").val()}
						}
 });


//Tri sur les colonnes (par auteur, par titre, par année, etc... 
$('#Tmultimedia thead tr:first th').each( function (index) {
        var title = $(this).text();
        $(this).empty().append( '<input data-num="'+(index+2)+'" type="text" placeholder="'+title+'" />' );
});
  
$("#Tmultimedia thead input").on( 'keyup', function () {
    table.columns( $(this).attr("data-num")).search( this.value ).draw();
} );

//On cache le champs de recherche principal
$("#Tmultimedia_filter").hide();

//Click sur une ligne du tableau : on affiche le détail du document multimedia    
$('#Tmultimedia tbody').on('click', 'tr', function () {
    var data = table.row(this).data();
    var document = data[1];
    
    $("#details").attr("data-num-ligne",table.row(this).index());
       
	documentDetailAffiche(document);
});

}

//***************************************************************************	
//Cette fonction affiche le detail d'un document multimedia dans la fenêtre apercu
//
//Arguments     : 
// document : le details du document multimedia
// 
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function documentDetailAffiche(document)
{
Objdocument = $.extend({},Objdocument,document);

//console.log(document.critique);

$("#details .titre h1").show();

//Mise à jour de la fenêtre de détails
$("#details .titre h1 span:first").text(Objdocument.titre);
$("#details .titre h1 span:last").text(Objdocument.annee);
$("#details .auteur h2").text(Objdocument.auteur.libelle);
$("#details .commentaire").text(Objdocument.commentaire.replace(/&amp;quot;/gi,'"'));

//Si il y a un lien, on affiche uniquement les X premiers caractères
if (Objdocument.lien != '') {
	$("#details .lien").empty().append('<i class="fas fa-link"></i> <a href="'+Objdocument.lien+'" target="_blank">Fiche allociné</a>');
}
else{
	$("#details .lien").empty();
}

//Si il y a une image, on l'affiche sinon l'image no-image.gif
if (Objdocument.image != '') {
	var image = $('#chemin_image').val()+Objdocument.image.replace(/[()]/g, '-');
				
	$("#details .jaquette").dialogueAttente();
			
	$("#details .jaquette").attr('src','<?=IMAGES_ROOT?>/no-image.gif');
		
	//Fin du chargement de l'image
	$("#details .jaquette").load(image,function(response, status, xhr) {
		
		//console.log(image);
		//console.log(status);
				
		$("#details .jaquette").dialogueAttente();	
					
		if ( status != "error" ) {	//l'image n'existe pas
			$("#details .jaquette").attr('src',$('#chemin_image').val()+Objdocument.image);
		}
				
	});

}
else {
	$("#details .jaquette").attr('src','<?=IMAGES_ROOT?>/no-image.gif');
}

	
//Note critique uniquement pour les films
if ($("#type_multimedia").val() == 'films' ) {    
	$("#details .note").show();
	noteCritiqueAffiche(Objdocument.critique);
}	

}

//***************************************************************************	
//Cette fonction affiche la note critique du film. 
//
//Argument		: aucun
//
//Retour 		: aucun
//***************************************************************************	
function noteCritiqueAffiche(){
var critique = 	$("#details .note");

critique.each(function(i){
	if($(this).data("num") <= parseInt(Objdocument.critique) ) {
		$(this).removeClass("nok");
	}else{
		$(this).addClass("nok");
	}
});

}

//***************************************************************************	
//Cette fonction met à jour la note critique. 
//
//Argument		: 
//	- note : note de 1 à 5
//
//Retour 		: aucun
//***************************************************************************	
function noteCritiqueMAJ(note){

Objdocument.critique = note;	//On met à jour la note

tableauMAJ();

noteCritiqueAffiche();

noteCritiqueRAjax();	//Mise à jour sur le serveur

return true;
}


//***************************************************************************	
//Cette fonction met à jour la colonne caché du tableau contenant le detail du document. 
//
//Argument		: aucun
//
//Retour 		: aucun
//***************************************************************************	
function tableauMAJ(){
var table = $('#Tmultimedia').DataTable();
var cellule = table.cell($('#details').attr('data-num-ligne'), 1 );
//console.log(Objdocument.critique);

cellule.data(Objdocument).draw();

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
function ficheAjoutListeAuteursAutoComplete()
{
//console.log($("#liste-auteurs").val());

$("#autocomplete-liste-auteurs").autocomplete({
	position	: { my : "right top", at: "right bottom" },
	source		: JSON.parse($("#liste-auteurs").val()),	
	select		: function( event, ui ) {

	},
	change		: function( event, ui ) {
		
		try {
			$("#ajout .auteur").attr("data-id-auteur",ui.item.id);
		} catch (e) {
			$("#ajout .auteur").attr("data-id-auteur",0);
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
							//console.log(file.url);	
							$("#ajout .image").attr("data-image-fichier",file.name);
							$("#ajout .image").val(file.name);
							$("#details .jaquette").attr('src',$('#chemin_image').val()+file.name);
							
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
