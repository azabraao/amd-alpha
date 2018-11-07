<?php
	/*
		Para se colocar no dicionário de dados:

		ISTATUS = 0: Obra em andamento,
		ISTATUS = 1: Obra arquivada,
		ISTATUS = 2: Obra concluida 
	*/	

	session_start();
	require_once('conexao.php');

	$id_obra = $_POST['id_obra'];
	$objBd = new bd();
	$link  = $objBd->conecta_mysql(); 
 

	$sql = " UPDATE tb_obras SET istatus_obra = 2 WHERE id_obra=$id_obra ";
	
	$retorno_bd = mysqli_query($link,$sql);
	
	if($retorno_bd){
		echo "Obra marcada como concluida com sucesso.";
		header("Location: ../dashboard.php?flag_obra=6");

	}else{
		echo "Houve algum ao atualizar a informação sobre a obra. Entre em contato com o administrador.";
	}	
			
?>