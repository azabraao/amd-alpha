<?php
	
	class Update{
			
		function selecionaNomeObra(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT nome_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					$nome = $dados_bd['nome_obra'];
				}

			}
			return $nome;
		}	

		function selecionaTipoObra(){

			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT tipo_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					$tipo = $dados_bd['tipo_obra'];
				}

			} 

			return $tipo;
		}	

		function selecionaContratante($id_obra){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$sql_contratante = " SELECT u.id_usuario as id_us,u.nome_usuario,u.sobrenome_usuario FROM tb_usuarios u 
				INNER JOIN tb_obras o on o.id_contratante = u.id_usuario
			WHERE o.id_obra = $id_obra ";
			$resultado_bd_contratante = mysqli_query($link, $sql_contratante);

			if($resultado_bd_contratante){
				
				while($dados_bd = mysqli_fetch_array($resultado_bd_contratante)){
					$contratante = $dados_bd['id_us'];
				}

			}

			return $contratante;
		}

		function funcionario(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];
			
			$sql = " SELECT id_usuario,nome_usuario,sobrenome_usuario FROM tb_usuarios WHERE hierarquia = 2 ";
			
			$retorno_bd = mysqli_query($link,$sql);
			
			if($retorno_bd){
				
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
				}

			}else{
				echo "Houve algum problema ao tentar selecionar os clientes. Entre em contato com o administrador.";
			}
		}		

		function clientes(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];
			
			$sql = " SELECT id_usuario,nome_usuario,sobrenome_usuario FROM tb_usuarios WHERE hierarquia = 1 ";
			
			$retorno_bd = mysqli_query($link,$sql);
			
			if($retorno_bd){
				
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
				}

			}else{
				echo "Houve algum problema ao tentar selecionar os clientes. Entre em contato com o administrador.";
			}
		}

		function selecionaObras(){
			require_once('conexao.php');
			$id_usuario = $_SESSION['id_usuario']; 
				
				$sql ="	SELECT	id_obra,nome_obra,tipo_obra,id_contratante,fim_obra,inicio_obra, DATEDIFF(fim_obra,inicio_obra) as qtd_dias FROM tb_obras WHERE istatus_obra = 0 ";

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$resultado_bd = mysqli_query($link, $sql);
				
				if($resultado_bd){		


					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<h2 style='color:green'>Não há nenhuma obra cadastrada ainda! </h2>";
					}	else{				

						while($obras = mysqli_fetch_array($resultado_bd)){ 


						  // Lógica para determinação do status da obra, se concluida ou em andamento 
						  $status = "";	

				          $datetime1 = date_create(date("Y-m-d"));
						  $datetime2 = date_create($obras['fim_obra']);
				          $interval = date_diff($datetime1, $datetime2);

				          if($interval->format('%R%a days') < 0){
				          	$status = "Obra concluida";
				          } elseif($interval->format('%R%a days') > 0){

					          $datetime1 = date_create(date("d-m-Y"));
							  $datetime2 = date_create($obras['inicio_obra']);
					          $interval = date_diff($datetime1, $datetime2);
						      $dias  = $interval->format('%a');

					          if($interval->format('%R%a days') > 0){
					          	$status = "Faltam $dias dias para começar";
					          } else{
						          $datetime1 = date_create(date("d-m-Y"));
								  $datetime2 = date_create($obras['fim_obra']);
						          $interval = date_diff($datetime1, $datetime2);
						          $dias  = $interval->format('%a');
						          $status = "Faltam $dias dias para terminar";
					          	}
				          	}
				          	// Fim da lógica para determinação do status da obra

						 	$id_contratante = $obras['id_contratante'];
			 				$sql_contratante = " SELECT nome_usuario,sobrenome_usuario FROM tb_usuarios  WHERE id_usuario = $id_contratante ";
							$resultado_bd_contratante = mysqli_query($link, $sql_contratante);
							$nome_contratante = mysqli_fetch_array($resultado_bd_contratante);
							
							echo "<div class='obras-adm'>
                    					<a href='editar_obra.php?cont=$id_contratante&id_obra=".$obras['id_obra']."' style='color:#ccc'> 
                    						<span class='glyphicon glyphicon-edit opcao-editar'></span> 
                    					</a>
										<a href='acompanhamento.php?id_obra=".$obras['id_obra']."' style='color:white'>
	                      					<h3>".$obras['nome_obra']."</h3><br>
		                    				<small> 
						                      <span class='qtd-dias'>".$status." | </span>
						                      <span class='porcentagem-conclusao'>Prazo: ".$obras['qtd_dias']." dias | </span>
						                      <span class='nome-cliente'>Contratante: ".$nome_contratante['nome_usuario']." ".$nome_contratante['sobrenome_usuario']."</span>
						                    </small>
                						</a>
                    				</div>";

						}
					}
				}	
		}

		function selecionaCliente1(){

			echo "string";
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT 
						us.id_usuario, 
						us.nome_usuario,
						us.sobrenome_usuario
					 FROM tb_relacao_usuario_obra rel
					 INNER JOIN tb_usuarios us on rel.id_usuario = us.id_usuario
					 WHERE us.hierarquia = 1 and rel.acesso_id_obra = $id_obra ORDER BY us.id_usuario ASC";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
				}
			}
		}		
		
		function selecionaCliente2(){

			echo "string";
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT 
						us.id_usuario, 
						us.nome_usuario,
						us.sobrenome_usuario
					 FROM tb_relacao_usuario_obra rel
					 INNER JOIN tb_usuarios us on rel.id_usuario = us.id_usuario
					 WHERE us.hierarquia = 1 and rel.acesso_id_obra = $id_obra ORDER BY us.id_usuario DESC ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
				}
			}
		}		

		function selecionaEnderecoObra(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT endereco FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					$endereco = $dados_bd['endereco'];
				}

			}
			return $endereco;
		}	

		function selecionaInicioFim(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT inicio_obra, fim_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){

					echo"<div class='form-group'><label>Início da obra</label><input class='form-control' type='date' name='data_inicio' id='data-inicio' value=\"{$dados_bd['inicio_obra']}\" required ></div><div class='form-group'><label>Fim da obra</label><input class='form-control' type='date' name='data_fim' id='data-fim' value=\"{$dados_bd['fim_obra']}\" required></div>";
				}

			}
		}	

		function selecionaInicio(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT inicio_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){

					$inicio_obra = $dados_bd['inicio_obra'];
				}

			}
			return $inicio_obra;
		}	

		function selecionaFim(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT fim_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){

					$fim_obra = $dados_bd['fim_obra'];
				}

			}
			return $fim_obra;
		}	

		function selecionaEncarregado(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT 
						us.id_usuario, 
						us.nome_usuario,
						us.sobrenome_usuario
					 FROM tb_relacao_usuario_obra rel
					 INNER JOIN tb_usuarios us on rel.id_usuario = us.id_usuario
					 WHERE us.hierarquia = 2 and rel.acesso_id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					$encarregado = $contratante = $dados_bd['id_usuario'];
				}

			}

			return $encarregado;
		}

		function selecionaObrasConcluidas(){
			require_once('conexao.php');
			$id_usuario = $_SESSION['id_usuario']; 
				
				$sql ="	SELECT	id_obra,nome_obra,tipo_obra,id_contratante,fim_obra,inicio_obra, DATEDIFF(fim_obra,inicio_obra) as qtd_dias FROM tb_obras WHERE istatus_obra = 2 ";

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$resultado_bd = mysqli_query($link, $sql);
				
				if($resultado_bd){		


					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<h2 style='color:green'>Não há nenhuma obra cadastrada ainda! </h2>";
					}	else{				

						while($obras = mysqli_fetch_array($resultado_bd)){ 


						  // Lógica para determinação do status da obra, se concluida ou em andamento 
						  $status = "";	

				          $datetime1 = date_create(date("Y-m-d"));
						  $datetime2 = date_create($obras['fim_obra']);
				          $interval = date_diff($datetime1, $datetime2);

				          if($interval->format('%R%a days') < 0){
				          	$status = "Obra concluida";
				          } elseif($interval->format('%R%a days') > 0){

					          $datetime1 = date_create(date("d-m-Y"));
							  $datetime2 = date_create($obras['inicio_obra']);
					          $interval = date_diff($datetime1, $datetime2);
						      $dias  = $interval->format('%a');

					          if($interval->format('%R%a days') > 0){
					          	$status = "Faltam $dias dias para começar";
					          } else{
						          $datetime1 = date_create(date("d-m-Y"));
								  $datetime2 = date_create($obras['fim_obra']);
						          $interval = date_diff($datetime1, $datetime2);
						          $dias  = $interval->format('%a');
						          $status = "Faltam $dias dias para terminar";
					          	}
				          	}
				          	// Fim da lógica para determinação do status da obra

						 	$id_contratante = $obras['id_contratante'];
			 				$sql_contratante = " SELECT nome_usuario,sobrenome_usuario FROM tb_usuarios  WHERE id_usuario = $id_contratante ";
							$resultado_bd_contratante = mysqli_query($link, $sql_contratante);
							$nome_contratante = mysqli_fetch_array($resultado_bd_contratante);
							
							echo "<div class='obras-adm'>

           <form action='classes/restaura_item.php' method='POST'>

                <div class='form-group' style='display: inline-block;'>
                  <input type='hidden' name='id_obra' value=\"{$obras['id_obra']}\">
                  <input type='submit' id='arquiva-obra' name='arquiva_obra' class='btn btn-primary' value='Restaurar Obra'>
                </div>
            </form>	
                    					<a href='editar_obra.php?cont=$id_contratante&id_obra=".$obras['id_obra']."' style='color:#ccc'> 
                    						<span class='glyphicon glyphicon-edit opcao-editar'></span> 
                    					</a>
										<a href='acompanhamento.php?id_obra=".$obras['id_obra']."' style='color:white'>
	                      					<h3>".$obras['nome_obra']."</h3><br>
		                    				<small> 
						                      <span class='qtd-dias'>".$status." | </span>
						                      <span class='porcentagem-conclusao'>Prazo: ".$obras['qtd_dias']." dias | </span>
						                      <span class='nome-cliente'>Contratante: ".$nome_contratante['nome_usuario']." ".$nome_contratante['sobrenome_usuario']."</span>
						                    </small>
                						</a>
                    				</div>";

						}
					}
				}	
		}

		function selecionaObrasArquivadas(){
			require_once('conexao.php');
			$id_usuario = $_SESSION['id_usuario']; 
				
				$sql ="	SELECT	id_obra,nome_obra,tipo_obra,id_contratante,fim_obra,inicio_obra, DATEDIFF(fim_obra,inicio_obra) as qtd_dias FROM tb_obras WHERE istatus_obra = 1 ";

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$resultado_bd = mysqli_query($link, $sql);
				
				if($resultado_bd){		


					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<h2 style='color:green'>Não há nenhuma obra cadastrada ainda! </h2>";
					}	else{				

						while($obras = mysqli_fetch_array($resultado_bd)){ 


						  // Lógica para determinação do status da obra, se concluida ou em andamento 
						  $status = "";	

				          $datetime1 = date_create(date("Y-m-d"));
						  $datetime2 = date_create($obras['fim_obra']);
				          $interval = date_diff($datetime1, $datetime2);

				          if($interval->format('%R%a days') < 0){
				          	$status = "Obra concluida";
				          } elseif($interval->format('%R%a days') > 0){

					          $datetime1 = date_create(date("d-m-Y"));
							  $datetime2 = date_create($obras['inicio_obra']);
					          $interval = date_diff($datetime1, $datetime2);
						      $dias  = $interval->format('%a');

					          if($interval->format('%R%a days') > 0){
					          	$status = "Faltam $dias dias para começar";
					          } else{
						          $datetime1 = date_create(date("d-m-Y"));
								  $datetime2 = date_create($obras['fim_obra']);
						          $interval = date_diff($datetime1, $datetime2);
						          $dias  = $interval->format('%a');
						          $status = "Faltam $dias dias para terminar";
					          	}
				          	}
				          	// Fim da lógica para determinação do status da obra

						 	$id_contratante = $obras['id_contratante'];
			 				$sql_contratante = " SELECT nome_usuario,sobrenome_usuario FROM tb_usuarios  WHERE id_usuario = $id_contratante ";
							$resultado_bd_contratante = mysqli_query($link, $sql_contratante);
							$nome_contratante = mysqli_fetch_array($resultado_bd_contratante);
							
							echo "<div class='obras-adm'>

           <form action='classes/restaura_item.php' method='POST'>

                <div class='form-group' style='display: inline-block;'>
                  <input type='hidden' name='id_obra' value=\"{$obras['id_obra']}\">
                  <input type='submit' id='arquiva-obra' name='arquiva_obra' class='btn btn-primary' value='Restaurar Obra'>
                </div>
            </form>	
                    					<a href='editar_obra.php?cont=$id_contratante&id_obra=".$obras['id_obra']."' style='color:#ccc'> 
                    						<span class='glyphicon glyphicon-edit opcao-editar'></span> 
                    					</a>
										<a href='acompanhamento.php?id_obra=".$obras['id_obra']."' style='color:white'>
	                      					<h3>".$obras['nome_obra']."</h3><br>
		                    				<small> 
						                      <span class='qtd-dias'>".$status." | </span>
						                      <span class='porcentagem-conclusao'>Prazo: ".$obras['qtd_dias']." dias | </span>
						                      <span class='nome-cliente'>Contratante: ".$nome_contratante['nome_usuario']." ".$nome_contratante['sobrenome_usuario']."</span>
						                    </small>
                						</a>
                    				</div>";

						}
					}
				}	
		}
	}
?>