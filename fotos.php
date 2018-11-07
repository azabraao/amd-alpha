<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  require_once('view.php');
  require_once('classes/seleciona_imagens.php');
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
          <a href="acompanhamento.php?id_obra=<?=$_SESSION['id_obra']?>">
            <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
          </a>
          <h1>Fotos</h1>
        </div>
      </div>
    </div>

  <!-- Carrosel de imagens -->
  
    <div class="container">
      <div class="row"> 

          <div class="col-xs-12 col-sm-8 col-sm-offset-2" id="imagens">
            
          <ul>
            <?php
              $objImg = new Imagens();
              $objImg->selecionaImagens();
            ?>
          </ul>

            <a href="#" id="ant"><span class="glyphicon glyphicon-chevron-left"></span></a>

          <!-- <span id="pager"></span> Marca as páginas, não precisamos agora.-->

            <a href="#" id="prox"><span class="glyphicon glyphicon-chevron-right"></span></a>

          </div> <!-- /#imagens -->

      </div>
    </div>
  <!-- /Carrosel de imagens -->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --><!-- 
    <script src="jquery/jquery.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/jcycle.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>