<?php
	
	session_start();

	require_once('conexao.php');

	$email = $_POST['email'];
	$senha = md5($_POST['senha']);

	$sql = " SELECT email,id_usuario,senha,nome_usuario,sobrenome_usuario,hierarquia FROM tb_usuarios where email = '$email' and senha = '$senha' and istatus_usuario = 0 ";
		
	$objBd = new bd();
	$link  = $objBd->conecta_mysql();

	$retorno_bd = mysqli_query($link,$sql);

	if($retorno_bd){
		$dados_usuario = mysqli_fetch_array($retorno_bd);

		if(isset($dados_usuario['email'])){

			$_SESSION["id_usuario"] = $dados_usuario['id_usuario'];
			$_SESSION["email"] = $dados_usuario['email'];
			$_SESSION["senha"] = $dados_usuario['senha'];
			$_SESSION["nome"] = $dados_usuario['nome_usuario'];
			$_SESSION["sobrenome"] = $dados_usuario['sobrenome_usuario'];
			$_SESSION["hierarquia"] = $dados_usuario['hierarquia'];
			
			if ($dados_usuario['hierarquia'] == 1 || $dados_usuario['hierarquia'] == 2) {
				header('Location: ../inicio.php');				
			} else{
				header('Location: ../dashboard.php');
			}
		}else{
			 header('Location: ../index.php?erro=1');
		}

	} else{
		echo "Erro na execução da consulta, favor entre em contato com o administrador do site.";
	}

?>