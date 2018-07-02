
<div id="entete" class="row">
	<div class="col-sm-3" ></div>
	<div class="col-sm-3" ><img  src="<?= IMAGES_ROOT ?>"/></div>
	<div class="col-sm-6" >
		<table class="table stat">
			<?php foreach($stat as $key => $value): ?>
			<tr>
				<td><?=$key?></td>
				<td><?=$value?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>

<div class="row">
  <div class="col-sm-3"></div>
  <div id="page" class="col-sm-8" >
		<!-- class="display table  table-hover table-condensed" -->
		<table id="Tmultimedia"  class="table table-striped table-hover">
			<thead>
				<tr><th>Genre</th><th>Donnees</th><th >Auteur</th><th>Titre</th><th>Année</th><th>Support</th></tr>
			</thead> 
			<tbody></tbody>
		</table>
	
		<div id="ajout"  >
			<table>
				<tr>
					<td><input class="image" type="text" data-image-fichier="" readonly="readonly" title="Veuillez joindre une image" placeholder="Image" ></td>
				</tr>
				
				<tr>
					<td><input class="titre" type="text" data-saisie="chaine" data-saisie-min="3" title="Veuillez saisir un libellé" placeholder="Titre"></td>
				</tr>
				
				<tr>	
					<td><input id="autocomplete-liste-auteurs" class="auteur" type="text"  data-id-auteur="0" data-saisie="chaine" data-saisie-min="3" title="Veuillez saisir un libellé" placeholder="Auteur"></td>
				</tr>
				
				<tr>	
					<td><input class="annee"  type="text" data-saisie="nombre" title="Veuillez saisir une année" placeholder="Année"></td>
				</tr>

				<tr>	
					<td>
						<select class="liste-choix supports" >
							<?php foreach($liste_support as $support): ?>
							<option data-id="<?=$support['id'] ?>" value="<?=$support['libelle']?>"><?=$support['libelle']?></option>
							<?php endforeach; ?>
						</select> 
					</td>
				</tr>
				
				<tr>	
					<td>
						<select class="liste-choix genres">
							<?php foreach($liste_genre as $genre): ?>
							<option data-id="<?=$genre['id'] ?>" value="<?=$genre['libelle']?>"><?=$genre['libelle']?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				
				<tr>	
					<td><input class="commentaire" type="text" title="Veuillez saisir un commentaire" placeholder="Commentaire"></td>
				</tr>
				
				<tr>	
					<td><input class="lien" type="text" title="Veuillez saisir un lien http" placeholder="Lien"></td>
				</tr>
				
				<tr>	
					<td><button type="button" id="bp-enregistrer" class="btn btn-primary btn-md glyphicon glyphicon-floppy-save"> Enregistrer</button></td>
				</tr>
				
				
			</table>
			
			<!-- The fileinput-button span is used to style the file input field as button  -->
			<div class="photo">
				<input id="fileupload" type="file" name="files[]" multiple>
			</div>
		</div>
		
  </div>
  <div class="col-sm-1"></div>
</div>

<div id="details" data-num-ligne="">
		<div class="photo"><img class="jaquette" height="300px" width="200px" src="<?=IMAGES_ROOT?>/no-image.gif"/></div>
		
		<div class="liste-notes curseur" data-note="0">
			<img class="note" title="Cool" 				data-num="1" src="<?=IMAGES_ROOT?>/box-of-popcorn.jpg"/>
			<img class="note" title="Trop cool" 		data-num="2" src="<?=IMAGES_ROOT?>/box-of-popcorn.jpg"/>
			<img class="note" title="Génial" 			data-num="3" class="nok"src="<?=IMAGES_ROOT?>/box-of-popcorn.jpg"/>
			<img class="note" title="Ca déchire" 		data-num="4" class="nok"src="<?=IMAGES_ROOT?>/box-of-popcorn.jpg"/>
			<img class="note" title="Ca déchire grave" 	data-num="5" class="nok"src="<?=IMAGES_ROOT?>/box-of-popcorn.jpg"/>
		</div>
		
		<div class="row">
			  <div class="col-sm-12 titre"><h1><span></span> - <span></span></h1></div>
		</div> 
		<div class="row">
			  <div class="col-sm-12 auteur"><h2></h2></div>
		</div>
		<div class="row">
			  <div class="col-sm-12 commentaire"></div>
		</div>
		<div class="row">
			  <div class="col-sm-12 lien"></div>
		</div>
			
		<img class="modifier" src="<?=IMAGES_ROOT?>/icone_modifier_48.png"/>
	</div>

<div id="menu-droite">
	<div  class="icon-bar">
	  <a href="connexion.php"><i class="fa fa-home"></i></a>
	  <a class="recherche-genre"><i class="fa fa-search"></i></a>
	  <a class="ajouter"><i class="fa fa-plus"></i></a>
	  <a class="liste"><i class="fa fa-list-ul"></i></a>
	  <a class="maj"><i class="far fa-arrow-alt-circle-down"></i></a>
	</div>
</div>

<div id="menu-genre">
	<select class="liste-choix genres">
		<option data-id ="0" value="Tous">Tous</option>
		<?php foreach($liste_genre as $genre): ?>
		<option data-id="<?=$genre['id'] ?>" value="<?=$genre['libelle']?>"><?=$genre['libelle']?></option>
		<?php endforeach; ?>
	</select>
</div> 

<input id="chemin_image" type="hidden" value="<?= $chemin_image ?>"/>
<input id="type_multimedia" type="hidden" value="<?= $type_multimedia ?>"/>
<input id="liste-auteurs" type="hidden" value='<?= json_encode($liste_auteurs) ?>'/>

