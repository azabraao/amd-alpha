<?php
  session_start();

  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');
  if(isset($_SESSION['hierarquia'])){
    if($_SESSION['hierarquia'] != 3){
      header("Location: inicio.php");
    }
  }

  require_once('view.php');
  require_once('classes/dashboard_adm.php');

  $flag      = isset($_GET['flag']) ? $_GET['flag'] : 0;
  $flag_us   = isset($_GET['flag_us']) ? $_GET['flag_us'] : 0;
  $flag_obra = isset($_GET['flag_obra']) ? $_GET['flag_obra'] : 0;

  switch ($flag_obra) {
  case 1:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sucesso!</strong> obra inserida. </div>";            
    break;
  case 2:
      echo "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Que coisa!</strong> essa obra não pôde ser inserida. Entre em contato com o administrador.</div>";
    break;
  case 3:
      echo "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Não é possível inserir os mesmos clientes na mesma obra</div>";
    break;
  case 4:
      echo "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Uma obra não pode começar depois do fim dela mesma.</div>";  
    break;
  case 5:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Obra arquivada com sucesso.</div>";    
    break;
  case 6:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Obra marcada como concluida com sucesso.</div>";    
    break;
  case 7:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Obra reataurada com sucesso.</div>";    
    break;
  case 8:
      echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Usuário desativado com sucesso.</div>";      
    break;
  default:

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
    <link rel="stylesheet" type="text/css" href="css/estilo.css?atualiza=novo2">
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

          <!-- Exposição das obras -->
          <div class="col-sm-8">
              <div class="col-sm-12 titulo-sobre-obras">
                <h1>Em andamento</h1>
              </div>

              <div class="col-sm-12 sobre-obras-adm">
                <?php
                  $objDash = new Dashboard();
                  $objDash->selecionaObras();
                ?>
              </div>
          </div>
          <!-- /Exposição das obras -->


        <!-- Ações à direita e informações gerais -->
 
        <div class="col-sm-3 col-sm-offset-1 col-xs-12 sobre-obras-adm" id="acoes-adm">

          <h1>Ações</h1>

    <?php
    switch ($flag) {
      case 1:
          echo "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Que coisa!</strong> esse e-mail já está cadastrado. Insira outro.</div>";
        break;
      case 2:
          echo "<div class='alert alert-warning'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Que coisa!</strong> essa obra já está cadastrada. Dê outro nome.</div>";      
        break;
      case 3:
          echo "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Sucesso!</strong> </div>";            
        break;
      default:

        break;
    }

    ?>          
          <!-- aciona novo relatório -->
          <a href="" data-toggle="modal" data-target="#modal-usuario">
            <div class="clearfix box-info sobre-obras-adm" id="new-user">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Novo usuário</span>
              </div>
            </div>
          </a>
          <!-- /aciona novo relatório -->

          <a href="" data-toggle="modal" data-target="#modal-obra">
            <div class="clearfix box-info" id="new-work">
              <div class="col-sm-4 col-xs-4 center" >
                <span class="glyphicon glyphicon-plus"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Nova obra</span>
              </div>
            </div>
          </a>
          <!-- puxa reports postergado-->
            <!-- <div class="clearfix box-info" id="general-report">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-file"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Relatório</span>
              </div>
            </div> -->
          <!-- /puxa reports -->
          <!-- Listar obras concluidas postergado -->
          <a href="obras_concluidas.php">
            <div class="clearfix box-info" id="obras-concluidas">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-ok"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Obras concluidas</span>
              </div>
            </div>
          </a>  
          <!-- /Listar obras concluidas -->
          <!-- Listar obras arquivadas -->
          <a href="obras_arquivadas.php">
            <div class="clearfix box-info" id="obras-arquivadas">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-folder-close"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Obras arquivadas</span>
              </div>
            </div>
          </a>
          <!-- /Listar obras arquivadas -->
          <!-- Listar usuários -->
          <a href="usuarios.php">
            <div class="clearfix box-info" id="general-report">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Controle de Usuários</span>
              </div>
            </div>
          </a>
          <!-- /Listar usuários -->

        </div>
        <!-- /Ações à direita e informações gerais -->

        <!-- Novo usuário -->
          <form class="modal fade " id="modal-usuario" method="post" action="classes/novo_usuario.php">
              <div class="modal-dialog modal-sm-12">
                <div class="modal-content">
                  <!--cabeçalho -->
                  <div class="modal-header">  
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Novo usuário</h3>
                  </div>
                  <!--corpo -->
                  <div class="modal-body">  
                  
                      <div class="form-group">
                        <label for="hierarquia">Hierarquia</label>
                        <select class="form-control" name="hierarquia" required>
                          <option value="1">Cliente</option>
                          <option value="2">Funcionário</option>
                          <option value="3">Administrador</option>
                        </select>
                      </div>

                      <div class="form-group">
                          <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                      </div>

                      <div class="form-group">
                          <input type="text" class="form-control" placeholder="Sobrenome" name="sobrenome">
                      </div>

                      <div class="form-group">
                          <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                      </div>
                      <div class="form-group">
                          <input type="text" class="form-control" placeholder="Senha" name="senha" required>
                      </div>
                  </div>

                  <!--rodapé -->
                  <div class="modal-footer">  
                      <button type="submit" class="btn btn-danger btn-block">salvar</button>
                  </div>
                </div>
              </div>
          </form>
        <!-- /Novo usuário -->

        <!-- Nova obra -->
          <form class="modal fade " id="modal-obra" method="post" action="classes/insere_obra.php">
              <div class="modal-dialog modal-sm-12">
                <div class="modal-content">
                  <!--cabeçalho -->
                  <div class="modal-header">  
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Nova obra</h3>
                  </div>

                  <!--corpo -->
                  <div class="modal-body">  
                  
                    <div class="form-group">
                      <label for="tipo">Tipo</label>
                      <select class="form-control" id="tipo" name="tipo_obra" >
                        <option value="1">Pequeno porte</option>
                        <option value="2">Médio porte</option>
                        <option value="3">Grande porte</option>
                      </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Endereço" name="endereco" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Título da obra" name="titulo_obra" required>
                    </div>

                    <div class="form-group">
                      <label>Inicio da obra:</label>
                        <input type="date" class="form-control" name="inicio_obra" required>
                    </div>

                    <div class="form-group">
                      <label>Fim da obra:</label>
                        <input type="date" class="form-control" name="fim_obra" required>
                    </div>

                    <div class="form-group">
                        <label>Cliente 1</label>
                        <select class="form-control" id="cliente" name="id_cliente1" required>
                         <option value="0">Selecione</option>
                         <?php
                            $objCli = new Dashboard();
                            $objCli->clientes();
                         ?>                          
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cliente 2</label>
                        <select class="form-control" id="cliente" name="id_cliente2" required>
                         <option value="0">Selecione</option>
                         <?php
                            $objCli = new Dashboard();
                            $objCli->clientes();
                         ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contratante</label>
                        <select class="form-control" id="cliente" name="id_contratante" required>
                         <option value="0">Selecione</option>
                         <?php
                            $objCli = new Dashboard();
                            $objCli->clientes();
                         ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Funcionário</label>
                        <select class="form-control" id="cliente" name="id_funcionario" required>
                         <option value="0">Selecione</option>
                         <?php
                            $objCli = new Dashboard();
                            $objCli->funcionario();
                         ?>
                        </select>
                    </div>
                  <!--rodapé -->
                  <div class="modal-footer">  
                      <button type="submit" class="btn btn-danger btn-block">salvar</button>
                  </div>
                </div>
              </div>
          </form>
        <!-- /Nova obra -->
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