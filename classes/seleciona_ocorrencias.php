<?php
  require_once("conexao.php");
	 
 class Ocorrencias{

	function selecionaOcorrencias(){			
		  $id_usuario = $_SESSION['id_usuario'];
		  $id_obra    = $_SESSION['id_obra'];

			$sql =" SELECT	id_ocorrencia,titulo_ocorrencia,date_format(data_hora,'%d/%m/%Y') as data_ocorrencia FROM tb_ocorrencias oc "; 
			$sql.=" INNER JOIN tb_obras ob on oc.tb_obras_id_obra = ob.id_obra ";
			$sql.=" WHERE ob.id_obra = '$id_obra' and istatus_ocorrencia = 0 ";

			$objBd = new bd();
			$link = $objBd->conecta_mysql();

			$resultado_bd = mysqli_query($link, $sql);

			if($resultado_bd){
					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<center><h2 style='color:green'>Não há nenhuma ocorrência ainda!</h2></center>";
					} else{

						 while($ocorrencias = mysqli_fetch_array($resultado_bd)){

							echo "<a href='ocorrencia.php?id=".$ocorrencias['id_ocorrencia']."'>
									<div class='ocorrencias'>
										<span>".$ocorrencias['titulo_ocorrencia']."</span>
										<span class='data-msg'>".$ocorrencias['data_ocorrencia']."</span>        
									</div>
								 </a>";
						 }
					}
				}
			}
	function selecionaOcorrencia(){

		$id_ocorrencia = $_GET['id'];

		$sql = " SELECT date_format(data_hora, '%m/%d/%Y') as data_ocorrencia, imagem, causa, efeito FROM tb_ocorrencias WHERE id_ocorrencia = '$id_ocorrencia' ";

		$objBd = new bd();
		$link = $objBd->conecta_mysql();

		$resultado_bd = mysqli_query($link, $sql);

		if($resultado_bd){
			$dados_bd = mysqli_fetch_array($resultado_bd);


			echo "<span>".$dados_bd['data_ocorrencia']."</span><br>
          <h2>causa</h2>
          <p>".$dados_bd['causa']."</p>
          <img src='upload/".$dados_bd['imagem']."' class='img-responsive' style='display: inline;'>
          <h2>efeito</h2>
          <p>".$dados_bd['efeito']."</p>";	
		}else{
			echo "Algo deu errado com a busca pela ocorrência, entre em contato com o administrador.";
		}


	}
}
?>