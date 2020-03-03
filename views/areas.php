<?php 

session_start();
 
/*
  ********************************************* Msg's *****************************************************
*/
  if(isset($_SESSION['sucessoArea'])){
  ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['sucessoArea']; unset($_SESSION['sucessoArea']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
  <?php
  }

  if(isset($_SESSION['errorArea'])){
  ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['errorArea']; unset($_SESSION['errorArea']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
  <?php
/*
  *********************************************************************************************************
*/
  }

  echo "<center>Page <b>Áreas</b><br/><br/><center>";

use DAO\Area;

$areas = Area::getInstance()->order('descricao')->getAll();
$meses = [];

for($m = 1; $m <= 12; $m++) {
  $meses[] = (object)[
    'id'         => $m,
    'descricao'  => date('F', mktime(0, 0, 0, $m)),
  ];
}
  
?>


<div class="container">
  <form class="col-sm-12 col-md-8">
   
    <a href="index.php?path=areasInserir" class="btn btn-sm btn-primary" title="Deseja inserir novas áreas?">Inserir Áreas?</a>

    <br/><br/>
    
    <p><i>Abaixo se encontra a tabela com todas as <u>áreas</u> cadastradas em nossa base de dados!</i></p>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Descrição</th>
          <th scope="col" colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($areas as $area) : ?>

          <tr>
            <th><?php echo $area->id; ?></th>
            <td><?php echo $area->descricao; ?></td>

            <td><a href="index.php?path=areasEditar&idArea=<?php echo $area->id; ?>" class="btn btn-sm btn-warning" style="color: #fff">Editar</a></td>
            <td><a href="index.php?pathController=AreaExcluirController&idArea=<?php echo $area->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir essa área?');">Excluir</a></td>
          </tr>

        <?php endforeach; ?>       
        
      </tbody>
    </table>





  </form>
</div>


