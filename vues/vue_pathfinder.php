
<header class="container-fluid">
   <img src="/images/PFS.jpg" alt="">
</header>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">WebSiteName</a>
		</div>
		
		<ul class="nav navbar-nav">
			<li class="active"><a href="#">Home</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
				<span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li><a href="#">Page 1-1</a></li>
					<li><a href="#">Page 1-2</a></li>
					<li><a href="#">Page 1-3</a></li>
				</ul>
			</li>
		<li><a href="#">Page 2</a></li>
		<li><a href="#">Page 3</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="connexion.php"><i class="fa fa-home"></i> Retour</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		</ul>

	</div>
</nav> 

<div id="entete" class="container-fluid" >
	<img src="/images/n4v0jl4h.gif" alt="Avatar">
	<h1>La magie</h1>
</div>	

<div id="pathfinder" class="row" >
	<div class="col-sm-2" ></div>	
	
	<div class="col-sm-8 " >
		<div  class="row ">	
				
			<div id="magie-lancer-sorts" class="panel panel-default">
				<div class="panel-heading" style="background-color:#f3efe2; position:relative;">

					<h1>Lancer des sorts</h1>
					<span class="imgcontainer">
					<img src="/images/getmediaobject.ashx.jpeg" alt="Avatar" class="avatar">
					</span>
					<div class="curseur panel-toggle">
						<strong><i class="fas fa-plus-square panel-toggle-bp" style="font-size:20px;"  ></i></strong>
					</div>
				</div>

				<div id="panel-body-1" class="panel-body collapse">
					
					<h2>Catégories de sorts</h2>
					
					<p>Un sort est un effet magique utilisable <mark>une seule fois</mark>. Il existe deux types de sorts : les sorts <mark>profanes</mark> et les sorts <mark>divins</mark>.</br>
					Certains lanceurs de sorts choisissent leurs sorts parmi un répertoire limité de sorts connus alors que d'autres ont accès à une large variété de sorts.</br>
					La plupart des lanceurs de sorts préparent leurs sorts à l'avance (à partir d'un grimoire ou en priant) mais certains peuvent lancer des sorts de manière spontanée, sans avoir à les préparer. Malgré ces différences dans l'apprentissage et la préparation des sorts, lorsqu'il s'agit de les lancer, tous les lanceurs de sorts pratiquent de manière similaire.
					</p>
					
					<blockquote >
					<p>Les lanceurs de sorts profanes</p>
					<ul>
						<li>les bardes</li>
						<li>les ensorceleurs</li>
						<li>les magiciens</li>
					</ul>
					</blockquote >
					
					<blockquote >
					<p>Les lanceurs de sorts divin</p>
					<ul>
						<li>les prêtres</li>
						<li>les druides</li>
						<li>les rôdeurs</li>
						<li>les paladins à partir du niveau 4</li>
					</ul>
					</blockquote >
						
					<blockquote >
						<p>Les classes suivantes doivent préparés les sorts en début de journée et ne peuvent être lancé qu'une seule fois :</p>
			  
						<ul>
							<li>druide</li>
							<li>prêtre</li>
							<li>un magicien</li>
							<li>paladin</li>
							<li>prôdeur</li>
						</ul>
					</blockquote>
						
					<blockquote >
					<p>Les classes suivantes peuvent lancer n’importe quel sort connu :</p>
 
					<ul>
						<li>bardes</li>
						<li>ensorceleurs</li>
					</ul>
					</blockquote >
					
					<blockquote >
					<p>Modificateurs</p>
					<ul>
						<li>Les <strong>druides</strong>, les <strong>prêtres</strong> et les <strong>rôdeurs</strong> ajoutent leur modificateur de <span class="label label-warning" >Sagesse</span></li>
						<li>Les <strong>bardes</strong>, les <strong>ensorceleurs</strong> et les <strong>paladins</strong> ajoutent leur modificateur de <span class="label label-primary" >Charisme</span></li>
						<li>Les <strong>magiciens</strong> ajoutent leur modificateur <span class="label label-success" >Intelligence</span></li>
					</ul>	
					</blockquote >
						
					<div class="alert alert-danger">
						<strong><i class="fas fa-exclamation-triangle" ></i></strong> Niveau max d’un sort pouvant être lancé : valeur caractéristique = <span class="badge">10</span> + niveau du sort
					</div>
					
					<h2>Echec d'un sort</h2>
					<p>Afin de ne pas perdre le sort en condition difficile, il faut réaliser un test de Concentration</p> 
					
					<div class="alert alert-success">
						<strong><i class="fas fa-dice" ></i></strong> Test de Concentration = <strong>d20</strong> + niveau de lanceur de sorts + le modificateur de caractéristique
					</div>
					
					<p>DD des tests de concentration :</p>
	
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Situation</th>
								<th>DD du test de concentration</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Incantation sur la défensive</td>
								<td><span class="badge">15</span> + niveau du sort x2</td>
							</tr>
							<tr>
								<td>Blessé pendant l’incantation</td>
								<td><span class="badge">10</span> + dégâts reçus + niveau du sort</td>
							</tr>
							<tr>
								<td>Dégâts continus pendant l’incantation</td>
								<td><span class="badge">10</span> + 1/2 dégâts reçus + niveau du sort</td>
							</tr>
							<tr>
								<td>Affecté par un sort qui ne blesse pas pendant l’incantation</td>
								<td>DD du sort + niveau du sort</td>
							</tr>
							<tr>
								<td>Agrippé ou immobilisé pendant l’incantation</td>
								<td><span class="badge">10</span> + BMO de l’adversaire</td>
							</tr>
							<tr>
								<td>Mouvement violent pendant l’incantation</td>
								<td><span class="badge">10</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Mouvement très violent pendant l’incantation</td>
								<td><span class="badge">15</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Mouvement extrêmement violent pendant l’incantation</td>
								<td><span class="badge">20</span> + niveau du sort</td>
							</tr>
							
							<tr>
								<td>Vent et pluie ou neige fondue pendant l’incantation</td>
								<td><span class="badge">5</span> + niveau du sort</td>
							</tr>
							
							<tr>
								<td>Vent et grêle ou débris pendant l’incantation</td>
								<td><span class="badge">10</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Intempérie causée par un sort</td>
								<td>voir le sort</td>
							</tr>
							
							<tr>
								<td>Enchevêtré pendant l’incantation</td>
								<td><span class="badge">15</span> + niveau du sort</td>
							</tr>
						</tbody>
				  </table>
				  
					<h2>Les contresorts</h2>
					<p>Un personnage peut utiliser n’importe quel sort comme contresort. Dans ce cas, le personnage utilise son énergie magique pour empêcher quelqu’un d’autre de se servir du même sort. Cette technique fonctionne même si un sort appartient à la magie profane et l’autre à la magie divine.</p> 
					<p>Identifié le sort (une <em>action libre</em>) : </p>
					<div class="alert alert-info">
						<strong><i class="fas fa-dice" ></i></strong> DD Test d’Art de la magie = <span class="badge">15</span> + niveau du sort adverse
					</div>
					
				</div>
			</div>	
			
			<div id="magie-sorts" class="panel panel-default">
				<div class="panel-heading" style="background-color:#f3efe2; position:relative;">

					<h1>Présentation des sorts</h1>
					<span class="imgcontainer">
					<img src="/images/carte_epee.jpeg" alt="Avatar" class="avatar">
					</span>
					<div class="panel-toggle">
						<strong><i class="fas fa-plus-square curseur panel-toggle-bp" style="font-size:20px;"  ></i></strong>
					</div>
				</div>

				<div id="panel-body-2" class="panel-body collapse">
					<h2>Exemple de sort</h2>
					<blockquote >
						<h3><span class="badge alert-success">1</span> Immobilisation de personne</h3> 
						<p><span class="badge alert-success">2</span><strong> École Enchantement</strong> <em>coercition</em>,<em>mental</em></p>
						<p><strong><span class="badge alert-success">3</span> Niveau</strong> Antip 2, Bard 2, Inq 2, Ens/Mag 3, Prê 2, Sor 2</p>
						<p><span class="badge alert-success">4</span><strong> Temps d'incantation</strong> 1 action simple</p>
						<p><span class="badge alert-success">5</span><strong> Composantes</strong> V, G, F/FD (un petit bout de fer bien droit)</p>
						<p><span class="badge alert-success">6</span><strong> Portée</strong> moyenne (30 m + 3 m/niveau) (20 c + 2 c/niveau)</p>
						<p><span class="badge alert-success">7</span><strong>Cible</strong> 1 humanoïde</p>
						<p><span class="badge alert-success">8</span><strong>Durée</strong> 1 round/niveau (T) (voir description)</p>
						<p><span class="badge alert-success">9</span><strong>Jet de sauvegarde</strong> Volonté, annule (voir description) ; Résistance à la magie oui</p>
						<p>La cible du sort se fige et se retrouve paralysée. Elle reste consciente de ce qui se passe autour d’elle et peut respirer normalement mais ne peut entreprendre aucune action, pas même parler. Chaque round, lors de son tour, elle peut effectuer un nouveau jet de sauvegarde pour tenter de mettre fin à l’effet. Il s’agit d’une action complexe qui ne provoque pas d’attaques d’opportunité. Si une créature ailée se retrouve paralysée, elle ne peut plus battre des ailes et tombe. Un nageur paralysé ne peut plus bouger et risque de se noyer.</p>
					</blockquote >
					
					<h2><span class="badge alert-success">1</span> Nom</h2>
					<p>Sous le nom du sort apparaît l’école de magie (et la branche, le cas échéant) à laquelle il appartient.</p>
					
					<h2><span class="badge alert-success">5</span>Les composantes</h2>
					<p>Les composantes sont indispensables au bon fonctionnement d’un sort. Cette ligne comprend les abréviations détaillant les composantes nécessaires au sort. Les indications concernant les composantes matérielles et les focaliseurs sont donnés à la fin du texte de description du sort. La plupart du temps, on ne se préoccupe guère des composantes, mais elles deviennent importantes lorsqu’elles sont chères ou lorsqu’elles viennent à manquer.</p>
					<ul>
						<li><strong>V (verbale)</strong>. Une composante verbale représente un texte à réciter. Le personnage doit donc s’exprimer à haute et intelligible voix. Un sort de silence ou un bâillon ne le permet pas et empêche donc l’incantation du sort. Un personnage sourd a 20 % de chances de rater ses sorts à composante verbale.</li>
						<li><strong>G (gestuelle)</strong>. Une composante gestuelle (ou somatique) prend la forme d’un geste précis de la main ou de toute autre partie du corps. Pour ce faire, il faut avoir au moins une main libre.</li>
						<li><strong>M (matérielle)</strong>. Une composante matérielle est un objet ou une substance détruit par l’énergie magique en cours d’incantation. Si son prix n’est pas indiqué, on considère qu’il est négligeable. Il n’est pas nécessaire de comptabiliser les composantes matérielles peu onéreuses. On part du principe que le personnage dispose de tout ce dont il a besoin tant qu’il a accès à sa sacoche à composantes</li>
						<li><strong>F (focaliseur)</strong>. Le focaliseur est une sorte d’accessoire. Contrairement à la composante matérielle classique, le focaliseur n’est pas détruit lors de l’incantation et peut donc être réutilisé. Là aussi, sauf indication contraire, le prix est négligeable. On part du principe que le personnage possède automatiquement tous les focaliseurs à coût modique dont il a besoin dans sa sacoche à composantes.</li>
						<li><strong>FD (focaliseur divin)</strong>. Un focaliseur divin est un objet lourd de signification religieuse. Pour les prêtres et les paladins, il s’agit d’un symbole sacré qui représente leur foi. Pour un druide ou un rôdeur, il s’agira d’une branche de houx ou d’une autre plante sacrée</li>
					</ul>
					
					<h2><span class="badge alert-success">4</span>Le temps d’incantation</h2>
					<p>La plupart des sorts ont un temps d’incantation d’une action simple. Certains exigent un round ou plus, alors que d’autres, plus rares, ne prennent qu’une action rapide.</p>
					
					<h2><span class="badge alert-success">6</span>La portée</h2>
					<p>La portée d’un sort, donnée dans sa description, indique quelle distance il peut atteindre. Il s’agit soit de la distance maximale qu’il peut affecter à partir du lanceur de sorts, soit de celle à laquelle on peut centrer son effet. Si une partie de la zone d’effet dépasse la portée maximale, le sort est sans effet sur cette partie. Les portées habituelles sont :</p>
					<ul>
						<li><strong>Personnelle</strong>. Le sort n’affecte que son lanceur.</li>
						<li><strong>Contact</strong>. Il faut toucher une créature ou un objet pour l’affecter. Un sort de contact qui inflige des dégâts peut se transformer en coup critique, comme n’importe quelle arme. Un tel sort a une chance d’asséner un coup critique sur un 20 naturel et inflige deux fois plus de dégâts en cas de confirmation.</li>
						<li><strong>Courte</strong>. Le sort peut agir à une distance maximale de 7,50 m (5 cases), plus 1,50 m (1 case) tous les deux niveaux de lanceur de sorts.</li>
						<li><strong>Moyenne</strong>. Le sort fonctionne jusqu’à 30 m (20 cases), plus 3 m (2 cases) par niveau de lanceur de sorts.</li>
						<li><strong>Longue</strong>. Le sort peut atteindre 120 m (80 cases), plus 12 m (8 cases) par niveau de lanceur de sorts.</li>
						<li><strong>Illimitée</strong>. Le sort peut prendre effet n’importe où dans le même plan que le personnage.</li>
						<li><strong>Portée exprimée en mètres</strong>. Certains sorts n’entrent dans aucune des catégories précédentes. Dans ce cas, leur portée est indiquée en mètres.</li>
					</ul>
					
					<h2><span class="badge alert-success">9</span>Les jets de sauvegarde</h2>
					<p>La plupart des sorts offensifs s’accompagnent généralement d’un jet de sauvegarde permettant à la cible d’éviter tout ou partie des effets. La ligne « Jet de sauvegarde » indique le type de jet de sauvegarde à effectuer et la manière dont il fonctionne contre le sort.</p>
					
					<ul>
						<li><strong>Annule</strong>. Le sort n’a aucun effet sur une créature qui réussit son jet de sauvegarde.</li>
						<li><strong>Partiel</strong>. Normalement, le sort a un effet donné sur la cible. Si cette dernière réussit son jet de sauvegarde, elle subit un effet moindre.</li>
						<li><strong>1/2 dégâts</strong>. Les dégâts du sort sont réduits de moitié (en arrondissant à l’entier inférieur) en cas de jet de sauvegarde réussi.</li>
						<li><strong>Aucun</strong>. Le sort n’autorise aucun jet de sauvegarde.</li>
						<li><strong>Dévoile</strong>. En cas de jet de sauvegarde réussi, la cible prend conscience qu’elle a affaire à une illusion.</li>
					</ul>
						
					<div class="alert alert-info">
						<strong><i class="fas fa-dice" ></i></strong> DD des jets de sauvegarde = <span class="badge">10</span> + niveau du sort + bonus du personnage dans la caractéristique concernée 
					</div>
					
					<div class="alert alert-danger">
						<strong><i class="fas fa-exclamation-triangle" ></i></strong> <strong> Échecs et réussites automatiques</strong>. Sur un 1 naturel le jet de sauvegarde est automatiquement raté. Sur un 20 naturel, le jet de sauvegarde est automatiquement réussi.
					</div>
					<div class="alert alert-danger">
						<strong><i class="fas fa-exclamation-triangle" ></i></strong> <strong>Échec volontaire au jet de sauvegarde</strong>. Une créature peut refuser d’effectuer un jet de sauvegarde et choisir ainsi de s’exposer aux effets d’un sort. Même un personnage doué d’une résistance à la magie particulière peut décider de la supprimer momentanément.
					</div>
				</div>
			</div>
			
			<div id="magie-sorts-profanes" class="panel panel-default">
				<div class="panel-heading" style="background-color:#f3efe2; position:relative;">

					<h1>Sorts profanes</h1>
					<span class="imgcontainer">
					<img src="/images/carte_epee.jpeg" alt="Avatar" class="avatar">
					</span>
					<div class="panel-toggle">
						<strong><i class="fas fa-plus-square curseur panel-toggle-bp" style="font-size:20px;"  ></i></strong>
					</div>
				</div>

				<div id="panel-body-2" class="panel-body collapse">
					<h2>Préparation des sorts de magicien</h2>
					<p>Un personnage qui possède une valeur de caractéristique trop basse pour lancer un sort dispose de l’emplacement correspondant mais il doit y placer un sort de niveau inférieur.</p>	
					
					<div class="alert alert-danger">
						<strong><i class="fas fa-exclamation-triangle" ></i></strong>  Pour préparer un sort, le magicien doit avoir une valeur d’<span class="label label-success" >Intelligence</span> égale à <span class="badge">10</span> + niveau du sort.
					</div>
					
					<blockquote >
					<u>Exemple:</u>	
					<p>Un magicien avec une <span class="label label-success" >Intelligence de 16</span> ne pourra préparer que des sorts de niveau <span class="badge">6</span> maximun , au niveau <span class="badge">20</span>  il pourra 16 sorts du niveau <span class="badge">6</span> (4 du niveau <span class="badge">7</span>,4 du niveau <span class="badge">8</span>,4 du niveau <span class="badge">9</span>.</p>	
					</blockquote >
					
					<h2>Ajout de sorts dans son grimoire</h2>
										
					
						<p>Pour décoder un écrit de magie profane (dans un grimoire ou sur un parchemin trouvé), il faut réussir un test d’Art de la magie.</p>
						
						<div class="alert alert-info">
							<strong><i class="fas fa-dice" ></i></strong> DD test d’Art de la magie = <span class="badge">20</span> + niveau du sort 
						</div>
						
						<p>Recopier le sort dans son grimoire ou préparer le sort (pour le lancer)</p>
						
						<div class="alert alert-info">
							<strong><i class="fas fa-dice" ></i></strong> DD test d’Art de la magie = <span class="badge">15</span> + niveau du sort (<span class="badge">+2</span> au test pour tout sort qui relève de son école de prédilection) 
						</div>
						
						<div class="alert alert-danger">
							<strong><i class="fas fa-exclamation-triangle" ></i></strong> Ce processus n’endommage pas le grimoire étudié mais si le personnage copie le sort à partir d’un parchemin, il s’efface et ne laisse qu’une surface vierge.
						</div>
						
						<ul>
							<li><strong>Temps nécessaire :</strong> La copie exige une heure par niveau de sort. Les tours de magie (les sorts de niveau 0) prennent trente minutes à recopier.</li>
							<li><strong>Espace requis :</strong> Un sort prend une page par niveau. Même un sort du niveau 0 (tour de magie) demande une page. Un grimoire comprend cent pages.</li>
							<li><strong>Coût du matériel :</strong> Le nécessaire à écrire pour écrire un nouveau sort dépend du niveau de ce dernier, comme indiqué dans la table suivante. Notez que le magicien n’a pas besoin de payer ce prix indiqué, en temps comme en heures, pour les sorts qu’il gagne en prenant un niveau.</li>
						</ul>
						
					
				</div>
			</div>
			
			
				
	</div>
	
	<div class="col-sm-2" ></div>
	
</div>	

<!--
<div class="row pathfinder">
	<div class="col-sm-2 menu-droit text-center " >
		<div  class="row ">	
			<img src="/images/n4v0jl4h.gif" alt="Avatar">
			<h1>La magie</h1>
		</div>
		
		<div  class="row ">	
				
			<ul >
			  <li><a href="#">Page 1-1</a></li>
			  <li><a href="#">Page 1-2</a></li>
			  <li><a href="#">Page 1-3</a></li>
			</ul>
		</div>
				
	</div>
	
	<div class="col-sm-8 " >
		<div  class="row ">	
				
			<div class="panel panel-default">
				<div class="panel-heading" style="background-color:#f3efe2; position:relative;">

					<h1>Lancer des sorts</h1>
					<span class="imgcontainer">
					<img src="/images/getmediaobject.ashx.jpeg" alt="Avatar" class="avatar">
					</span>

				</div>

				<div class="panel-body">
					
					<h2>Catégories de sorts</h2>
					
					<p>Un sort est un effet magique utilisable <mark>une seule fois</mark>. Il existe deux types de sorts : les sorts <mark>profanes</mark> et les sorts <mark>divins</mark>.</br>
					Certains lanceurs de sorts choisissent leurs sorts parmi un répertoire limité de sorts connus alors que d'autres ont accès à une large variété de sorts.</br>
					La plupart des lanceurs de sorts préparent leurs sorts à l'avance (à partir d'un grimoire ou en priant) mais certains peuvent lancer des sorts de manière spontanée, sans avoir à les préparer. Malgré ces différences dans l'apprentissage et la préparation des sorts, lorsqu'il s'agit de les lancer, tous les lanceurs de sorts pratiquent de manière similaire.
					</p>
					
					<blockquote >
					<p>Les lanceurs de sorts profanes</p>
					<ul>
						<li>les bardes</li>
						<li>les ensorceleurs</li>
						<li>les magiciens</li>
					</ul>
					</blockquote >
					
					<blockquote >
					<p>Les lanceurs de sorts divin</p>
					<ul>
						<li>les prêtres</li>
						<li>les druides</li>
						<li>les rôdeurs</li>
						<li>les paladins à partir du niveau 4</li>
					</ul>
					</blockquote >
						
					<blockquote >
						<p>Les classes suivantes doivent préparés les sorts en début de journée et ne peuvent être lancé qu'une seule fois :</p>
			  
						<ul>
							<li>druide</li>
							<li>prêtre</li>
							<li>un magicien</li>
							<li>paladin</li>
							<li>prôdeur</li>
						</ul>
					</blockquote>
						
					<blockquote >
					<p>Les classes suivantes peuvent lancer n’importe quel sort connu :</p>
 
					<ul>
						<li>bardes</li>
						<li>ensorceleurs</li>
					</ul>
					</blockquote >
					
					<blockquote >
					<p>Modificateurs</p>
					<ul>
						<li>Les <strong>druides</strong>, les <strong>prêtres</strong> et les <strong>rôdeurs</strong> ajoutent leur modificateur de <span class="label label-warning" >Sagesse</span></li>
						<li>Les <strong>bardes</strong>, les <strong>ensorceleurs</strong> et les <strong>paladins</strong> ajoutent leur modificateur de <span class="label label-primary" >Charisme</span></li>
						<li>Les <strong>magiciens</strong> ajoutent leur modificateur <span class="label label-success" >Intelligence</span></li>
					</ul>	
					</blockquote >
						
					<div class="alert alert-danger">
						<strong><i class="fas fa-exclamation-triangle" ></i></strong> Niveau max d’un sort pouvant être lancé : valeur caractéristique = <span class="badge">10</span> + niveau du sort
					</div>
					
					<h2>Echec d'un sort</h2>
					<p>Afin de ne pas perdre le sort en condition difficile, il faut réaliser un test de Concentration</p> 
					
					<div class="alert alert-success">
						<strong><i class="fas fa-dice" ></i></strong> Test de Concentration = <strong>d20</strong> + niveau de lanceur de sorts + le modificateur de caractéristique
					</div>
					
					<p>DD des tests de concentration :</p>
	
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Situation</th>
								<th>DD du test de concentration</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Incantation sur la défensive</td>
								<td><span class="badge">15</span> + niveau du sort x2</td>
							</tr>
							<tr>
								<td>Blessé pendant l’incantation</td>
								<td><span class="badge">10</span> + dégâts reçus + niveau du sort</td>
							</tr>
							<tr>
								<td>Dégâts continus pendant l’incantation</td>
								<td><span class="badge">10</span> + 1/2 dégâts reçus + niveau du sort</td>
							</tr>
							<tr>
								<td>Affecté par un sort qui ne blesse pas pendant l’incantation</td>
								<td>DD du sort + niveau du sort</td>
							</tr>
							<tr>
								<td>Agrippé ou immobilisé pendant l’incantation</td>
								<td><span class="badge">10</span> + BMO de l’adversaire</td>
							</tr>
							<tr>
								<td>Mouvement violent pendant l’incantation</td>
								<td><span class="badge">10</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Mouvement très violent pendant l’incantation</td>
								<td><span class="badge">15</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Mouvement extrêmement violent pendant l’incantation</td>
								<td><span class="badge">20</span> + niveau du sort</td>
							</tr>
							
							<tr>
								<td>Vent et pluie ou neige fondue pendant l’incantation</td>
								<td><span class="badge">5</span> + niveau du sort</td>
							</tr>
							
							<tr>
								<td>Vent et grêle ou débris pendant l’incantation</td>
								<td><span class="badge">10</span> + niveau du sort</td>
							</tr>
							<tr>
								<td>Intempérie causée par un sort</td>
								<td>voir le sort</td>
							</tr>
							
							<tr>
								<td>Enchevêtré pendant l’incantation</td>
								<td><span class="badge">15</span> + niveau du sort</td>
							</tr>
						</tbody>
				  </table>
				  
					<h2>Les contresorts</h2>
					<p>Un personnage peut utiliser n’importe quel sort comme contresort. Dans ce cas, le personnage utilise son énergie magique pour empêcher quelqu’un d’autre de se servir du même sort. Cette technique fonctionne même si un sort appartient à la magie profane et l’autre à la magie divine.</p> 
					<p>Identifié le sort (une <em>action libre</em>) : </p>
					<div class="alert alert-info">
						<strong><i class="fas fa-dice" ></i></strong> DD Test d’Art de la magie = <span class="badge">15</span> + niveau du sort adverse
					</div>
					
				</div>
			</div>	
			
			<div class="panel panel-default">
				<div class="panel-heading" style="background-color:#f3efe2; position:relative;">

					<h1>Lancer des sorts</h1>
					<span class="imgcontainer">
					<img src="/images/carte_epee.jpeg" alt="Avatar" class="avatar">
					</span>

				</div>

				<div class="panel-body">

					<p>Il existe deux types de sorts :</p>
					<ul>
						<li>les sorts profanes (lancés par les bardes, les ensorceleurs et les magiciens)</li>
						<li>les sorts divins (lancés par les prêtres et les druides ainsi que par les rôdeurs et paladins expérimentés)</li>
					</ul>
					
				  
					
				</div>
			</div>	
			
	</div>

	<div class="col-sm-2 " ></div>
	
</div>

	
