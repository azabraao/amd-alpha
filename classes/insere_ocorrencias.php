<?php
	
	session_start();
	require_once('conexao.php');

	if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

	$titulo = $_POST['titulo'];
	$tipo = $_POST['tipo-ocorrencia'];
	$causa = $_POST['causa'];
	$efeito = $_POST['efeito'];
	$id_relatorio = 1;
	$id_obra = $_SESSION['id_obra'];
	$id_usuario = $_SESSION['id_usuario'];

	$novo_nome = null;

	// Upload de imagem
	if($_FILES['arquivo']['size'] > 0) {
		
		$extensao  = strtolower(substr($_FILES['arquivo']['name'], -4));
		$novo_nome = time().$extensao;
		$diretorio = "../upload/";

		move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);
	}	else{
		echo "Não tem nada na var File";
	}


	$sql = " INSERT INTO tb_ocorrencias(titulo_ocorrencia,tipo_ocorrencia,imagem,causa,efeito, tb_relatorio_id_relatorio,tb_obras_id_obra)values('$titulo', $tipo, '$novo_nome', '$causa', '$efeito',$id_relatorio, $id_obra) ";

 	// String sql da mensagem que linka o relatório
 	$sql_msg = " INSERT INTO tb_mensagens(tipo, texto,MENSAGEM_ID_USUARIO,TB_Obras_id_obra)values(4,'Nova ocorrência',$id_usuario,$id_obra); ";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_query = mysqli_query($link,$sql);
	$resultado_query_msg = mysqli_query($link,$sql_msg);

	echo "$sql";

	if(!$resultado_query_msg){
		echo "Houve algum no momento de inserir a ocorrência. Entre em contato com o administrador.";
	}
	if($resultado_query){
		header("Location: ../acompanhamento.php?id_obra=".$id_obra."&flag=1");
	} else{
		echo "Houve algum erro ao inserir a ocorrência. Você esqueceu de algum campo?";
	}
?>