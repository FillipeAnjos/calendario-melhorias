<?php 

session_start();

use DAO\Area;
use DAO\Gravidade;
use DAO\Urgencia;
use DAO\Tendencia;
use DAO\Melhoria;

	$idTarefa = $_GET['idTarefa'];

	$table = 'area';
	$table2 = 'melhorias';

$tarefas = Melhoria::getInstance()->buscarTarefaId($table2, $idTarefa);
$areas = Area::getInstance()->getAll();

$gravidades = Gravidade::getInstance()->getAll();
$urgencias = Urgencia::getInstance()->getAll();
$tendencias = Tendencia::getInstance()->getAll();
	
echo "<center>
  	Bem-Vindo(a) a página <br/> <b>Editar Tarefas!</b><br/><br/>
  </center>";

?>

<center>

<div class="container">
   <form class="col-sm-12 col-md-12" action="index.php?pathController=TarefaEditarController" method="POST" style="border-style: ridge;">

   	<br/>
    <p><i>Nos informe a baixo os dados a serem alterados!!!</i></p>

   	<?php foreach($tarefas as $tarefa) : 
   		if($tarefa->id == $idTarefa){
   	?>

	   	<!-- 
			---------------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------------
		-->

		<div class="container">
		  <div class="row">
		    <div class="col-sm">
		      

		    	<input type="hidden" name="id" value="<?php echo $idTarefa; ?>">

		   		<label>Tarefa</label>
		   		<input type="text" name="tarefa"  class="form-control" value="<?php echo trim($tarefa->tarefa); ?>" required>
			   	<br/>

			   	<label>Área</label>
			   	<select name="area" class="form-control">
			   		<?php foreach($areas as $area) : ?>

			   			<?php 
			   				if($tarefa->area == $area->id){
			   			?>
			   					<option value="<?php echo $area->id; ?>" selected><?php echo $area->descricao; ?></option>
			   			<?php
			   				}else{
			   			?>
			   					<option value="<?php echo $area->id; ?>"><?php echo $area->descricao; ?></option>
			   			<?php
			   				}
			   			?>

			   		<?php endforeach ?>
			   	</select>

			   	<br/>

			   	<label>Descricao</label>
			   	<input type="text" name="descricao" class="form-control" value="<?php echo trim($tarefa->descricao); ?>" required>
			   	<br/>

			   	<label>Prazo Acordado</label>
			   	<input type="date" name="prazoAcordado" class="form-control" value="<?php echo trim($tarefa->prazo_acordado); ?>" required>
			   	<br/>


		    </div>
		    <div class="col-sm">
		      

		    	<label>Gravidade</label>
			   	<select name="gravidade" class="form-control">
			   		<?php foreach($gravidades as $gravidade) : ?>

			   			<?php 
			   				if($tarefa->gravidade == $gravidade->id){
			   			?>
			   					<option value="">Selecione</option>
			   					<option value="<?php echo $gravidade->id; ?>" selected><?php echo $gravidade->descricao; ?></option>
			   			<?php
			   				}else{
			   			?>
			   					<option value="<?php echo $gravidade->id; ?>"><?php echo $gravidade->descricao; ?></option>
			   			<?php
			   				}
			   			?>

			   		<?php endforeach ?>
			   	</select>
			   	<br/>

			   	<label>Urgência</label>
			   	<select name="urgencia" class="form-control">
			   		<?php foreach($urgencias as $urgencia) : ?>

				   		<?php 
			   				if($tarefa->urgencia == $urgencia->id){
			   			?>
			   					<option value="">Selecione</option>
			   					<option value="<?php echo $urgencia->id; ?>" selected><?php echo $urgencia->descricao; ?></option>
			   			<?php
			   				}else{
			   			?>
			   					<option value="<?php echo $urgencia->id; ?>"><?php echo $urgencia->descricao; ?></option>
			   			<?php
			   				}
			   			?>

			   		<?php endforeach ?>
			   	</select>
			   	<br/>

			   	<label>Tendência</label>
			   	<select name="tendencia" class="form-control">
			   		<?php foreach($tendencias as $tendencia) : ?>

				   		<?php 
			   				if($tarefa->tendencia == $tendencia->id){
			   			?>
			   					<option value="">Selecione</option>
			   					<option value="<?php echo $tendencia->id; ?>" selected><?php echo $tendencia->descricao; ?></option>
			   			<?php
			   				}else{
			   			?>
			   					<option value="<?php echo $tendencia->id; ?>"><?php echo $tendencia->descricao; ?></option>
			   			<?php
			   				}
			   			?>

			   		<?php endforeach ?>
			   	</select>
			   	<br/>

			   	<label>Prazo Legal</label>
			   	<input type="date" name="prazoLegal" class="form-control" value="<?php echo trim($tarefa->prazo_legal); ?>" required>
			   	<br/>


		    </div>
		  </div>
		</div>

	   	<!-- 
			---------------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------------
		-->

	<?php
		}
   	 endforeach; 

   	?>

   	<input type="submit" name="Atualizar" value="Atualizar" class="btn btn-sm btn-primary">
    <br/><br/>

  </form>
</div>

</center>



?>