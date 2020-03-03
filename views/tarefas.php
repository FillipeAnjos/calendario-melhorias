<?php 

session_start();
 
/*
  ********************************************* Msg's *****************************************************
*/
  if(isset($_SESSION['sucessoTarefas'])){
  ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['sucessoTarefas']; unset($_SESSION['sucessoTarefas']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
  <?php
  }

  if(isset($_SESSION['errorTarefas'])){
  ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['errorTarefas']; unset($_SESSION['errorTarefas']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
  <?php

  }
/*
  *********************************************************************************************************
*/

  echo "<center>Page <b>Tarefas</b><br/><br/><center>";

use DAO\Melhoria;
use DAO\Area;

$melhorias = Melhoria::getInstance()->getAll();
$arJoinMes = Area::getInstance()->areaJoinMelhorias();  

?>

<div class="container">
  <form class="col-sm-12 col-md-8">
   
    <a href="index.php?path=tarefaInserir" class="btn btn-sm btn-primary" title="Deseja inserir novas tarefas?">Inserir Tarefas?</a>

    <br/><br/>
    
    <p><i>Abaixo se encontra a tabela com todas as <u>tarefas</u> cadastradas em nossa base de dados!</i></p>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Area</th>
          <th scope="col">Tarefas</th>
          <th scope="col" colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($arJoinMes as $arJoinMe) : ?>

          <tr>
            <td><?php echo $arJoinMe->melhoriasid; ?></td>
            <td><?php echo $arJoinMe->areadescricao; ?></td>
            <td><b><?php echo $arJoinMe->tarefa; ?></b></td>

            <td><a href="index.php?path=tarefasAlterar&idTarefa=<?php echo $arJoinMe->melhoriasid; ?>" class="btn btn-sm btn-warning" style="color: #fff">Editar</a></td>
            <td><a href="index.php?pathController=TarefaExcluirController&idTarefa=<?php echo $arJoinMe->melhoriasid; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir essa tarefa?');">Excluir</a></td>
          </tr>

        <?php endforeach; ?>       
        
      </tbody>
    </table>

  </form>
</div>


