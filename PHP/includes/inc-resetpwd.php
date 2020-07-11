<?php
	if (isset($_POST['resetpwdbuttom'])) {
		
		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);

		$url = "http://localhost/PruebaLogin/PHP/createnewpwd.php?selector=".$selector."&validator=".bin2hex($token);
		$caduca = date("U") + 3600;

		require 'conexion.php';

		$mailUser = $_POST['mail'];

		if (empty($mailUser)) {
			header("Location: ../resetpwd.php?error=empty");
			exit();
		} 
		else {
			$consulta = "DELETE FROM resetpassword WHERE passwordResetEmail=?";
			$represent = mysqli_stmt_init($con);
			if (!mysqli_stmt_prepare($represent,$consulta)) {
				echo "Error";
				exit();
			}
			else{
				mysqli_stmt_bind_param($represent,"s",$mailUser);
				mysqli_stmt_execute($represent);
			}

			$consulta ="INSERT INTO resetpassword(passwordResetEmail, passwordResetSelector, passwordResetToken, passwordResetExpires) VALUES (?,?,?,?)";

			if (!mysqli_stmt_prepare($represent,$consulta)) {
				echo "Error";
				exit();
			}
			else{
				$hashToken = password_hash($token, PASSWORD_DEFAULT);
				mysqli_stmt_bind_param($represent,"ssss",$mailUser,$selector,$hashToken,$caduca);
				mysqli_stmt_execute($represent);
			}
			mysqli_stmt_close($represent); //Cierra una sentencia preparada
			mysqli_close($con);//cierra conexion

			//Crear el correo electrónico de recuperación de contraseña
			require_once('../PHPMailer-5.2-stable/PHPMailerAutoload.php');

			$mail = new PHPMailer();
			$mail -> isSMTP();
			$mail -> SMTPAuth = true; //variable booleanea
			$mail -> SMTPSecure = 'ssl';
			$mail -> Host = 'smtp.gmail.com';//servidor smtp de Gmail gratuito
			$mail -> Port = '465'; //puerto
			$mail -> isHTML();
			$mail -> Username = ''; //Gmail desde donde envio
			$mail -> Password = ''; //password
			$mail -> SetFrom('no-reply@hoecode.org');
			$mail -> Subject = 'Recuperar cuenta';
			$mail -> Body = '<p>Hemos recibido una solicitud de restablecimiento de contrase&ntilde;a de tu cuenta. '.$url.'</p>';
			$mail -> AddAddress($mailUser); //A quien se enviara el mail

			$mail -> Send();
			header("Location: ../resetpwd.php?reset=success");
			exit();
		}

	}
	else {
		//Si el usuario accedio sin hacer click en el buttom nuevaCuenta
		header("Location: ../index.php");
		exit();
	}	
?>