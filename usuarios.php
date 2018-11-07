<?php
  session_start();

  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');
  require_once('view.php');
  require_once('classes/dashboard_adm.php');

  $flag      = isset($_GET['flag']) ? $_GET['flag'] : 0;
  $flag_us   = isset($_GET['flag_us']) ? $_GET['flag_us'] : 0;
  $flag_obra = isset($_GET['flag_obra']) ? $_GET['flag_obra'] : 0;

  switch ($flag_obra) {
  case 1:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sucesso!</strong> usuário reativado </div>"; 
  case 2:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Usuário desativado com sucesso. </div>"; 
    break;
  }

  if ($flag_us == 1) {
      echo "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Nâo foi possível criar a relação usuário-obra. Entre em contato com o adminitrador.</div>";
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
    <link rel="stylesheet" type="text/css" href="css/estilo.css?atualiza=novo1">
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

          <!-- Exposição dos usuários -->
          <div class="col-sm-8">
              <div class="col-sm-12 titulo-sobre-obras">
                <a href="dashboard.php">
                  <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
                </a>
                <h1>Usuários</h1>
              </div>
              <div class="col-sm-12 sobre-obras-adm">
                <?php
                  $objDash = new Dashboard();
                  $objDash->selecionaUsuarios();
                ?>
              </div>
          </div>
          <!-- /Exposição dos usuários -->

        <div class="col-sm-3 col-sm-offset-1 col-xs-12 sobre-obras-adm" id="acoes-adm">

          <h1>Ações</h1>

          <!-- aciona novo relatório -->
          <a href="usuarios_desativados.php">
            <div class="clearfix box-info sobre-obras-adm" id="new-user">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Usuários desativados</span>
              </div>
            </div>
          </a>
          <!-- /aciona novo relatório -->

        </div>
      
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        $('.obras-adm').mouseover(function(){
          $('.opcao-editar').show();
        });
        $('.obras-adm').mouseout(function(){
          $('.opcao-editar').hide();
        });
      });
    </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>