<?php

	session_start();
	require_once('conexao.php');

	if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

	$tipo   	= 2;	
	$id_usuario = $_SESSION['id_usuario'];
	$id_obra 	= $_SESSION['id_obra'];
	
	$novo_nome 	= null;
	

	// Pasta onde o arquivo vai ser salvo
	$_UP['pasta'] = '../upload/';
	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
	// Array com as extensões permitidas
	$_UP['extensoes'] = array('jpg', 'png', 'gif');
	// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
	$_UP['renomeia'] = false;
	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['arquivo']['error'] != 0) {
	  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
	  exit; // Para a execução do script
	}

	// Faz a verificação da extensão do arquivo
		$img_nome =  $_FILES['arquivo']['name'];
		$img_separador = explode('.',$img_nome);
		$extensao = strtolower(end($img_separador));

	if (array_search($extensao, $_UP['extensoes']) === false) {
	  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
	  exit;
	}
	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
	  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
	  exit;
	}
	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
	  $nome_final = md5(time()).'.jpg';
	} else {
	  // Mantém o nome original do arquivo
	  $nome_final = $_FILES['arquivo']['name'];
	}
	  
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
	  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	  echo "Upload efetuado com sucesso!";
	  echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
	} else {
	  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
	  echo "Não foi possível enviar o arquivo, tente novamente";
	}

	// insert no banco de dados:

	$sql = " INSERT INTO tb_mensagens(imagem,tipo,mensagem_id_usuario,tb_obras_id_obra)VALUES('$nome_final',$tipo,$id_usuario, $id_obra) ";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_query = mysqli_query($link,$sql);

	if($resultado_query){
		header("Location: ../acompanhamento.php?id_obra=".$id_obra."&flag=1");
	} else{
		echo "Houve algum erro ao inserir a imagem. Entre em contato com o administrador.";
	}

?>