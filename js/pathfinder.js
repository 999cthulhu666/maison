//***************************************************************************	
//Cette fonction est excecuté à la fin du chargement de la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2018A
//***************************************************************************	
function main(){

gestionnaireEvenements();   //Gestion des evenements de la page

//initialisationPage();

$(".collapse").on('show.bs.collapse', function(){
	console.log($(this).prev());
	$(this).prev().find('.panel-toggle-bp').removeClass('fas fa-plus-square').addClass('fas fa-minus-square');
});

$(".collapse").on('hide.bs.collapse', function(){
	console.log($(this).prev());
	$(this).prev().find('.panel-toggle-bp').removeClass('fas fa-minus-square').addClass('fas fa-plus-square');
});       

$(".panel-toggle").click(function(){
	$(this).parent().next().collapse('toggle');
});
    
}


//***************************************************************************	
//Cette fonction centralise tous les evements de la page.
//
//Argument		: aucun
//
//Retour 		: aucun
//
//Version 		: V2018A
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
           
    }
});
	
}

