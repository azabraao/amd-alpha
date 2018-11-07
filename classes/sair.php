<?php
	session_start();

	unset($_SESSION["id_usuario"] );
	unset($_SESSION["hierarquia"] );
	unset($_SESSION["nome"] );
	unset($_SESSION["sobrenome"] );
	unset($_SESSION["email"] );
	unset($_SESSION["senha"] );

	// Esse get não representa um erro de verdade, é apenas o identificador de alteração de senha
	$erro = $_GET['erro'];

	if ($erro == 3) {
		header('Location: ../index.php?flag=3');		
	} else{
		header('Location: ../index.php');
	}
?>