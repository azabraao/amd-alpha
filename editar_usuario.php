<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  require_once('view.php');
  require_once('classes/controle_usuarios.php');
  $id_usuario = $_GET['id_usuario'];

  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

  switch ($erro) {
    case 1:
          echo "<div class='alert alert-danger'>Houve algum problema ao solicitar as alterações. Entre em contato com o administrador.</div>";
      break;
    case 2:
          echo "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
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
          <a href="usuarios.php">
            <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
          </a>
          <h1>Editar usuário</h1>

           <form action="classes/desativa_usuario.php" method="POST">
                <div class="form-group" style="display: inline-block;">
                  <input type="hidden" name="id_usuario" value="<?= $id_usuario?>">
                  <input type="submit" id="arquiva-obra" name="desativa_usuario" class="btn btn-primary" value="Desativar Usuário">
                </div>
            </form>              
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2" style="margin-top: 100px">
          <form method="POST" action="classes/update_usuario.php?id_usuario=<?php echo $id_usuario?>">

          <div class="col-sm-6">

            <?php
              $objDash = new Controle();
              $objDash->selecionaNomeUsuario();
            ?>

            <div class="form-group">
              <label>Hierarquia</label>
              <select id="tipo-obra" class="form-control" name="hierarquia">
              <?php
                $objDash = new Controle();
                $objDash->selecionaHierarquia();
              ?>
              </select>
            </div>
            <div class="form-group">
                <?php
                  $objDash = new Controle();
                  $objDash->selecionaEmail();
                ?>
            </div>
          </div>
          <div class="col-sm-6">

            <div class="form-group">
              <label for="senha">Nova senha:</label>
              <input id="senha" type="text" name="senha" placeholder="nova senha" class="form-control">
            </div>
            <div class="form-group">
              <label>Obras dele(a):</label>
              <select id="tipo-obra" class="form-control" name="obras">
                <?php
                  $objDash = new Controle();
                  $objDash->selecionaObras();
                ?>
              </select>
            </div>

            <div class="form-group">
              <label>Remover acesso:</label>
              <select id="tipo-obra" class="form-control" name="remocao">
                <option value="0">Selecione</option>
                <?php
                  $objDash = new Controle();
                  $objDash->selecionaObras();
                ?>
              </select>
            </div>

            <div class="form-group">
              <label>Dar acesso:</label>
              <select id="tipo-obra" class="form-control" name="permissao">
                <option value="0">Selecione</option>
                <?php
                  $objDash = new Controle();
                  $objDash->selecionaTodasObras();
                ?>
              </select>
            </div>

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