<?php

if (isset($_POST['buttonLogin'])) {
	require 'conexion.php';

	$mailUser = $_POST['mailUser'];
	$password = $_POST['password'];


	//Validamos campos vacios
	if (empty($mailUser) || empty($password)) {
		header("Location: ../index.php?error=emptyfields");
		exit();
	}
	else {
		//Cosulta a la base
		$consulta = "SELECT * FROM usuarios WHERE usuario=? OR mail=?;";
		$represent = mysqli_stmt_init($con);
		
		if (!mysqli_stmt_prepare($represent,$consulta)) {
			header("Location: ../index.php?error=sqlerror");
			exit();			
		}
		else {
			mysqli_stmt_bind_param($represent,"ss",$mailUser,$password);
			mysqli_stmt_execute($represent);
			$resultado = mysqli_stmt_get_result($represent); //Obtiene un conjunto de resultados de una sentencia preparada
			if ($row = mysqli_fetch_assoc($resultado)) {
				//mysqli_fetch_assoc Obtener una fila de resultado como un array asociativo
				$passwordCheck = password_verify($password, $row['password']);//Primero password que ingresa user, segundo password que se trae de la base. password_verify Comprueba que la contraseña coincida con un hash
				echo $passwordCheck;
				if ($passwordCheck == false) {
					//Si la password es incorrecta
					header("Location: ../index.php?error=notexistuser");
					exit();	
				}
				else if ($passwordCheck == true) {
					session_start();
					$_SESSION['idUsuario'] = $row['idUsuario'];
					$_SESSION['username'] = $row['username'];
					header("Location: ../index.php?login=success");
					exit();					
				}
				else{
					//por si $passwordCheck no es true o false				
					header("Location: ../index.php?error=wrongpassword");
					exit();					
				}
			}	
			else {
				header("Location: ../index.php?error=notexistuser");
				exit();					
			}
		}
	}
}
else {
	header("Location: ../index.php");
	exit();
}
?>