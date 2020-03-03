<?php 

use DAO\Area;

	$idArea = $_GET['idArea'];

	$table = 'area';

$areas = Area::getInstance()->buscarAreaId($table, $idArea);
	
	/*
	foreach($areas as $area) :
		if($area->id == $idArea){
			echo $area->descricao;
			echo "<br/>";
		}
	endforeach;	
	*/

echo "<center>
  	Bem-Vindo(a) a página <br/> <b>Editar Áreas!</b><br/><br/>
  </center>";

?>

<center>

<div class="container">
   <form class="col-sm-12 col-md-6" action="index.php?pathController=AreaEditarController" method="POST" style="border-style: ridge;">

   	<br/>
    <p><i>Nos informe a baixo os dados a serem alterados!!!</i></p>

   	<?php foreach($areas as $area) : 
   		if($area->id == $idArea){
   	?>

      <input type="hidden" name="id" value="<?php echo $idArea; ?>">
   		<label>Descrição</label>
   		<input type="text" name="descricao"  class="form-control" value="<?php echo trim($area->descricao); ?>" required>
	   	<br/>
	<?php
		}
   	 endforeach; 

   	?>

   	<input type="submit" name="Cadastrar" value="Cadastrar" class="btn btn-sm btn-primary">
    <h1> </h1>

  </form>
</div>

</center>