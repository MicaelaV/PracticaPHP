<?php 
	require "header.php";
	//phpinfo(); //Para saber que version uso
?>
<main>
	<div>
		<section>
			<h1>Recuperar contraseña</h1>
			<?php
				if (isset($_GET['reset'])) {
					if ($_GET['reset'] == "success") {
					echo '<p class="success">Se ha enviado el mail</p>';
					}				
				}
				if (isset($_GET['error'])) {
					if ($_GET['error'] == "empty") {
					echo '<p class="error">Por favor ingrese un Email</p>';
					}				
				}
			?>			
			<form action="includes/inc-resetpwd.php" method="POST">
				<input type="text" name="mail" placeholder="Ingrese su Email...">
				<button type="submit" name="resetpwdbuttom">Aceptar</button>
			</form>

		</section>
	</div>
</main>
<?php
	require "footer.php";
?>