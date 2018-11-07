<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  require_once('view.php');
  require_once('classes/dashboard_adm.php');
  $id_obra = $_GET['id_obra'];
  $id_contratante = $_GET['cont'];

  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

  switch ($erro) {
    case 1:
          echo "<div class='alert alert-danger'>Houve algum problema ao solicitar as alterações. Entre em contato com o administrador.</div>";
      break;
    case 2:
          echo "<div class='alert alert-success'>Obra atualizada com sucesso!</div>";
      break;
    case 3:
          echo "<div class='alert alert-danger'>Uma obra não pode começar depois do fim dela mesma.</div>";
      break;
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>AMD Alpha</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <!-- Jquery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="controles.js"></script>    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>



    <!-- Topo e menu -->
    <?php
      $objHeader = new site(); 
      $objHeader->nav();
    ?>
    <!-- /Topo e menu -->

    <div class="container">
      <div class="row">
        <div class="col-sm-12" id="header-acompanhamento">
          <a href="dashboard.php">
            <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
          </a>
          <h1>Alterar dados da obra</h1>

           <form action="classes/arquiva-item.php" method="POST">

                <div class="form-group" style="display: inline-block;">
                  <input type="hidden" name="id_obra" value="<?= $id_obra?>">
                  <input type="submit" id="arquiva-obra" name="arquiva_obra" class="btn btn-primary" value="Arquivar Obra">
                </div>
            </form>
           <form action="classes/conclui_obra.php" method="POST">
                <div class="form-group" style="display: inline-block;">
                  <input type="hidden" name="id_obra" value="<?= $id_obra?>">
                  <input type="submit" id="conclui-obra" name="conclui_obra" class="btn btn-success" value="Concluir Obra">
                </div>
            </form>
              
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2" style="margin-top: 100px">
          <form method="POST" action="classes/update_obra.php?id_obra=<?php echo $id_obra?>&cont=<?php echo $id_contratante?>">

          <div class="col-sm-6">

            <?php
              $objDash = new Dashboard();
              $objDash->selecionaNomeObra();
            ?>

            <div class="form-group">
              <label>Tipo da obra</label>
              <select id="tipo-obra" class="form-control" name="tipo_obra">
              <?php
                $objDash = new Dashboard();
                $objDash->selecionaTipoObra();
              ?>
              </select>
            </div>
            <div class="form-group">
              <label>Contratante</label>
              <select id="contratante-obra" class="form-control" name="contratante_obra">
                <?php
                  $objDash = new Dashboard();
                  $objDash->selecionaContratante($id_contratante);
                ?>
              </select>
            </div> 

        <!-- 
          Aqui antes estava selecionado o funcionário encarregado, funcionalidade que foi removida dessa sessão por ter nível de complexidade um pouco mais elevado de se modificar. Decidi tratar os níveis de acesso ou permissionamento em uma sessão específica para usuários. 
        -->            

        <!-- 
          Aqui antes estava selecionado os clientes 1 e 2, porém essa alteração no banco me foi difícil de fazer e a funcionalidade foi adiada.
        -->
          
          </div>
          <div class="col-sm-6">

            <div class="form-group">
              <?php
                $objDash = new Dashboard();
                $objDash->selecionaEnderecoObra();
              ?>
            </div>

              <?php
                $objDash = new Dashboard();
                $objDash->selecionaInicioFim();
              ?>  
          </div>

            <div class="form-group">
              <button type="submit" class="btn btn-danger btn-block">salvar</button>
            </div>                       
          </form>

        </div>
      </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script type="text/javascript">

            // function arquivaObra(e){

            //     dados = {
            //         id : $(this).data('id')
            //     };

            //     $.ajax({
            //         url            : "arquiva-item.php",
            //         method         : "POST",
            //         data           : dados,

            //         success: function(data){
            //           console.log(data);
            //         } 
            //     });
            // } 

    </script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>