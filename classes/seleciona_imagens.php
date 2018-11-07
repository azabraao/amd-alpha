<?php
  require_once("conexao.php");
	 
 class Imagens{

	function selecionaImagens(){			
		  $id_usuario = $_SESSION['id_usuario'];
		  $id_obra    = $_SESSION['id_obra'];

			$sql =" SELECT	imagem FROM tb_mensagens "; 
			$sql.=" WHERE tb_obras_id_obra = $id_obra and istatus_mensagem = 0";

			$objBd = new bd();
			$link = $objBd->conecta_mysql();

			$resultado_bd = mysqli_query($link, $sql);

			if($resultado_bd){
				$qtd =  mysqli_num_rows($resultado_bd);

				if ($qtd == 0) {
					echo "<center><h2 style='color:green'>Não há nenhuma imagem ainda!</h2></center>";
				} else{
					 while($imagens = mysqli_fetch_array($resultado_bd)){
					 	if($imagens['imagem'] > ''){
							echo "<li><img src='upload/".$imagens['imagem']."' alt='imagem' title='imagem' class='img-responsive'></li>";
	            		}
					 }
				}
			}
	}
}
?>