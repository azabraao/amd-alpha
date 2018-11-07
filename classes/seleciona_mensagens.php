<?php
session_start();
require_once('conexao.php');

$id_usuario = $_SESSION['id_usuario']; 
$id_obra 	= $_SESSION['id_obra'];
$limite 	= $_POST['limite'];


$objBd = new bd();
$link = $objBd->conecta_mysql();

$sqlCount =" SELECT count(msg.id_mensagem) as quant";
$sqlCount.=" FROM tb_mensagens msg "; 
$sqlCount.=" INNER JOIN tb_obras ob on ob.id_obra = msg.tb_obras_id_obra ";
$sqlCount.=" INNER JOIN tb_usuarios us ON us.id_usuario = msg.mensagem_id_usuario ";
$sqlCount.=" WHERE ob.id_obra = ".$id_obra." and istatus_mensagem = 0";

$resultado_bd_count = mysqli_query($link, $sqlCount);

if ($resultado_bd_count) {
	$quantidade = mysqli_fetch_array($resultado_bd_count);
}

$qtdInicio = $quantidade['quant'] - $limite ;

if($qtdInicio < 10){
	$qtdInicio  = 0;	
}

$sql = " SELECT	msg.texto,date_format(msg.data_hora,'%d/%m/%Y') AS data_msg,msg.mensagem_id_usuario,msg.imagem,us.hierarquia, us.nome_usuario, msg.tipo ";
$sql.=" FROM tb_mensagens msg "; 
$sql.=" INNER JOIN tb_obras ob on ob.id_obra = msg.tb_obras_id_obra ";
$sql.=" INNER JOIN tb_usuarios us ON us.id_usuario = msg.mensagem_id_usuario ";
$sql.=" WHERE ob.id_obra = ".$id_obra." and istatus_mensagem = 0 GROUP BY msg.id_mensagem ASC LIMIT $qtdInicio,". $quantidade['quant']." ";

$resultado_bd = mysqli_query($link, $sql);
	if($resultado_bd){
		$fotoAMD = true;
		$VcUser	 = true; 
		$id_bd_user = 0;

		$qtd =  mysqli_num_rows($resultado_bd);
		if ($qtd == 0){
			echo "<center><h2 style='color:green'>Não há nenhuma mensagem ainda!</h2></center>";
		}
		else{
			
			while($obras = mysqli_fetch_array($resultado_bd)){

				if($obras['hierarquia'] == 2 || $obras['hierarquia'] == 3){
					$VcUser = true;

					switch ($obras['tipo']) {
						case 1:
								if($fotoAMD==true){
									echo "<div class='col-sm-12 col-xs-12'>
											<div class='col-sm-2 col-xs-3 center'>

												<img src='img/logo.png' class='img-responsive'>

										  	</div>

									<div class='col-sm-10 col-xs-9 mensagem fixed'>
										<span class='text-msg'>".$obras['texto']."</span>
										<span class='data-msg'>".$obras['data_msg']."</span>
									</div>
									</div>";
										
									$fotoAMD = false;
								} else{
									echo "<div class='col-sm-12 col-xs-12'><div class='col-sm-2 col-xs-3 center'><img src='' class='img-responsive'></div><div class='col-sm-10 col-xs-9 mensagem fixed'><span class='text-msg'>".$obras['texto']."</span><span class='data-msg'>".$obras['data_msg']."</span></div></div>";
								}
							
							break;
						case 2:
								if($fotoAMD==true){
									echo "<div class='col-sm-12 col-xs-12'><div class='col-sm-2 col-xs-3 center'><img src='img/logo.png' class='img-responsive'></div><div class='col-sm-10 col-xs-9 mensagem fixed'><img src='"."upload/".$obras['imagem']."' class='img-responsive'><span class='text-msg'>".$obras['texto']."</span><span class='data-msg'>".$obras['data_msg']."</span></div></div>";

									$fotoAMD = false;
								} else{
									echo "<div class='col-sm-12 col-xs-12'><div class='col-sm-2 col-xs-3 center'><img src='img/logo.png' class='img-responsive'></div><div class='col-sm-10 col-xs-9 mensagem fixed'><img src='"."upload/".$obras['imagem']."' class='img-responsive'><span class='text-msg'>".$obras['texto']."</span><span class='data-msg'>".$obras['data_msg']."</span></div></div>";

								}
							break;
						case 3:
									echo"<div class='col-sm-12 col-xs-12'><div class='col-sm-2 col-xs-2 center'><img src='' class='img-responsive'></div><a href='relatorios.php'><div class='col-sm-10 col-xs-10  msg-relatorio'><span class='text-msg'>Novo Relatório</span><span class='data-msg'>".$obras['data_msg']."</span></div></a></div> ";
							break;
						case 4:
									echo" <div class='col-sm-12 col-xs-12'><div class='col-sm-2 col-xs-2 center'><img src='' class='img-responsive'></div><a href='ocorrencias.php'><div class='col-sm-10 col-xs-10  msg-relatorio'><span class='text-msg'>Nova ocorrência</span><span class='data-msg'>".$obras['data_msg']."</span></div></a></div> ";							
							break;
						default:
									echo " Algum erro aconteceu. Entre em contato com o administrador. ";
							break;
					}
					
				} 
				elseif ($obras['hierarquia'] == 1){
					if ($id_bd_user != $obras['mensagem_id_usuario']) {
						$VcUser = true;
					}
					if($VcUser==true){
						echo "<div class='col-sm-12 col-xs-12'> 
		              <div class='col-sm-10 col-xs-10 mensagem'>
		                <span class='text-msg'>".$obras['texto']."</span>
		                <span class='data-msg'>".$obras['data_msg']."</span>
		              </div>
		              <div class='col-sm-2 col-xs-2 center'>
		                <span class='name-user'>".$obras['nome_usuario']."</span>
		              </div> 
		             </div>";

						$fotoAMD = true;
		             	$VcUser = false;
		         	} else{
						echo "<div class='col-sm-12 col-xs-12'> 
		              <div class='col-sm-10 col-xs-10 mensagem'>
		                <span class='text-msg'>".$obras['texto']."</span>
		                <span class='data-msg'>".$obras['data_msg']."</span>
		              </div>
		              <div class='col-sm-2 col-xs-2 center'>
		              </div> 
		             </div>";

		         	}
				}	else{
					echo " Ocorreu algum problema, entre em contato com o administrador ";
				}	
			
				$id_bd_user = $obras['mensagem_id_usuario'];				

			}
		}
	}else{
		"Houve um problema ao selecionar as mensagens, entre em contato com o administrador.";
	}
?>