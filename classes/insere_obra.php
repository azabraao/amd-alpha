<?php

session_start();
require_once('conexao.php');

if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

$id_obra = $_SESSION['id_obra'];
$id_usuario = $_SESSION['id_usuario'];

$tipo_obra = $_POST['tipo_obra'];
$nome_obra = $_POST['titulo_obra'];
$endereco	= $_POST['endereco'];
$inicio_obra = $_POST['inicio_obra'];
$fim_obra	 = $_POST['fim_obra'];
$id_contratante = $_POST['id_contratante'];

$id_cliente1 = $_POST['id_cliente1'];
$id_cliente2 = $_POST['id_cliente2'];
$id_funcionario = $_POST['id_funcionario'];
	
// Para o uso posterior da url
$flag_obra = 0;
$flag_us = 0;

/* 
	Dicionário de flags:
	flag_obra = 1: Obra inserida com sucesso.
	flag_obra = 2: Ocorreu um erro ao inserir a obra.
	flag_obra = 3: Não é possível inserir os mesmos clientes na mesma obra
	flag_obra = 4: Uma obra não pode começar depois do fim

	flag_us = 1: Ocorreu um erro ao tentar criar a relação usuário-obra
*/

if ($id_cliente1 > 0 && $id_cliente1 == $id_cliente2) {
	echo "Você não pode inserir os mesmos clientes na mesma obra";
	header("Location: ../dashboard.php?flag_obra=3"); //flag 3
	die();
	 
}

if ($inicio_obra > $fim_obra) {
	echo "Uma obra não pode começar depois do fim dela mesma.";
	header("Location: ../dashboard.php?flag_obra=4"); //flag 4 	
	die();
}
	
echo "$tipo_obra<br>$endereco<br>$nome_obra<br>$id_cliente1<br>$id_cliente2<br>$id_funcionario<br>$id_contratante<br>$inicio_obra<br>$fim_obra";

$sql = " INSERT INTO tb_obras(tipo_obra,nome_obra,endereco,inicio_obra,fim_obra,id_contratante)values($tipo_obra,'$nome_obra','$endereco','$inicio_obra','$fim_obra',$id_contratante) ";

echo "<br><br><br>$sql<br><br><br>";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$resultado_query = mysqli_query($link,$sql);

	if($resultado_query){
		
		// Caso a obra seja inserida, um select é feito para capturar o último ID inserido no banco 
		$sql_id = " SELECT MAX(id_obra) as max_obra FROM tb_obras "; 
	
		if($resultado_query_id = mysqli_query($link,$sql_id)) {

			// Caso o último ID seja encontrado no banco, passamos para o outro insert que é quem constrói a relação usuário-obra
			while($id_obra_query = mysqli_fetch_array($resultado_query_id)) {
				$max_obra = $id_obra_query['max_obra'];
				$sql_cli_1 = " INSERT INTO tb_relacao_usuario_obra(id_usuario,acesso_id_obra)VALUES($id_cliente1,$max_obra) ";
				$sql_cli_2 = " INSERT INTO tb_relacao_usuario_obra(id_usuario,acesso_id_obra)VALUES($id_cliente2,$max_obra) ";
				$sql_func  = " INSERT INTO tb_relacao_usuario_obra(id_usuario,acesso_id_obra)VALUES($id_funcionario,$max_obra) ";

				
				
				if($resultado_query_relacao_1 = mysqli_query($link, $sql_cli_1)){
					echo "<br>Primeira relação cliente-obra feita<br>";//flag
				} else{
					$flag_us = 1; //flag_us 1
				}

				if($resultado_query_relacao_2 = mysqli_query($link, $sql_cli_2)){
					echo "<br>Segunda relação cliente-obra feita<br>";//flag
				} else{
					$flag_us = 1; //flag_us 1
				}

				if($resultado_query_relacao_3 = mysqli_query($link, $sql_func)){
					echo "<br>Relação funcionário-obra feita<br>";//flag
				} else{
					$flag_us = 1; //flag_us 1
				}

			}

			echo "Deu tudo certo ao encontrar o ID da última obra inserida";//flag 1
		} else{
			$flag_us = 1;//flag_us 1
		}

		echo "<br>Deu tudo certo com a obra<br>";//flag 1 
		header("Location: ../dashboard.php?&flag_obra=1&flag_us=".$flag_us);
	} else{
		header("Location: ../dashboard.php?&flag_obra=2&flag_us=".$flag_us); //flag 2
	}

?>