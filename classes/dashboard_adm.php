<?php
	
	class Dashboard{

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

		function selecionaNomeObra(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_obra = $_GET['id_obra'];

			$sql = " SELECT nome_obra FROM tb_obras WHERE id_obra = $id_obra ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo "<label>Nome da obra:</label><div class='form-group'><input type='text' name='nome_obra' placeholder='Nome da obra' class='form-control' required value=\"{$dados_bd['nome_obra']}\"></div> ";
				}

			}
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
					switch ($dados_bd['tipo_obra']) {
						case 1:
							echo "<option value='1' selected>Pequeno porte</option><option value='2'>Médio porte</option><option value='3' >Grande porte</option>";
							break;
						case 2:
							echo "<option value='1'>Pequeno porte</option><option value='2' selected>Médio porte</option><option value='3' >Grande porte</option>";						
							break;
						case 3:
							echo "<option value='1'>Pequeno porte</option><option value='2'>Médio porte</option><option value='3' selected>Grande porte</option>";						
							break;
					}
				}

			} 
		}	

		function selecionaContratante($id_contratante){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$sql_contratante = " SELECT id_usuario,nome_usuario,sobrenome_usuario FROM tb_usuarios ";
			$resultado_bd_contratante = mysqli_query($link, $sql_contratante);

			if($resultado_bd_contratante){
				
				while($dados_bd = mysqli_fetch_array($resultado_bd_contratante)){
					if ($dados_bd['id_usuario'] == $id_contratante) {
						echo " <option value=".$dados_bd['id_usuario']." selected>".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
					} else{
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
					echo "$id_contratante";
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
					echo "<label>Endereço:</label><div class='form-group'><input type='text' name='endereco_obra' placeholder='Nome da obra' class='form-control' required value=\"{$dados_bd['endereco']}\"></div> ";
				}

			}
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
					echo " <option value=".$dados_bd['id_usuario'].">".$dados_bd['nome_usuario']." ".$dados_bd['sobrenome_usuario']."</option> ";
				}

			}
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

		function selecionaUsuarios(){
			require_once('conexao.php');
			$id_usuario = $_SESSION['id_usuario']; 
				
				$sql ="	SELECT	id_usuario,nome_usuario,sobrenome_usuario,hierarquia,email FROM tb_usuarios WHERE istatus_usuario = 0 ";

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$resultado_bd = mysqli_query($link, $sql);
				
				if($resultado_bd){		


					$qtd =  mysqli_num_rows($resultado_bd);

					if ($qtd == 0) {
						echo "<h2 style='color:green'>Não há nenhuma usuário cadastrado ainda! </h2>";
					}	else{				

						while($dados_usuario = mysqli_fetch_array($resultado_bd)){

							switch ($dados_usuario['hierarquia']) {
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
							
							echo "<div class='dados_usuario-adm obras-adm'>
                    					<a href='editar_usuario.php?id_usuario=".$dados_usuario['id_usuario']."' style='color:#ccc'> 
                    						<span class='glyphicon glyphicon-edit opcao-editar'></span> 
                    					</a>
	                      					<h3>".$dados_usuario['nome_usuario']." ".$dados_usuario['sobrenome_usuario']."</h3><br>
		                    				<small> 
						                      <span class='qtd-dias'>hierarquia: ".$hierarquia." | </span>
						                      <span class='porcentagem-conclusao'>email: ".$dados_usuario['email']."</span>
						                    </small>
                    				</div>";

						}
					}
				}	
		}

	}
?>