<!-- Fenetre de login -->
<div id="fen_login_old" class="panel panel-default text-left" style="display: none;">
    <div class="panel-heading text-center">
            <h1>Identification</h1>
    </div>
    <div class="panel-body">
        <div class="form-group">
        <label for="identifiant"><span class="glyphicon glyphicon-user"></span> Utilisateur</label>
        <input id="identifiant" type="text" class="form-control" placeholder="Utilisateur">
        </div>
        <div class="form-group">
        <label for="mdp"><span class="glyphicon glyphicon-eye-open"></span> Mot de passe</label>
        <input id="mdp" type="text" class="form-control"  placeholder="Mot de passe">
        </div>
        <button id="btnValideAcces" class="btn-block"> Valider</button>

    </div> 
</div>

<!-- Fenetre de login -->
<div id="fen_login_petite" class="jumbotron text-center fen_cache" style="display: none;">
    <form class="form-inline text-right" >
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="email" type="text" class="form-control" name="email" placeholder="Email">
            <div class="input-group-btn">
              <button id="log_maint" data-log="maintenance" type="button" class="btn">Maint</button>
              <button id="log_prod" data-log="production" type="button" class="btn btn-danger">Prod</button>
              <button id="log_admin" data-log="administrateur" class="btn btn-danger">Admin</button>
            </div>
        </div>
  </form>
</div>

<div id="fen_login" class="panel panel-default text-left fen_cache" style="display: none;">
    <div class="panel-heading text-center">
            <h1>Identification</h1>
    </div>
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="mot_de_passe" type="text" class="form-control" name="mdp" placeholder="Mot de passe">
            <div class="input-group-btn">
              <button id="log_maint" data-log="maintenance" type="button" class="btn btn-danger">Maintenance</button>
              <button id="log_prod" data-log="production" type="button" class="btn btn-danger">Production</button>
              <button id="log_admin" data-log="administrateur" class="btn btn-danger">Administrateur</button>
            </div>
        </div>

    </div> 
</div>