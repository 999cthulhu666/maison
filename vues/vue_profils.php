
<div class="jumbotron2 container-fluid text-right" >
   <h1>Gestion de votre profils</h1>
</div> 

<section class="row">
    <div class="col-sm-2">
    </div>
   <div class="col-sm-6 text-left fond ">
       <h1 id="motDePasseTitre" data-toggle="collapse" data-target="#motDePasse">Changement du mot de passe</h1>
       <form id="utilisateur">
            <div id="motDePasse" class="collapse">
                 <div class="input-group">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                   <input  id="nouveauMotPasse" type="password" class="form-control" name="utilisateur[mdp][nouveau1]" placeholder="Nouveau mot de passe"  >
                 </div>
                <div class="input-group">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                   <input id="confNouveauMotPasse" type="password" class="form-control" name="utilisateur[mdp][nouveau2]" placeholder="Confirmer le nouveau mot de passe" >
                 </div>
                <button id="bpChangementMpd" > Mettre à jour</button>
                <input type="hidden" value="<?= $id ?>"  name="utilisateur[id]"/>
            </div>
       </form>   
   </div>
   <div class="col-sm-4"></div>
 </section>

<section class="row">
   <div class="col-sm-2"></div>
   <div class="col-sm-6 text-left">
       <h1 id="detailsProfilsTitre" data-toggle="collapse" data-target="#detailsProfils">Détail du profil</h1>
       <div id="detailsProfils" class="collapse ">
           <table id="profils" class="table">
               <tr>
                   <td>ID</td>
                   <td><?= $id ?></td>

               </tr>
                <tr>
                   <td>Nom complet</td>
                   <td><?= $nom ?></td>

               </tr>
               <tr>
                   <td>Identifiant</td>
                   <td><?= $identifiant ?></td>

               </tr>

               <tr>
                   <td>Groupe</td>
                   <td><?= $groupe ?></td>

               </tr>
           </table>
       </div> 
   </div>
   <div class="col-sm-4"></div>
 </section>