<?php
	
  session_start();
  require_once('conexao.php');
  require_once('select_update_usuario.php');
  
  $objBd = new bd();
  $link  = $objBd->conecta_mysql(); 

  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');


  $id_usuario = $_GET['id_usuario'];

  $nome_usuario 		= $_POST['nome_usuario'];
  $sobrenome_usuario    = $_POST['sobrenome_usuario'];
  $hierarquia  			= $_POST['hierarquia'];
  $email     			= $_POST['email_usuario'];
  $senha  				= $_POST['senha'];
  $remocao     			= $_POST['remocao']; 
  $permissao 			= $_POST['permissao']; 


    if($id_usuario){

        $objUser = new UpdateUsuario();
        $nome_usuario_bd = $objUser->selecionaNomeUsuario($id_usuario);

        if($nome_usuario <> $nome_usuario_bd){
  
            $sql = " UPDATE tb_usuarios SET nome_usuario = '$nome_usuario' WHERE id_usuario=$id_usuario ";

            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              echo "Nome de usuário atualizado";
            }else{
              echo "Não foi possível atualizar o nome de usuário";
              die();
            }            

        }


        $objUser = new UpdateUsuario();
        $sobrenome_usuario_bd = $objUser->selecionaSobrenomeNomeUsuario($id_usuario);

        if($sobrenome_usuario <> $sobrenome_usuario_bd){
  
            $sql = " UPDATE tb_usuarios SET sobrenome_usuario = '$sobrenome_usuario' WHERE id_usuario=$id_usuario ";

            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              echo "Sobrenome de usuário atualizado";
            }else{
              echo "Não foi possível atualizar o sobrenome de usuário";
              die();
            }            

        }

        $objUser = new UpdateUsuario();
        $hierarquia_bd = $objUser->selecionaHierarquia($id_usuario);

        if($hierarquia <> $hierarquia_bd){
  
            $sql = " UPDATE tb_usuarios SET hierarquia = $hierarquia WHERE id_usuario=$id_usuario ";

            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              echo "Hierarquia atualizada";
            }else{
              echo "Não foi possível atualizar a hierarquia de usuário";
              die();
            }            

        }

        $objUser = new UpdateUsuario();
        $email_bd = $objUser->selecionaEmail($id_usuario,$email);

        if($email <> $email_bd){
  
            $sql = " UPDATE tb_usuarios SET email = '$email' WHERE id_usuario=$id_usuario ";

            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              echo "E-mail atualizado";
            }else{
              echo "Não foi possível atualizar email de usuário, entre em contato com o administrador.";
              die();
            }            

        }
        
        if($senha){
			$senha = md5($senha);

			$sql = " UPDATE tb_usuarios SET senha = '$senha' where id_usuario = $id_usuario";

			
			$objBd = new bd();
			$link  = $objBd->conecta_mysql();

			$retorno_bd = mysqli_query($link,$sql);

			if ($retorno_bd) {
				echo "senha alterada!";
			} else{
				echo "Houve um problema ao alterar a senha. Entre em contato com o administrador.";
				die();
			}
        }
        if($remocao){
        
        	$sql = " DELETE FROM tb_relacao_usuario_obra WHERE id_usuario = $id_usuario and acesso_id_obra = $remocao ";
        		
			$objBd = new bd();
			$link  = $objBd->conecta_mysql();

			$retorno_bd = mysqli_query($link,$sql);

			if ($retorno_bd) {
				echo "Acesso removido!";
			} else{
				echo "Houve um problema ao remover a relação usuário-obra. Entre em contato com o administrador.";
				die();
			}
        }

        if($permissao){	        		
        	$sql = " INSERT INTO tb_relacao_usuario_obra(id_usuario,acesso_id_obra)VALUES($id_usuario,$permissao) ";
        		
			$objBd = new bd();
			$link  = $objBd->conecta_mysql();

			$retorno_bd = mysqli_query($link,$sql);

			if ($retorno_bd) {
				echo "Acesso concedido!";
			} else{
				echo "Houve um problema ao criar a relação usuário-obra. Entre em contato com o administrador.";
			}
        }
        header("Location: ../editar_usuario.php?id_usuario=$id_usuario&erro=2");        
    } else{
        header("Location: ../editar_usuario.php?id_usuario=$id_usuario&erro=1");
      }

?>