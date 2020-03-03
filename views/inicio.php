<?php

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
<div class="container" id="agenda">
  <form class="col-sm-12 col-md-6">
    <!-- 
      ***************************************************************************************************************************************************
    -->
    <!--<center>
      <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cadastrar
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="views/areas.php">Áreas</a>
          <a class="dropdown-item" href="#">Tarefas</a>
        </div>
      </div>
    </center>-->
    <!-- 
      ***************************************************************************************************************************************************
    -->
    <div class="form-row">
      <div class="form-group col-sm-12">
        <label for="area">Áreas</label>
        <select class="form-control" id="area">
          <option value="0">Selecione</option>
        <?php foreach ($areas as $area) : ?>
          <option value="<?php echo $area->id; ?>"><?php echo $area->descricao; ?></option>
        <?php endforeach; ?>
        </select>
        <small id="areaHelp" class="form-text text-muted">Area de negócio da tarefa.</small>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-12 col-md-5">
        <label for="mes_inicio">Período</label>
        <select class="form-control" id="mes_inicio">
          <option value="0">Selecione</option>
          <?php foreach ($meses as $mes) : ?>
            <option value="<?php echo $mes->id; ?>"><?php echo $mes->descricao; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-sm-12 col-md-2">
        <div>&nbsp;</div>
        <div class="separador-texto-combos">à</div>
      </div>
      <div class="form-group col-sm-12 col-md-5">
        <label for="mes_fim">&nbsp;</label>
        <select class="form-control" id="mes_fim">
          <option value="0">Selecione</option>
          <?php foreach ($meses as $mes) : ?>
            <option value="<?php echo $mes->id; ?>"><?php echo $mes->descricao; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <button type="button" id="btn_buscar" class="btn btn-primary">Buscar</button>
  </form>
</div>
<script type="text/javascript">
  document.querySelector('#btn_buscar').addEventListener('click', function(ev) {

    var form        = document.querySelector('form');
    var fields      = form.elements;
    var qryString   = '?path=agenda';
    var filtroMeses = [];

    for(let field of fields) {



      if(field.value > 0) {
      

        switch(field.id) {
          case 'area':

            qryString += '&';
            qryString += field.id;
            qryString += '=';
            qryString += field.value;
            break;

          case 'mes_inicio':
          case 'mes_fim':
            filtroMeses.push(field.value);
            break;
        }
      }
    }


  var str = filtroMeses.toString();
  var cond = str.split(",");


  if(cond[0] == '' || cond[0] == null || cond[1] == '' || cond[1] == null){
    alert('Favor informar os meses de início e fim!');
  }else{

      if( parseInt(cond[0]) < parseInt(cond[1]) ){
          if(filtroMeses.length > 0) {
            qryString += '&meses='
            qryString += filtroMeses.join('-');
          }

          //location.href //http://localhost/teste/calendario-melhorias/index.php?path=inicio#
          location.href = qryString; //?path=agenda&meses=1-2
      }else{
        alert('Error. O mês de início não pode ser maior ou igual ao mês final');
      }

  }
    
  })
</script>
