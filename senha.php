<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  require_once('view.php');

  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
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
          <a href="ocorrencias.php">
            <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
          </a>
          <h1>Trocando Senha</h1>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-4" style="margin-top: 100px">
          <form method="POST" action="classes/alterar_senha.php">
            <div class="form-group">
              <input type="password" name="senha-antiga" placeholder="senha antiga" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="password" name="senha-nova" placeholder="Senha nova" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="password" name="senha-nova-repeticao" placeholder="Repita" class="form-control" required>
            </div> 

            <?php
              switch ($erro) {
                case 1:
                  echo "<div class='alert alert-danger'>Senha antiga está errada</div>";
                  break;
                case 2:
                  echo "<div class='alert alert-danger'>Senhas novas não batem</div>";
                  break;
                default:
                   break;
              }
            ?>
            <div class="form-group">
              <button type="submit" class="btn btn-danger btn-block">salvar</button>
            </div>                       
          </form>
        </div>
      </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>