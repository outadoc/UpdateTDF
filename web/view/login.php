<?php
	/**
	 * Fichier vue pour la connexion de l'utilisateur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	/** @var $username string */

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>Connexion</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-4 login-form">
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="login.php" method="post">
					<?php

						echo FormUtils::getTextField("username", "Nom d'utilisateur", $username, "", true, 50, "admin");
						echo FormUtils::getTextField("password", "Mot de passe", "", "", true, 50, "•••••••••••••••", null, true);

					?>
					<input type="submit" class="btn btn-form btn-primary" value="Connexion">
				</form>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript">

	$("input[name=username]").focus();

	$(".delete").click(function () {
		return confirm('Voulez-vous vraiment supprimer ce coureur ?');
	});

</script>