<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title></title>
	</head>
	<body>
		<header>
			<nav class="menuPrincipal">
				<!-- <a href="#" class="logo"><img src="img/logo.png" alt="logo"></a> -->
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="#">Portafolio</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
					<div>
						<?php if (isset($_SESSION['idUsuario'])) {
								echo '
								<form action="includes/inc-logout.php" method="POST">
									<button type="submit" name="buttonLogOut">Salir</button>		
								</form>
								';
						 } 
						 else { 
						 		echo '
								<form action="includes/inc-login.php" method="POST">
									<input type="text" name="mailUser" value="" placeholder="Username">
									<input type="password" name="password" value="" placeholder="Password">
									<button type="submit" name="buttonLogin">Ingresar</button>		
								</form>
								<a href="signup.php">Crear Cuenta</a>
						 		';	
						}?>						
					</div>
			</nav>
		</header>

