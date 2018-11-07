<?php
	
	


	class acompanhamento{


		function titulo(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];
			
			$sql = " SELECT nome_obra FROM tb_obras WHERE id_obra = '$id_obra' and istatus_obra = 0";
			
			$retorno_bd = mysqli_query($link,$sql);
			$dados_bd 	= mysqli_fetch_array($retorno_bd);
			echo $dados_bd['nome_obra'];

		}

		function inicioFim(){

			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];
			
			$sql = " SELECT date_format(inicio_obra, '%d/%m/%Y') as inicio_obra, date_format(fim_obra, '%d/%m/%Y') AS fim_obra FROM tb_obras WHERE id_obra = '$id_obra' and istatus_obra = 0";
			
			$retorno_bd = mysqli_query($link,$sql);
			$dados_bd 	= mysqli_fetch_array($retorno_bd);
				  
			echo " <div class='clearfix box-info'><div class='col-sm-6 col-xs-6 center'><span class='tit-status'>Inicio</span><br><span class='tit-status'>Fim</span></div><div class='col-sm-6 col-xs-6 center'><span class='data-status'>".$dados_bd['inicio_obra']."</span><br><span class='data-status'>".$dados_bd['fim_obra']."</span></div></div>";
		}


		function countImagens(){
			require_once('conexao.php');

			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT COUNT(imagem) as img FROM tb_mensagens WHERE tb_obras_id_obra = $id_obra and istatus_mensagem = 0";

			$retorno_bd = mysqli_query($link,$sql);
			$dados_bd 	= mysqli_fetch_array($retorno_bd);

			echo "<span class='qtd'>".$dados_bd['img']."</span>"; 


		}

		function countRelatorios(){
			require_once('conexao.php');

			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT COUNT(id_relatorio) as relatorio FROM tb_relatorios WHERE tb_obras_id_obra = $id_obra and istatus_relatorio = 0";

			$retorno_bd = mysqli_query($link,$sql);
			$dados_bd 	= mysqli_fetch_array($retorno_bd);

			echo "<span class='qtd'>".$dados_bd['relatorio']."</span>"; 

		}

		function countOcorrencias(){
			require_once('conexao.php');

			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT COUNT(id_ocorrencia) as ocorrencia FROM tb_ocorrencias WHERE tb_obras_id_obra = $id_obra and istatus_ocorrencia = 0";

			$retorno_bd = mysqli_query($link,$sql);
			$dados_bd 	= mysqli_fetch_array($retorno_bd);

			echo "<span class='qtd'>".$dados_bd['ocorrencia']."</span>";

		}


		function selecionaClientesInfo(){
			require_once('conexao.php');

			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];



			$sql = " SELECT 
						u.nome_usuario as nome,
					    u.sobrenome_usuario as sobrenome,
						u.hierarquia as hierarquia
					    
					FROM tb_usuarios u

					INNER JOIN tb_relacao_usuario_obra rel on rel.id_usuario = u.id_usuario
					INNER JOIN tb_obras o on o.id_obra = rel.acesso_id_obra

					WHERE o.id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);	

			if ($retorno_bd) {
				while($dados_bd = mysqli_fetch_array($retorno_bd)){

				switch ($dados_bd['hierarquia']) {
					case 1:
						$hierarquia = "Cliente";
						break;
					case 2:
						$hierarquia = "Funcionário";
						break;
					case 3:
						$hierarquia = "Administrador";
						break;
				}

					echo "
	                <div class='col-sm-8'><strong>
	                  ".$dados_bd['nome']." ".$dados_bd['sobrenome']."
	                </strong></div>
	                <div class='col-sm-4'>
	                  ".$hierarquia."
	                </div>";

					// echo "".$dados_bd['nome']." ".$dados_bd['sobrenome']." ".$hierarquia."<hr>";
				}
			} else{
				echo "Houve um problema ao selecionar alguns dados. Entre em contato com o adminsitrador.";
			}

		}

	}

?>