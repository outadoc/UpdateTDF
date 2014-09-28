<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">Mise à jour TDF</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Parcourir <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="./">Coureurs</a></li>
						<li><a href="liste-epreuves.php">Épreuves</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ajouter <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="form-coureur.php">Coureur</a></li>
						<li><a href="form-directeur.php">Directeur</a></li>
						<li role="presentation" class="divider"></li>
						<li><a href="form-annee.php">Année</a></li>
						<li><a href="form-pays.php">Pays</a></li>
						<li role="presentation" class="divider"></li>
						<li><a href="form-epreuve.php">Épreuve</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php

					if (isset($_SESSION["logged_in"])) {
						echo '<li><a href="logout.php">Déconnexion</a></li>';
					}

				?>
			</ul>
		</div>
	</div>
</nav>