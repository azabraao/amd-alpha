<?php
	
	class site{		

		function nav(){

			echo '
		    <nav class="topo nav navbar-default ">
		      <div class="container">
		        <div class="navbar-header">

		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
		            <span class="sr-only">Alternar menu</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>

		          <a href="#" class="navbar-brand" style="color: white">AMD Alpha</a>
		        </div>

		        <div class="collapse navbar-collapse" id="barra-navegacao">
		          <ul class="nav navbar-nav navbar-right">
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION['nome'].' '.$_SESSION['sobrenome'].' '. '<span class="caret"></span>
		              </a>

		              <ul class="dropdown-menu">
		                <li><a href="senha.php">Trocar senha</a></li>
		                <li><a href="classes/sair.php">Sair</a></li>
		              </ul>              
		            </li>
		          </ul>
		        </div>
		      </div>
		    </nav>';	
		}
	}

?>