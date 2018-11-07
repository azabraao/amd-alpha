<?php

	$hierarquia = $_POST['hierarquia']; 
	$nome 		= $_POST['nome'];
	$sobrenome 	= $_POST['sobrenome'];
	$email 		= $_POST['email'];
	$senha 		= md5($_POST['senha']);

	require_once('conexao.php');
	$select = " SELECT * FROM tb_usuarios WHERE email = '$email' ";

	$sql = " INSERT INTO tb_usuarios(hierarquia,nome_usuario, sobrenome_usuario, email, senha) ";
	$sql.= " VALUES($hierarquia,'$nome','$sobrenome','$email','$senha' )";

	$objBd = new bd();
	$link  = $objBd->conecta_mysql();
	$retorno_bd = mysqli_query($link, $select);
	$testeEmail = mysqli_fetch_array($retorno_bd);


	if($testeEmail['email'] == ''){
		
		$retorno_bd = mysqli_query($link, $sql);

		if ($retorno_bd) {
			header('Location: ../dashboard.php?flag=3');
		}else
		{
			echo "Houve algum problema ao tentar inserir o novo registro, entre em contato com o administrador.";
		}		

	}	

	else{
		header("Location: ../dashboard.php?flag=1");	
	}



?>