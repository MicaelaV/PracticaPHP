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
					elseif ($_GET['error'] == "invalidmailusername") {
						echo '<p class="error"> El mail e usuario son incorrectos</p>'; 
					}
					else if ($_GET['error'] == "invalidusername") {
						echo '<p class="error"> Por favor no use caracteres fuera del abecedario o numeros</p>';
					}
					elseif ($_GET['error'] == "invalidmail") {
						echo '<p class="error"> El mail no es valido</p>';
					}					
					else if ($_GET['error'] == "passwordcheck") {
						echo '<p class="error"> Las contraseñas no coinciden</p>';
					}					
					else if ($_GET['error'] == "usernametaken") {
						echo '<p class="error"> El usuario ya esta en uso</p>';				
					}
				}
				else if (isset($_GET['signup'])) {
					if ($_GET['signup'] == "success") {
					echo '<p class="success"> Usuario creado!</p>';
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