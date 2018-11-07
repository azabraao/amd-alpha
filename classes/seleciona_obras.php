<?php
  require_once("conexao.php");
	 
 class Obras{

	

	function selecionaObras(){
		  $id_usuario = $_SESSION['id_usuario']; 
		  $hierarquia = $_SESSION['hierarquia'];

		  	switch ($hierarquia) {
		  		case 1:
					$sql ="	SELECT	* FROM tb_obras o ";
					$sql.=" INNER JOIN tb_relacao_usuario_obra u on u.acesso_id_obra = o.id_obra ";
					$sql.="	where u.id_usuario = $id_usuario and o.istatus_obra in (0,2) ";
		  			break;
		  		case 2:
					$sql ="	SELECT	* FROM tb_obras o ";
					$sql.=" INNER JOIN tb_relacao_usuario_obra u on u.acesso_id_obra = o.id_obra ";
					$sql.="	where u.id_usuario = $id_usuario and o.istatus_obra = 0 and o.fase_obra = 0";		  		
		  			break;
		  		default:
		  			# code...
		  			break;
		  	}
			

			$objBd = new bd();
			$link = $objBd->conecta_mysql();

			$resultado_bd = mysqli_query($link, $sql);
			
			if($resultado_bd){
				
				$qtd =  mysqli_num_rows($resultado_bd);

				if ($qtd == 0) {
					echo "<h2 style='color:green'>Não há nenhuma obra cadastrada ainda! </h2>";
				}else{
					while($obras = mysqli_fetch_array($resultado_bd)){
					echo "<a href='acompanhamento.php?id_obra=".$obras['id_obra']."'><div class='obras' id='div-obra'><span>".$obras['nome_obra']."</span></div></a>";
					}
				}
			} else{
				echo "Houve algum problema ao selecionar as obras, entre em contato com o administrador.";
			}
	}

}


?>