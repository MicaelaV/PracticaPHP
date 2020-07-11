<?php
	if (isset($_POST['newPasswordButton'])) {
		
		$selector = $_POST["selector"];
		$validator = $_POST["validator"];
		$password = $_POST["password"];
		$passwordRepeat = $_POST["passwordRepeat"];

		if (empty($password) || empty($passwordRepeat)) {
			header("Location: ../createnewpwd.php?error=emptypassword&selector=".$selector."&validator=".$validator);
			exit();
		} else if ($password != $passwordRepeat) {
			header("Location: ../createnewpwd.php?error=passwordcheck&selector=".$selector."&validator=".$validator);
			exit();
		}

		$dateNow = date("U");
		require 'conexion.php';
		$consulta = "SELECT * FROM resetpassword WHERE passwordResetSelector =? AND passwordResetExpires >=?;"; //Podria usar directamente la variable $dateNow ya que es una variable creada por mi, no usada x el usuario
		$represent = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($represent,$consulta)) {
			echo "Error1";
			exit();
		}
		else{
			mysqli_stmt_bind_param($represent,"ss",$selector,$dateNow);
			mysqli_stmt_execute($represent);
			$resultado = mysqli_stmt_get_result($represent);
			if (!$row = mysqli_fetch_assoc($resultado)) {
				echo "Se ha vencido el tiempo permitido";
				exit();	
			}	
			else {
				//Covertir token hexa a binario
				$tokenBin = hex2bin($validator);
				$tokenCheck = password_verify($tokenBin, $row["passwordResetToken"]);
				if ($tokenCheck === false) {
					echo "Error3";
					exit();
				}
				else if ($tokenCheck === true) {

					$tokenEmail = $row["passwordResetEmail"];

					$consulta = "SELECT * FROM usuarios WHERE mail =?;";
					$represent = mysqli_stmt_init($con);
					if (!mysqli_stmt_prepare($represent,$consulta)) {
						echo "Error4";
						exit();
					}
					else{
						mysqli_stmt_bind_param($represent,"s",$tokenEmail);
						mysqli_stmt_execute($represent);
						$resultado = mysqli_stmt_get_result($represent);
						if (!$row = mysqli_fetch_assoc($resultado)) {
							echo "Error5";
							exit();	
						}	
						else {
							$consulta ="UPDATE usuarios SET password=? WHERE mail=?;";
							$represent = mysqli_stmt_init($con);
							if (!mysqli_stmt_prepare($represent,$consulta)) {
								echo "Error6";
								exit();
							}
							else{
								$newPassword = password_hash($password, PASSWORD_DEFAULT);
								mysqli_stmt_bind_param($represent,"ss",$newPassword,$tokenEmail);
								mysqli_stmt_execute($represent);

								$consulta ="DELETE FROM resetpassword WHERE passwordResetEmail =? ;";
								$represent = mysqli_stmt_init($con);
								if (!mysqli_stmt_prepare($represent,$consulta)) {
									echo "Error7";
									exit();
								}
								else{
									mysqli_stmt_bind_param($represent,"s",$tokenEmail);
									mysqli_stmt_execute($represent);
									mysqli_stmt_store_result($represent);
									header("Location: ../signup.php?signup=resetpwd");
									exit();	
								}							
							}								
						}						
					}									
				}
				else {
					echo "Error8";
					exit();					
				}
			}			
		}
		mysqli_stmt_close($represent); //Cierra una sentencia preparada
		mysqli_close($con);			
	}
	else {
		//Si el usuario accedio sin hacer click en el buttom
		header("Location: ../index.php");
		exit();
	}	
?>