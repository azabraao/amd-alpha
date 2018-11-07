<?php
	session_start();

	/*
		erro = 1: senha antiga errada
		erro = 2: senhas novas não batem
	*/

	require_once('conexao.php');

	$id = $_SESSION['id_usuario'];
	$senha = $_SESSION['senha'];


	$antiga = md5($_POST['senha-antiga']);
	$nova   = $_POST['senha-nova'];
	$nova2x = $_POST['senha-nova-repeticao'];


		
	// $objBd = new bd();
	// $link  = $objBd->conecta_mysql();

	// $retorno_bd = mysqli_query($link,$sql);



	if ($antiga != $senha) {
		header("Location: ../senha.php?erro=1");
	} elseif ($nova <> $nova2x) {
		header("Location: ../senha.php?erro=2");
	} else{
		$nova = md5($nova);
		
		$sql = " UPDATE tb_usuarios SET senha = '$nova' where id_usuario = $id";

		
		$objBd = new bd();
		$link  = $objBd->conecta_mysql();

		$retorno_bd = mysqli_query($link,$sql);
		
		if($retorno_bd ){
		}else{
			echo "A senha não foi alterada, entre em contato com o administrador.";
			mysqli_error($link);
			die();
		}



		header('Location: sair.php?erro=3');
	}



?>