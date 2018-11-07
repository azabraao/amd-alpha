<?php
	session_start();
	require_once('conexao.php');

	if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

	$texto 		= $_POST['mensagem'];
	$tipo   	= 1;	
	$id_usuario = $_SESSION['id_usuario'];
	$id_obra 	= $_SESSION['id_obra'];
	
	$sql = " INSERT INTO tb_mensagens(texto,tipo,mensagem_id_usuario,TB_Obras_id_obra)VALUES('$texto',$tipo,$id_usuario, $id_obra) ";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_query = mysqli_query($link,$sql);

	if($resultado_query){
		header("Location: ../acompanhamento.php?id_obra=".$id_obra."&flag=1");
	} else{
		echo "Houve algum erro ao inserir a mensagem, entre em contato com o administrador.";
	}
?>