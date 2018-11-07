<?php
	/*
		Para se colocar no dicionário de dados:

		ISTATUS = 0: Obra em andamento,
		ISTATUS = 1: Obra arquivada,
		ISTATUS = 2: Obra concluida 
	*/	

	session_start();
	require_once('conexao.php');

	$id_usuario = $_POST['id_usuario'];
	$objBd = new bd();
	$link  = $objBd->conecta_mysql(); 
 

	$sql = " UPDATE tb_usuarios SET istatus_usuario = 0 WHERE id_usuario=$id_usuario ";
	
	$retorno_bd = mysqli_query($link,$sql);
	
	if($retorno_bd){
		echo "Usuario reativado com sucesso.";
		header("Location: ../usuarios.php?flag_obra=2");

	}else{
		echo "Houve algum reativar o usuário. Entre em contato com o administrador.";
	}	
			
?>