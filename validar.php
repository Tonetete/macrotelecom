
<?php

	include_once("./functions/conexion.php");
	include_once("./functions/consultas.php");

	if(isset($_POST['usuario']) && isset($_POST['password'])) {
		$num = comprobarUsuario($_POST['usuario'],$_POST['password']);
		echo $num;
	}

	else {

	}


;?>