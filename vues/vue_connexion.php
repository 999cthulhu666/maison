
<div class="row" style="position:relative; top:100px">
		 <div class="col-lg-4"></div>
		 
		 <div id="connexion" class="col-lg-4">
			 <form >
			  <div class="imgcontainer">
				<img src="/images/avatar_films.jpg" alt="Avatar" class="avatar">
			  </div>

			  <div class="container-fluid">
				<label for="uname"><b>Identifiant</b></label>
				<input id="utilisateur" type="text" placeholder="Entrer votre identifiant" name="uname" required value="virgilew">

				<label for="psw"><b>Mot de passe</b></label>
				<input id="mdp" type="password" placeholder="Entrer votre mot de passe" name="psw" required value="virgile2108">

				<button id="bp-connexion" class="glyphicon glyphicon-log-in" > Accès</button>
				
			  </div>

			  <div class="container-fluid" style="background-color:#f1f1f1; height:50px;">
				<span  style="position:relative; top:10px;">
					<select id="sites" class="liste-choix sites" >
						<option value="multimedia" data-site="films" data-avatar-img="/images/avatar_films.jpg">Catalogue films</option>
						<option value="recette" data-avatar-img="/images/avatar_films.jpg" 					>Recettes</option>
						<option value="cave" data-avatar-img="/images/avatar_films.jpg" 						>Cave à vins</option>
						<option value="multimedia" data-site="musiques" data-avatar-img="/images/avatar_musique.jpeg">Musiques</option>
						<option value="pathfinder" data-avatar-img="/images/avatar_pathfinder.jpg">Aide pathfinder</option>
					</select>
				</span>
				<span class="psw"><a href="#">Mot de passe oublié ?</a></span>
			  </div>
			</form> 
		</div>
		 <div class="col-lg-4"></div>
</div>
