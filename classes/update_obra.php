<?php
	
  session_start();
  require_once('conexao.php');
  require_once('select_update_obra.php');
  
  $objBd = new bd();
  $link  = $objBd->conecta_mysql(); 

  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');


  $id_obra = $_GET['id_obra'];

  $nome_obra    = $_POST['nome_obra'];
  $tipo_obra    = $_POST['tipo_obra'];
  $nome_contratante  = $_POST['contratante_obra'];
  $endereco     = $_POST['endereco_obra'];
  $data_inicio  = $_POST['data_inicio'];
  $data_fim     = $_POST['data_fim']; 


  $flag_nome_obra         = 0;
  $flag_tipo_obra         = 0;
  $flag_nome_contratante  = 0;
  $flag_endereco          = 0;
  $flag_inicio_obra       = 0;
  $flag_fim_obra          = 0;



        
if ($data_inicio > $data_fim) {
    echo "Uma obra não pode começar depois do fim dela mesma.";
    header("Location: ../editar_obra.php?id_obra=$id_obra&cont=$id_contratante&erro=3"); 
  die();
}

    if($id_obra){

        $objDash = new Update();
        $nome_obra_bd = $objDash->selecionaNomeObra();

        if($nome_obra <> $nome_obra_bd){
  
            $sql = " UPDATE tb_obras SET nome_obra = '$nome_obra' WHERE id_obra=$id_obra ";

            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_nome_obra = 0;
            }else{
              $flag_nome_obra = 1;
            }            

        }


        $objDash = new Update();
        $tipo_obra_bd = $objDash->selecionaTipoObra();

        if($tipo_obra <> $tipo_obra_bd){

            $sql = " UPDATE tb_obras SET tipo_obra = $tipo_obra WHERE id_obra=$id_obra ";
            
            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_tipo_obra = 0;
            }else{
              $flag_tipo_obra = 1;
            }            

        }
        
        
        $objDash = new Update();
        $nome_contratante_bd = $objDash->selecionaContratante($id_obra);
        $id_contratante = $nome_contratante_bd;

        if($nome_contratante <> $nome_contratante_bd){

            $sql = " UPDATE tb_obras SET id_contratante = $nome_contratante WHERE id_obra=$id_obra ";
            
            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_nome_contratante = 0;
              $nome_contratante_bd = $objDash->selecionaContratante($id_obra);
              $id_contratante = $nome_contratante_bd;
            }else{
              $flag_nome_contratante = 1;
            }            

        }

        $objDash = new Update();
        $endereco_bd = $objDash->selecionaEnderecoObra();
    

        if($endereco <> $endereco_bd){
           
            $sql = " UPDATE tb_obras SET endereco = '$endereco' WHERE id_obra=$id_obra ";
            
            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_endereco = 0;
            }else{
              $flag_endereco = 1;
            }   
        }

        $objDash = new Update();
        $data_inicio_bd = $objDash->selecionaInicio();

        if($data_inicio <> $data_inicio_bd){
           
            $sql = " UPDATE tb_obras SET inicio_obra = '$data_inicio' WHERE id_obra=$id_obra ";
            
            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_inicio_obra = 0;
            }else{
              $flag_inicio_obra = 1;
            }  
        }


        $objDash = new Update();
        $data_fim_bd = $objDash->selecionaFim();
    
        if($data_fim <> $data_fim_bd){
           
            $sql = " UPDATE tb_obras SET fim_obra = '$data_fim' WHERE id_obra=$id_obra ";
            
            $retorno_bd = mysqli_query($link,$sql);
            
            if($retorno_bd){
              $flag_fim_obra = 0;
            }else{
              $flag_fim_obra = 1;
            }  
        }
        header("Location: ../editar_obra.php?id_obra=$id_obra&cont=$id_contratante&erro=2");        
    } else{
        header("Location: ../editar_obra.php?id_obra=$id_obra&cont=$id_contratante&erro=1");
      }

?>