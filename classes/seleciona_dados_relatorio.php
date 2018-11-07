<?php
  require_once("conexao.php");
	 
 class Relatorio{


	function selecionaDadosBasicos(){			
		
		  $id_usuario = $_SESSION['id_usuario'];
		  $id_obra    = $_SESSION['id_obra'];
		  $id_relatorio = $_GET['id'];
			$sql =" SELECT 
						date_format(rel.data_relatorio,'%d/%m/%Y') as data_relatorio,
						ob.id_obra,
						DATEDIFF(ob.fim_obra,ob.inicio_obra) as data_diferenca,
						ob.endereco,
						ob.nome_obra,
						rel.atividades_executadas,
						rel.condicao_tempo,
						ob.id_contratante
					FROM tb_relatorios rel
					INNER JOIN tb_obras ob on ob.id_obra = rel.tb_obras_id_obra
					WHERE ob.id_obra = $id_obra and rel.id_relatorio = $id_relatorio ";

			$objBd = new bd();
			$link = $objBd->conecta_mysql();

			$resultado_bd = mysqli_query($link, $sql);

			if($resultado_bd){

         while($dados_relatorio = mysqli_fetch_array($resultado_bd)){

				 	$id_contratante = $dados_relatorio['id_contratante'];
	 				$sql_contratante = " SELECT nome_usuario,sobrenome_usuario FROM tb_usuarios  WHERE id_usuario = $id_contratante ";
					$resultado_bd_contratante = mysqli_query($link, $sql_contratante);
					$nome_contratante = mysqli_fetch_array($resultado_bd_contratante);

				 	$data_rel = date('d,m,Y', strtotime($dados_relatorio['data_relatorio']));

	 				$sql_ocorrencia = " SELECT count(OC.id_ocorrencia) as quant 
											FROM tb_ocorrencias OC	
									    INNER JOIN tb_obras O ON O.id_obra = OC.tb_obras_id_obra    
										WHERE date_format(data_hora,'%m,%d,%Y') = '$data_rel' AND id_obra  = $id_obra ";

					$resultado_bd_ocorrencia = mysqli_query($link, $sql_ocorrencia);
					$qtd_ocorrencia = mysqli_fetch_array($resultado_bd_ocorrencia);
 
				 	echo "     <div class='container'>
      <div class='col-sm-8 col-sm-offset-2'>
        <table class='table table-bordered' style='background-color: white;'>
          <tbody>

            <tr>
              <td colspan='5' rowspan='3' class='center'>
                <img src='img/logo.png' class='img-responsive' style='width: 30%; margin-left: 35%;'>
              </td>
              <th>Data</th>
              <td>".$dados_relatorio['data_relatorio']."</td>
            </tr>

            <tr>
              <th>Obra No</th>
              <td>000".$dados_relatorio['id_obra']."</td>
            </tr>

            <tr>
              <th>Prazo Contratual</th>
              <td>".$dados_relatorio['data_diferenca']." dias</td>
            </tr>

            <tr>
              <th>Obra</th>
              <td colspan='4' id='b-obra'>".$dados_relatorio['nome_obra']."</td>
              <th rowspan='2' style='vertical-align: middle;'>Contratante</th>
              <td rowspan='2' style='vertical-align: middle;'>".$nome_contratante['nome_usuario']." ".$nome_contratante['sobrenome_usuario']."</td>
            </tr>

            <tr>
              <th>Local</th>
              <td colspan='4'>".$dados_relatorio['endereco']."</td>
            </tr>
            <tr>
              <th colspan='7'>Atividades Executadas</th>
            </tr>
            <tr>
              <td colspan='7'> ".$dados_relatorio['atividades_executadas']."</td>
            </tr>
            <tr>
              <th colspan='5'>Ocorrências</th>
              <th colspan='2'>Tempo</th>
            </tr>
            <tr>
              <td colspan='5'>".$qtd_ocorrencia['quant']." ocorrência(s) "."</td>
              <td colspan='2'>".$dados_relatorio['condicao_tempo']."</td>
            </tr>
            <tr>
              <th colspan='7'>Anexos</th>
            </tr>
            <tr>
              <td colspan='7'>Nenhum</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> ";
				 }
			}
	}

}





?>