<!-- Fenetre de dialogue standard-->
<div id="fen_popup" class="modal fade" role="dialog" style="z-index:2000;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Titre</h4>
      </div>
      <div class="modal-body">
        <p>Texte</p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
 </div> 

<!-- Fenetre de dialogue d'erreur-->
<div id="msg-erreur"></div>

<!-- Fenetre de d'attente AJAX-->
<div id="msg-ajax" style="display:none"></div>

<!-- Fenetre de dialogue changement de valeur-->
<div id="fen_chgt_valeur" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Changement de valeur</h4>
      </div>
      <div class="modal-body">
			<div class="input-group">
			<span class="input-group-addon">Ancienne valeur</span>
			<input id="ancienne" type="text" class="form-control" name="ancienne" placeholder="Valeur">
			</div>
			<div class="input-group" style="margin-top:10px;">
			<span class="input-group-addon">Nouvelle valeur&nbsp;</span>
			<input id="nouvelle" type="text" class="form-control" name="nouvelle" placeholder="Saisir une nouvelle valeur">
			</div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
 </div> 

<!-- Fenetre de dialogue modification d'un ingredient-->
<div id="fen_modif_ingredient" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Changement de valeur</h4>
      </div>
      <div class="modal-body text-center">
  
			 <form class="form-inline " >
			  <div class="form-group">
				<input type="text" style="width:350px;" class="libelle form-control" name="libelle" data-id="">
			  </div>

			  <div class="form-group">
				<input type="text" style="width:100px;" class="quantite form-control" name="quantite">
			  </div>
			  
			  <div class="form-group">
				<input type="text" style="width:100px;" class="unite form-control" name="unite">
			  </div>
				
			</form> 
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
 </div> 
