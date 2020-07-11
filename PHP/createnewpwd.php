<?php 
	require "header.php";
	//phpinfo(); //Para saber que version uso
?>
<main>
	<div>
		<section>
			<?php
				$selector = $_GET['selector'];
				$validator = $_GET['validator'];
				if (isset($_GET["error"])) {
					if ($_GET["error"] == "emptypassword") {
						echo "<p>Por favor ingrese lo pedido</p>";
					}
					else if ($_GET["error"] == "passwordcheck") {
						echo "<p>Las contraseñas no coinciden</p>";
					}
				}

				if(empty($selector) || empty($validator)){
					echo "<p>No se pudo validar su solicitud</p>";
				} else {
					//Chequear posibles caracteres que representen un dígito hexadecimal
					if (ctype_xdigit($selector) !== false && ctype_xdigit($validator)) {
						//Validar si es hexadecimal
						?>
						<form action="includes/inc-submitpwd.php" method="POST">
							<input type="text" name="selector" value="<?php echo $selector ?>">
							<input type="text" name="validator" value="<?php echo $validator ?>">
							<input type="password" name="password" placeholder="Password">
							<input type="password" name="passwordRepeat" placeholder="Repeat Password">
							<button type="submit" name="newPasswordButton">Nueva contraseña</button>
						</form>
						<?php
					}
				}
			?>
		</section>
	</div>
</main>
<?php
	require "footer.php";
?>