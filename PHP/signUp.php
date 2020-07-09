<?php 
	require "header.php";
	//phpinfo(); //Para saber que version uso
?>
<main>
	<div>
		<section>
			<h1>Crear Cuenta</h1>
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == "emptyfields") {
						echo '<p class="error"> Faltan completar campos</p>';
					} 
					else if ($_GET['error'] == "invalidmailusername") {
						echo '<p class="error"> Por favor no use caracteres fuera del abecedario</p>';
					}
				}
			?>
			<form class="formSignUp" action="includes/inc-signup.php" method="POST">
				<input type="text" name="username" value="" placeholder="Username">
				<input type="text" name="mail" value="" placeholder="E-mail">
				<input type="password" name="password" value="" placeholder="Password">
				<input type="password" name="passwordRepeat" value="" placeholder="Repetir Password">
				<button type="submit" name="nuevaCuenta">Crear</button>												
			</form>
		</section>
	</div>
</main>
<?php
	require "footer.php";
?>