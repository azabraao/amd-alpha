<?php

class Session{


// usar hierarquia da session com um if. If(administrador){Não valida nada}
	function validaSessao($id_usuario, $id_obra){

		$hierarquia = $_SESSION['hierarquia'];

		if($hierarquia == 1 || $hierarquia == 2){
				require_once('conexao.php');

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$sql = " SELECT * FROM tb_relacao_usuario_obra WHERE id_usuario = $id_usuario AND acesso_id_obra = $id_obra ";

				$resultado_bd = mysqli_query($link,$sql);

				if ($resultado_bd) {
					$qtd =  mysqli_num_rows($resultado_bd);
					if($qtd){
					}else{
						echo "sem acesso";
						header("Location: inicio.php");
					}

				} else{
					echo "Houve um problema ao validar o usuário. Por favor, entre em contato com o administrador.";
					die();
				}
		}
	}

	function validaRelatorio($id_usuario, $id_relatorio){

		$hierarquia = $_SESSION['hierarquia'];

		if($hierarquia == 1 || $hierarquia == 2){
				require_once('conexao.php');

				$objBd = new bd();
				$link = $objBd->conecta_mysql();


			$sql =" SELECT 
						us.id_usuario, 
					    rel.acesso_id_obra,
					    o.id_obra,
					    o.nome_obra
					    
					FROM tb_usuarios us 

					INNER JOIN tb_relacao_usuario_obra rel on rel.id_usuario = us.id_usuario
					INNER JOIN tb_obras o 				   on o.id_obra = rel.acesso_id_obra
					INNER JOIN tb_relatorios r 			   on r.tb_obras_id_obra = o.id_obra

					where us.id_usuario = $id_usuario and r.id_relatorio = $id_relatorio ";


				$resultado_bd = mysqli_query($link,$sql);

				if ($resultado_bd) {
					$qtd =  mysqli_num_rows($resultado_bd);
					if($qtd){
					}else{
						echo "sem acesso";
						header("Location: relatorios.php");
					}

				} else{
					echo "Houve um problema ao validar o usuário. Por favor, entre em contato com o administrador.";
					die();
				}
		}
	}	

	function validaOcorrencia($id_usuario,$id_ocorrencia){

		$hierarquia = $_SESSION['hierarquia'];

		if($hierarquia == 1 || $hierarquia == 2){
				require_once('conexao.php');

				$objBd = new bd();
				$link = $objBd->conecta_mysql();


			$sql =" SELECT 
						us.id_usuario, 
					    rel.acesso_id_obra,
					    o.id_obra,
					    o.nome_obra
					    
					FROM tb_usuarios us 

					INNER JOIN tb_relacao_usuario_obra rel on rel.id_usuario = us.id_usuario
					INNER JOIN tb_obras o 				   on o.id_obra = rel.acesso_id_obra
					INNER JOIN tb_ocorrencias r 		   on r.tb_obras_id_obra = o.id_obra

					where us.id_usuario = $id_usuario and r.id_ocorrencia = $id_ocorrencia ";


				$resultado_bd = mysqli_query($link,$sql);

				if ($resultado_bd) {
					$qtd =  mysqli_num_rows($resultado_bd);
					if($qtd){
			
					}else{
						echo "sem acesso";
						header("Location: ocorrencias.php");
					}

				} else{
					echo "Houve um problema ao validar o usuário. Por favor, entre em contato com o administrador.";
					die();
				}
		}

	}
}

?>