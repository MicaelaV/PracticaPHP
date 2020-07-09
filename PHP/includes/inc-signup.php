<?php
//si existe un evento en el buttom nuevaCuenta
	if (isset($_POST['nuevaCuenta'])) {

		require 'conexion.php';

		//Obtener la informacion del Usuarion cuando se registre
		$username = $_POST['username'];
		$mail = $_POST['mail'];
		$password = $_POST['password'];
		$passwordRepeat = $_POST['passwordRepeat'];

		//Verificar que no falten campos
		if (empty($username) || empty($mail) || empty($password) || empty($passwordRepeat)) {
			//Devuelvo un codico para error = emptyfuelds a la misma pagina donde estaba
			header("Location: ../signup.php?error?=emptyfields&username=".$username."&email=".$mail);
			exit();//no continuar ningun codigo despues de aqui
		} else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-z0-9]*$/",$username) ) {
			header("Location: ../signup.php?error?=invalidmailusername");
			exit();

		} else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			//Validar que el email e usuario sea valido
			header("Location: ../signup.php?error?=invalidmail&username=".$username);
			exit();

		} else if (!preg_match("/^[a-zA-z0-9]*$/",$username)) {
			//Validar Usuario sea con caracteres apropiados
			header("Location: ../signup.php?error?=invalidusername&mail=".$mail);
			exit();

		} else if ($password !== $passwordRepeat) {
			header("Location: ../signup.php?error?=passwordcheck&username=".$username."&mail=".$mail);
			exit();

		} 
		else {
			//Verificar si todo esta creado en la base e insertar en la base
			//Consulta a la base
			$consulta = "SELECT usuario FROM usuarios WHERE usuario=?"; //declaraciones preparadas es para que no puedan dañar la base
			//Conexion (por eso usamos require al inicio)
			$represent = mysqli_stmt_init($con); //Representante de las declaraciones. mysqli_stmt_init(); inicializa una declaración y devuelve un objeto adecuado para mysqli_stmt_prepare (). $con proviene del archivo conexion.php

			if (!mysqli_stmt_prepare($represent,$consulta)) {
				//Verifico si fallo mysqli_stmt_prepare(). mysqli_stmt_prepare() Preparar una sentencia SQL para su ejecución
				header("Location: ../signup.php?error=sqlerror");
				exit();				
			} 
			else {
				mysqli_stmt_bind_param($represent,"s",$username);//Agrega variables a una sentencia preparada como parámetros,consulta, tipo de variable(string,boolean,integer) y la variable que "iria" en el punteo (simbolizado con ?)
				mysqli_stmt_execute($represent); //Ejecuta una consulta preparada
				mysqli_stmt_store_result($represent);//Transfiere un conjunto de resultados desde una sentencia preparada
				$resultados = mysqli_stmt_num_rows($represent); //Cuantas rows hay q cumplan la sentencia
				if ($resultados > 0) {
					//Si existe algun usuario con ese nombre
					header("Location: ../signup.php?error=usernametaken&mail =".$email);
					exit();
				} 
				else {
					$insertar = "INSERT INTO usuarios (usuario, mail, password) VALUES (?,?,?)";
					$represent = mysqli_stmt_init($con);

					if (!mysqli_stmt_prepare($represent, $insertar)) {
						header("Location: ../signup.php?error=sqlerror");
						exit();
					}
					else {
						$encriptado = password_hash($password, PASSWORD_DEFAULT); //Mas recomendable que usar MD5

						mysqli_stmt_bind_param($represent,"sss",$username,$mail,$encriptado);
						mysqli_stmt_execute($represent);
						mysqli_stmt_store_result($represent);
						exit();
					}
				}
			}
		}
		mysqli_stmt_close($represent); //Cierra una sentencia preparada
		mysqli_close($con);

	}
	else {
		//Si el usuario accedio sin hacer click en el buttom nuevaCuenta
		header("Location: ../signup.php");
		exit();
	}

?>