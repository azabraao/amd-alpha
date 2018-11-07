<?php
  require_once("conexao.php");
	 
 class Relatorios{

	function selecionaRelatorios(){			
		  $id_usuario = $_SESSION['id_usuario'];
		  $id_obra    = $_SESSION['id_obra'];

			$sql =" SELECT	id_relatorio,date_format(data_relatorio,'%d/%m/%Y') as data_relatorio FROM tb_relatorios re ";
			$sql.=" INNER JOIN tb_obras ob on re.tb_obras_id_obra = ob.id_obra ";
			$sql.=" WHERE ob.id_obra = '$id_obra' and istatus_relatorio = 0 ";

			$objBd = new bd();
			$link = $objBd->conecta_mysql();

			$resultado_bd = mysqli_query($link, $sql);

			if($resultado_bd){
					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<center><h2 style='color:green'>Não há nenhum relatório ainda!</h2></center>";
					} else{

						 while($relatorios = mysqli_fetch_array($resultado_bd)){

							echo "<a href='relatorio.php?id=".$relatorios['id_relatorio']."'>
									<div class='relatorios'>
										<span>".$relatorios['data_relatorio']."</span>
									</div>
								 </a>";
						 }
					}
				}
			}

	function selecionaRelatorio(){

		$id_ocorrencia = $_GET['id'];

		$sql = " SELECT date_format(data_hora, '%m/%d/%Y') as data_ocorrencia, imagem, causa, efeito FROM tb_ocorrencias WHERE id_ocorrencia = '$id_ocorrencia' ";

		$objBd = new bd();
		$link = $objBd->conecta_mysql();

		$resultado_bd = mysqli_query($link, $sql);

		if($resultado_bd){
			$dados_bd = mysqli_fetch_array($resultado_bd);


			echo "<span>".$dados_bd['data_ocorrencia']."</span><br>
          <h2>Causa</h2>
          <p>".$dados_bd['CAUSA']."</p>
          <img src='upload/".$dados_bd['imagem']."' class='img-responsive' style='display: inline;'>
          <h2>Efeito</h2>
          <p>".$dados_bd['efeito']."</p>";	
		}else{
			echo "Algo deu errado com a busca pela ocorrência, entre em contato com o administrador.";
		}


	}
}
?>