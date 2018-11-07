<?php
    
    session_start();

    $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
    $flag = isset($_GET['flag']) ? $_GET['flag'] : 0;
    if(isset($_SESSION['email']))header("Location: inicio.php");
      
    if(isset($_SESSION['hierarquia'])){
      $hierarquia = $_SESSION['hierarquia'];

      if ($hierarquia == 1 || $hierarquia == 2) {
        header('Location: inicio.php');        
      } else{
        header('Location: dashboard.php');
      }

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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <section id="fundo">
    <div id="hover-fundo">
    </div>
  </section>

    <nav class="nav navbar-default" id="topo">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">AMD Alpha</a>
        </div>
      </div>
    </nav>


    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1" id="box-login">
          <!-- header login -->
          <div id="box-login-header">
            <img src="img/logo.png" class="img-responsive">
          </div>
          <!-- /header login -->
          <!-- form login -->
          <form action="classes/valida_login.php" method="POST">
            <div class="form-group">
              <input type="text" name="email" placeholder="e-mail" class="form-control" autofocus>
            </div>
            <div class="form-group">
              <input type="password" name="senha" placeholder="senha" class="form-control">
            </div>
            <div class="form-group">
              <input type="submit" name="enviar" value="entrar" class="btn btn-block" id="btn-login">  
            </div>
            <?php
                if($erro == 1){
                    echo "usuário ou senha inválidos";
                } elseif ($flag == 3) {
                    echo "Entre com sua nova senha";
                }
            ?>
          </form>
          <!-- /form login -->
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>