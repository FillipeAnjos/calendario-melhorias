<?php 

	session_start();

use DAO\Area;
use DAO\Gravidade;
use DAO\Urgencia;
use DAO\Tendencia;

$areas      = Area::getInstance()->getAll();
$gravidades = Gravidade::getInstance()->getAll();
$urgencias  = Urgencia::getInstance()->getAll();
$tendencias = Tendencia::getInstance()->getAll();

/*
	********************************************* Msg's *****************************************************
*/
if(isset($_SESSION['sucessoTarefaInserida'])){
	?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['sucessoTarefaInserida']; unset($_SESSION['sucessoTarefaInserida']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
	<?php
  }

if(isset($_SESSION['errorTarefaInserida'])){
	?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['errorTarefaInserida']; unset($_SESSION['errorTarefaInserida']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
	<?php
  }
/*
	********************************************* Msg's *****************************************************
*/


  echo "<center>
  	Bem-Vindo(a) a página <br/> <b>Cadastrar Tarefas!</b><br/><br/>
  <center>";
  
?>

<div class="container">

  <form class="col-sm-12 col-md-6" action="index.php?pathController=TarefaInsertController" method="POST" style="border-style: ridge;">

    <br/>
    <p><i>Nos informe a baixo os dados a serem salvos referente as tarefas!!!</i></p>

    <input type="text" name="tarefa" class="form-control" placeholder="Tarefa" required>

    <br/>

    <select name="area" class="form-control" required>
    	<option value="">Selecione a Área</option>
    	<?php foreach ($areas as $area) : ?>
    		<option value="<?php echo $area->id ?>"><?php echo $area->descricao ?></option>
    	<?php endforeach ?>
    </select>
   	<br/>
    <input type="text" name="descricao" class="form-control" placeholder="Descrição" required>
   	<br/>

   	<label>Prazo Acordado</label>
   	<input type="date" name="prazoAcordado" class="form-control" required>

   	<hr>
   	<!--<br/>-->
  
   	<select name="gravidade" class="form-control">
    	<option value="">Selecione a Gravidade</option>
    	<?php foreach ($gravidades as $gravidade) : ?>
    		<option value="<?php echo $gravidade->id ?>"><?php echo $gravidade->descricao ?></option>
    	<?php endforeach ?>
    </select>
   	<br/>
   	<select name="urgencia" class="form-control">
    	<option value="">Selecione a Urgência</option>
    	<?php foreach ($urgencias as $urgencia) : ?>
    		<option value="<?php echo $urgencia->id ?>"><?php echo $urgencia->descricao ?></option>
    	<?php endforeach ?>
    </select>
   	<br/>
   	<select name="tendencia" class="form-control">
    	<option value="">Selecione a Tendencias</option>
    	<?php foreach ($tendencias as $tendencia) : ?>
    		<option value="<?php echo $tendencia->id ?>"><?php echo $tendencia->descricao ?></option>
    	<?php endforeach ?>
    </select>

    <hr>
  	<!--<br/>-->

  	<label>Prazo Legal</label>
  	<input type="date" name="prazoLegal" class="form-control" required>

  	<br/>

   	<input type="submit" name="Cadastrar" value="Cadastrar" class="btn btn-sm btn-primary">
    <h1> </h1>

  </form>
</div>