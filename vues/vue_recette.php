
<div id="entete" class="row">
	<div class="col-sm-3" ></div>
	<div class="col-sm-3" ></div>
	<div class="col-sm-6" ></div>
</div>

<div id="recette" class="row" data-recette="">
	<div id="page-gauche" class="col-sm-3">
		<span class="imgcontainer">
			<img src="" alt="Avatar" class="avatar">
		</span>
	</div>
	<div id="page" class="col-sm-8" >
		<h1 class="modifiable" data-entete=""></h1>
		
		<table id="edition-liste-ingredient" class="table table-striped edition" style="width:40%;">
			<thead><tr><th>Ajouter un ingrédient :</th></tr></thead>
			<tbody>
				<tr class="warning">
					<td style="width:55%;"><input type="text" class="form-control libelle" name="ingredient" data-id="" ></td>
					<td style="width:20%;"><input type="text" class="form-control qte" ></td>
					<td style="width:20%;"><input type="text" class="form-control unite" name="unite" ></td>
					<td style="width:5%;"><div class="bouton ajouter-ingredient curseur"> <i class="fas fa-plus-square"></i></div></td>
				</tr> 
			</tbody>
		</table>
		
		<table class="liste-ingredient table" style="width:40%;margin-bottom:100px;">
			<thead></thead>
			<tfoot></tfoot>
			<tbody></tbody>
		</table>
			
		<div id="edition-liste-pas" class="form-group edition">
			<label for="comment">Ajouter un pas :</label>
			<textarea class="form-control libelle" rows="2" ></textarea>
			<div class="bouton ajouter-pas curseur"><i class="fas fa-plus-square bouton" ></i></div>
		</div> 

		<table class="liste-pas table table-striped">
			<thead></thead>
			<tfoot></tfoot>
			<tbody></tbody>
		</table>
								
	</div>
	<div class="col-sm-1"></div>
</div>


<div id="menu-droite">
	<div  class="icon-bar">
	  <a href="connexion.php"><i class="fa fa-home"></i></a>
	  <div class="recherche-genre"><a><i class="fa fa-search"></i></a></div>
	  <div class="enregistrer"><a><i class="far fa-save"></i></a></div>
	  <div class="ajouter"><a><i class="fas fa-book"></i></a></div>
	  <div class="modifier"><a><i class="fas fa-edit"></i></a></div>
	    <div class="liste"><a><i class="fa fa-list-ul"></i></a></div>
	  <div class="multi-ingredient" data-multi="1"><a>X1</a></div>
	  <div class="multi-ingredient" data-multi="2"><a>X2</a></div>
	  <div class="multi-ingredient" data-multi="3"><a>X3</a></div>
	  <div class="multi-ingredient" data-multi="4"><a>X4</a></div>
	  
	</div>
</div>

<div id="menu-genre">
	<select class="liste-choix categories">
		<option value="Tous">Tous</option>
		<?php foreach($liste_categorie as $categorie): ?>
		<option value="<?=$categorie->id();?>"><?=$categorie->libelle();?></option>
		<?php endforeach; ?>
	</select>
	<select class="liste-choix recette">
		<option value="Tous">Tous</option>
		<?php foreach($liste_recette as $recette): ?>
		<option value="<?=$recette->entete()->id();?>"><?=$recette->entete()->libelle();?></option>
		<?php endforeach; ?>
	</select>
	</select>
</div> 

<input id="liste-ingredient" type="hidden" value='<?= json_encode($liste_ingredient); ?>'/>
<input id="liste-unite" type="hidden" value='<?= json_encode($liste_unite) ?>'/>
