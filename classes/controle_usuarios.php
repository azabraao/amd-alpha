<?php

	class Controle{

		function selecionaNomeUsuario(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_usuario = $_GET['id_usuario'];

			$sql = " SELECT nome_usuario, sobrenome_usuario FROM tb_usuarios WHERE id_usuario = $id_usuario ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo "<label>Nome do usuario:</label><div class='form-group'><input type='text' name='nome_usuario' placeholder='Nome do usuário' class='form-control' required value=\"{$dados_bd['nome_usuario']}\"></div> ";
					echo "<label>Sobrenome do usuario:</label><div class='form-group'><input type='text' name='sobrenome_usuario' placeholder='Sobrenome do usuário' class='form-control' required value=\"{$dados_bd['sobrenome_usuario']}\"></div> ";					
				}

			}
		}

		function selecionaHierarquia(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_usuario= $_GET['id_usuario'];
			
			$sql = " SELECT hierarquia FROM tb_usuarios WHERE id_usuario = $id_usuario ";
			
			$retorno_bd = mysqli_query($link,$sql);
			
			if($retorno_bd){
				
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					switch ($dados_bd['hierarquia']) {
						case 1:
							echo " <option value=".$dados_bd['hierarquia'].">Cliente</option> ";
							break;
						case 2:
							echo " <option value=".$dados_bd['hierarquia'].">Funcionário</option> ";
							break;
						case 3:
							echo " <option value=".$dados_bd['hierarquia'].">Administrador</option> ";
							break;
					}

					echo " <option value='1'>Cliente</option><option value='2'>Funcionário</option><option value='3'>Administrador</option> ";
				}

			}else{
				echo "Houve algum problema ao tentar selecionar hierarquia. Entre em contato com o administrador.";
			}
		}

		function selecionaEmail(){
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_usuario = $_GET['id_usuario'];

			$sql = " SELECT email FROM tb_usuarios WHERE id_usuario = $id_usuario ";

			$retorno_bd = mysqli_query($link,$sql);

			if($retorno_bd){
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){
					echo "<label>Email:</label><div class='form-group'><input type='email' name='email_usuario' placeholder='Email do usuário' class='form-control' required value=\"{$dados_bd['email']}\"></div> ";				
				}

			}
		}

		function selecionaObras(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_usuario= $_GET['id_usuario'];
			
			$sql = " SELECT 
						rel.acesso_id_obra as acesso,
					    o.nome_obra as nome_obra,
					    o.id_obra as id_obra

					FROM tb_relacao_usuario_obra rel
					INNER JOIN tb_obras o on o.id_obra = rel.acesso_id_obra

					WHERE id_usuario = $id_usuario and o.istatus_obra = 0";
			
			$retorno_bd = mysqli_query($link,$sql);
			
			if($retorno_bd){
				
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){

					echo " <option value='".$dados_bd['id_obra']."'>".$dados_bd['nome_obra']."</option>";
				}

			}else{
				echo "Houve algum problema ao tentar selecionar as obras. Entre em contato com o administrador.";
			}
		}

		function selecionaTodasObras(){
			
			require_once('conexao.php');
			$objBd = new bd();
			$link  = $objBd->conecta_mysql(); 

			$id_usuario= $_GET['id_usuario'];
			
			$sql = " SELECT 
					    nome_obra,
					    id_obra

					FROM tb_obras
					WHERE istatus_obra = 0 ";
			
			$retorno_bd = mysqli_query($link,$sql);
			
			if($retorno_bd){
				
				while($dados_bd	= mysqli_fetch_array($retorno_bd)){

					echo " <option value='".$dados_bd['id_obra']."'>".$dados_bd['nome_obra']."</option>";
				}

			}else{
				echo "Houve algum problema ao tentar selecionar as obras. Entre em contato com o administrador.";
			}
		}

		function selecionaUsuariosDesativados(){
			require_once('conexao.php');
			$id_usuario = $_SESSION['id_usuario']; 
				
				$sql ="	SELECT	id_usuario,nome_usuario,sobrenome_usuario,hierarquia,email FROM tb_usuarios WHERE istatus_usuario = 1 ";

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
							
							echo "
							<div class='dados_usuario-adm obras-adm'>
						           <form action='classes/restaura_usuario.php' method='POST'>
						                <div class='form-group' style='display: inline-block;'>
						                  <input type='hidden' name='id_usuario' value=\"{$dados_usuario['id_usuario']}\">
						                  <input type='submit' id='arquiva-obra' name='arquiva_obra' class='btn btn-primary' value='Restaurar Usuário'>
						                </div>
						            </form>	
                    					<a href='editar_usuario.php?id_usuario=".$dados_usuario['id_usuario']."' style='color:#ccc'> 
                    						<span class='glyphicon glyphicon-edit opcao-editar'></span> 
                    					</a>
	                      					<h3>".$dados_usuario['nome_usuario']." ".$dados_usuario['sobrenome_usuario']."</h3><br>
		                    				<small> 
						                      <span class='qtd-dias'>hierarquia: ".$hierarquia." | </span>
						                      <span class='porcentagem-conclusao'>Email: ".$dados_usuario['email']."</span>
						                    </small>
                    				</div>";

						}
					}
				}	
		}
	
	}
	
?>