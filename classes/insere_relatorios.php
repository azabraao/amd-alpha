<?php
	
	session_start();
	require_once('conexao.php');

	if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');


	$atividades  	= $_POST['atividades'];
	$tempo 			= $_POST['tempo'];
	$id_obra 		= $_SESSION['id_obra'];
	$id_usuario 	= $_SESSION['id_usuario'];
	
	// String sql do relatorio
	$sql = " INSERT INTO tb_relatorios(condicao_tempo, atividades_executadas, tb_obras_id_obra)values('$tempo','$atividades',$id_obra);
 ";
 	// String sql da mensagem que linka o relatório
 	$sql_msg = " INSERT INTO tb_mensagens(tipo, texto,MENSAGEM_ID_USUARIO,tb_obras_id_obra)values(3,'Novo relatório',$id_usuario,$id_obra); ";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_query = mysqli_query($link,$sql);
	$resultado_query_msg = mysqli_query($link,$sql_msg);

	if(!$resultado_query_msg){
		echo "Houve algum no momento de inserir o relatório. Entre em contato com o administrador.";
	}
	if($resultado_query){
		header("Location: ../acompanhamento.php?id_obra=".$id_obra."&flag=1");
	} else{
		echo "Houve algum erro ao inserir o relatório. Entre em contato com o administrador.";
	}
?>