<?php

session_start();
 
/*
	********************************************* Msg's *****************************************************
*/
  if(isset($_SESSION['sucessoAriaInserida'])){
	?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['sucessoAriaInserida']; unset($_SESSION['sucessoAriaInserida']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
	<?php
  }

  if(isset($_SESSION['errorAriaInserida'])){
	?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['errorAriaInserida']; unset($_SESSION['errorAriaInserida']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
	<?php
/*
	*********************************************************************************************************
*/
  }

  echo "<center>
  	Bem-Vindo(a) a página <br/> <b>Cadastrar Áreas!</b><br/><br/>
  <center>";
  
?>

<div class="container">

  <form class="col-sm-12 col-md-6" action="index.php?pathController=AreaInsertController" method="POST" style="border-style: ridge;">

    <br/>
    <p><i>Nos informe a baixo a descrição da área a ser inserida!!!</i></p>
    <input type="text" name="descricao"  class="form-control" placeholder="Informe a descrição da área" required>
   	<br/>
   	<input type="submit" name="Cadastrar" value="Cadastrar" class="btn btn-sm btn-primary">
    <h1> </h1>

  </form>
</div>


