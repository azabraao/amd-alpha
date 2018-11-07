<?php
  session_start();
  if(!isset($_SESSION['email'])) header('Location: index.php?erro=1');

  $hierarquia = $_SESSION['hierarquia'];

  require_once('view.php');
  require_once('classes/seleciona_obras.php');
  require_once('classes/acompanhamento_obra.php');
  $_SESSION["id_obra"] = $_GET['id_obra'];

  require_once('classes/valida_session.php');
  $objValida = new Session();
  $objValida->validaSessao($_SESSION['id_usuario'], $_GET['id_obra']);

  $objAcomp = new acompanhamento();
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
    <link rel="stylesheet" type="text/css" href="css/estilo.css?ha=3">
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
          
        <?php
          if($_SESSION['hierarquia'] == 3){
        ?>
          <a href="dashboard.php">
        <?php
          } else{
        ?>
          <a href="inicio.php">
        <?php
          }
        ?>
            <span class="glyphicon glyphicon-arrow-left" id="seta-voltar"></span>
          </a>
          <h1>
          <?php
            $objTit = new acompanhamento();
            $objTit->titulo();
          ?></h1>
          <span class="glyphicon glyphicon-info-sign" id="info-icon" data-element="#acoes"></span>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-8" id="over-mensagens">
            <!-- Mensagens -->
              <center><input type="button" id="btn-carrega-msg" class="btn btn-default" value="carregar mais mensagens" style="margin-bottom: 10px"></center>
            <div class="col-sm-12" id="mensagens">
            </div>
            <!-- /Mensagens -->

            <div class="col-sm-12 col-xs-12" id="over-send-msg">
              <!-- Form de submissão de mensagem -->
                <form id="form_msg" >
                  <div class="input-group">
                    <input type="text" name="mensagem" class="form-control" id="input-txt" placeholder="Escreva algo..." required>
                    <span class="input-group-btn">
                      <!-- <button type="button" class="btn btn-danger" id="btn-send" ><span class="glyphicon glyphicon-send"></span></button> -->
                      <button class="btn btn-danger" id="btn-send" type="button">Enviar</button>
                    </span>                    
                  </div>
                </form>
              <!--  /Form de submissão de mensagem -->
            </div>
        </div>



        <!-- Ações à direita e informações gerais -->
        <div class="col-sm-3 col-sm-offset-1 col-xs-12" id="acoes">

              <?php
                $objTit->inicioFim();
              ?>

          <a href="fotos.php">
            <div class="clearfix box-info">
              <div class="col-sm-4 col-xs-4 center">
                <?php
                  $objAcomp->countImagens();
                ?>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Fotos</span>
              </div>
            </div>
          </a>


          <a href="ocorrencias.php">
            <div class="clearfix box-info">
              <div class="col-sm-4 col-xs-4 center">
                <?php
                  $objAcomp->countOcorrencias();
                ?>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Ocorrências</span>
              </div>
            </div>
          </a>
          <a href="relatorios.php">
            <div class="clearfix box-info">
              <div class="col-sm-4 col-xs-4 center">
                <?php
                  $objAcomp->countRelatorios();
                ?>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Relatórios</span>
              </div>
            </div>
          </a>
          <!-- aciona novo relatório -->
          
          <?php
            if($hierarquia == 2 || $hierarquia == 3){
          ?>

          <a href="" data-toggle="modal" data-target="#modal-relatorio">
            <div class="clearfix box-info">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-file"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Novo relatório</span>
              </div>
            </div>
          </a>
          <!-- /aciona novo relatório -->
          <div class="clearfix box-info">
            <div class="col-sm-4 col-xs-4 center">
              <span class="glyphicon glyphicon-picture"></span>
            </div>
            <div class="col-sm-8 col-xs-8 center">
              <span class="coisa">
              <form id="form-img" method="post" action="classes/insere_imagens.php" enctype="multipart/form-data">
                <label>Nova imagem <input type="file" style="display: none;" name="arquivo" id="input-img">
                </label>
                <input type="submit" name="sbmt-img" class="btn btn-default" id="btn-sbmt-img" style="display: none">
              </form>
              </span>
            </div>
          </div>
          <!-- Aciona nova ocorrência -->
          <a href="" data-toggle="modal" data-target="#modal-ocorrencia">
            <div class="clearfix box-info">
              <div class="col-sm-4 col-xs-4 center">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
              </div>
              <div class="col-sm-8 col-xs-8 center">
                <span class="coisa">Nova ocorrência</span>
              </div>
            </div>
            </a>

            <div class="panel panel-info">
              <div class="panel-heading">
                Nesta obra:
              </div>
              <div class="panel-body">
                <?php
                   $objAcomp->selecionaClientesInfo();
                ?>
              </div>
            </div>

            <?php
                 }
            ?>

          <!-- /Aciona nova ocorrência -->
        </div>
        <!-- /Ações à direita e informações gerais -->

        <!-- Novo relatório -->
          <form class="modal fade " id="modal-relatorio" method="POST" action="classes/insere_relatorios.php">
              <div class="modal-dialog modal-sm-12">
                <div class="modal-content">
                  <!--cabeçalho -->
                  <div class="modal-header">  
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Novo relatório</h3>
                  </div>

                  <!--corpo -->
                  <div class="modal-body">  

                    <div class="form-group">
                      <textarea class="form-control" rows="4" placeholder="Atividades executadas" name="atividades"></textarea>
                    </div>

                    <label for="tempo">Tempo:</label>
                    <select class="form-control" id="tempo" name="tempo">
                      <option value="Nublado">Nublado</option>
                      <option value="Ensolarado">Ensolarado</option>
                      <option value="Chuvoso">Chuvoso</option>
                      <option value="Tempestuoso">Tempestuoso</option>
                    </select>

                      <!-- <label class="btn btn-default btn-file">
                        Anexo<input type="file" style="display: none;">
                      </label> --> 

                  </div>

                  <!--rodapé -->
                  <div class="modal-footer">  
                      <input type="submit" class="btn btn-danger btn-block"></input>
                  </div>
                </div>
              </div>
          </form>
        <!-- /Novo relatório -->

        <!-- Nova ocorrência -->
          <form class="modal fade " id="modal-ocorrencia" action="classes/insere_ocorrencias.php" method="POST" enctype="multipart/form-data">
              <div class="modal-dialog modal-sm-12">
                <div class="modal-content">
                  <!--cabeçalho -->
                  <div class="modal-header">  
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Nova ocorrência</h3>
                  </div>

                  <!--corpo -->
                  <div class="modal-body">  
                    
                  <div class="form-group">
                    <input type="text" name="titulo" class="form-control" placeholder="Título" required>
                  </div>

                    <div class="form-group">
                      <label for="tipo">Tipo</label>
                      <select class="form-control" id="tipo" name="tipo-ocorrencia">
                        <option value="1">Impedimento</option>
                        <option value="2">Acidente</option>
                        <option value="3">Outro</option>
                      </select>
                    </div>

                    <div class="form-group" style="position: relative;">
                      <textarea class="form-control" rows="4" placeholder="Causa" name="causa" required></textarea>

                      <label class="btn btn-info btn-file" style="position: absolute; bottom: 10px; right: 10px;">
                        Foto<input type="file" style="display: none;" name="arquivo">
                      </label> 
                      
                    </div>

                    <div class="form-group" style="position: relative;">
                      <textarea class="form-control" rows="4" placeholder="Efeito" name="efeito" required></textarea>  
                    </div>

                  <!--rodapé -->
                  <div class="modal-footer">  
                      <input type="submit" class="btn btn-danger btn-block"></input>
                  </div>
                </div>
              </div>
          </form>
        <!-- /Nova ocorrência -->
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="jquery/jqueryForm.min.js"></script>
    <script type="text/javascript">
      
      $(document).ready(function(){
        
        var cont = 0;
        
        $('#btn-send').click(function(){
          if($('#input-txt').val().length > 0){  
            $.ajax({
              url: 'classes/insere_mensagens.php',
              method: 'post',
              data: $('#form_msg').serialize(),
              success: function(data){
                atualizaMensagens();
              }
            });
          }

          cont = 0;
        });

        var lim = 10;
        $('#btn-carrega-msg').click(function(){
          lim = lim + 10;
          cont = 0;
          atualizaMensagens();
        });



        function atualizaMensagens(){
            var numMsg = {
              limite: lim
            }
            if(cont == 0){
                $('#mensagens').html('<img src="img/ajax-loader.gif" alt="Enviando..."/> Enviando...');
                var ajax = $.ajax({
                  url: 'classes/seleciona_mensagens.php',
                  method: 'post',
                  data: numMsg,
                  success: function(data){
                    $('#mensagens').html(data);
                    atualizaMensagens();
                    $('#input-txt').val("");
                  }
                }); 
              cont++;
            }
        }
        atualizaMensagens();

        $('#input-txt').keypress(function(event){
                // GIF de carregamento antes de o conteúdo ser upado
                // $('#mensagens').html('<img src="img/ajax-loader.gif" alt="Enviando..."/> Enviando...');

                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                  $.ajax({
                    url: 'classes/insere_mensagens.php',
                    method: 'post',
                    data: $('#form_msg').serialize(),
                    success: function(data){
                      atualizaMensagens();
                    }
                  });
                }
                cont = 0;
        });

        // Elimina a submissão do form via get que destriua a url necessaria para que a aplicação funcionasse.
        $('input').keypress(function (e) {
                var code = null;
                code = (e.keyCode ? e.keyCode : e.which);                
                return (code == 13) ? false : true;
        });


         $('#input-img').change(function(){
            $('#btn-sbmt-img').show();
         });

         // $('#over-mensagens').mouseout(function(){
         //    $('#btn-carrega-msg').hide();
         // });

         // $('#over-mensagens').mouseover(function(){
         //    $('#btn-carrega-msg').show();
         // });


        // $('#input-img').click(function(){
        //   console.log("Upload de imagem");

        //     $.ajax({
        //       url: 'classes/insere_imagens.php',
        //       method: 'post',
        //       data: $('#form-img').serialize(),
        //       success: function(data){

        //       }
        //     });
        // });

       //  /* #imagem é o id do input, ao alterar o conteudo do input execurará a função baixo */
       // $('#input-img').change(function(){
       //     console.log('UP de img');
       //     $('#mensagens').html('<img src="img/ajax-loader.gif" alt="Enviando..."/> Enviando...');
          
       //    // Efetua o Upload sem dar refresh na pagina            
       //     $('#form-img').ajaxForm({
       //        target:'#mensagens' // o callback será no elemento com o id #mensagens
       //      }).submit();
       // });
  });

    </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>