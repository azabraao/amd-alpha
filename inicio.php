<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  require_once("view.php");
  require_once("classes/seleciona_obras.php");

  
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

    <!-- Topo e menu -->
    <?php
      $objHeader = new site(); 
      $objHeader->nav();
    ?>
    <!-- /Topo e menu -->

    <!-- Exposição das obras -->
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3 titulo-sobre-obras">
          <h1>Suas Obras</h1>
        </div>

        <div class="col-sm-6 col-sm-offset-3 sobre-obras">
            <?php
                $objObras = new Obras();
                $objObras->selecionaObras();                     
            ?>
        </div>
      </div>
    </div>
    <!-- /Exposição das obras -->

    <!-- Botão novo orçamento -->
    <div class="container">
      <div class="row">
          <div class="novo-orcamento">
            <button class="btn btn-danger" id="btn">Novo Orçamento</button>
          </div>
      </div>
    </div>
    <!-- /Botão novo orçamento -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <!--  <script type="text/javascript">
      $(document).ready(function(){
          $('#btn').click(function(){
            $.ajax({
              url: 'www.google.com',
              method: 'post',
              data: 'id_obra=1',

              success: function(data){

              }
            });
          });
        });
    </script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>