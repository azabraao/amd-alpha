<?php

	session_start();
	require_once('conexao.php');


	/*
		Para se colocar no dicionário de dados:

		ISTATUS = 0: usuário ativo,
		ISTATUS = 1: usuário desativo
	*/	

	$id_usuario = $_POST['id_usuario'];
	$objBd = new bd();
	$link  = $objBd->conecta_mysql(); 
 

	$sql = " UPDATE tb_usuarios SET istatus_usuario = 1 WHERE id_usuario=$id_usuario ";
	
	$retorno_bd = mysqli_query($link,$sql);
	
	if($retorno_bd){
		echo "Usuário desativado.";
		header("Location: ../usuarios.php?flag_obra=2");

	}else{
		echo "Houve algum ao atualizar a informação sobre o usuário. Entre em contato com o administrador.";
	}	

?>