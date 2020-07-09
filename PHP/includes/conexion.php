<?php
//Conexion a la base
$servernamer = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "loginpag";


$con = mysqli_connect($servernamer,$dBUsername,$dBPassword,$dBName);

if (!$con) {
	die("Fallo Conexion: ".mysqli_connect_error());
}
?>