<?php

error_reporting(E_ALL);
ini_set('display_errors', 'off');

if(!file_exists('vendor/autoload.php')) {
    die('Instale as dependencias');
}

require_once 'vendor/autoload.php';

if(empty($_GET)) {
    header('Location: ?path=inicio');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Agenda</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="true" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php?path=areas">Áreas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?path=tarefas">Tarefas</a>
      </li>
    </ul>
  </div>
</nav>
<div class="position-relative" style="margin-top: 20px">
    <?php
        if($_GET['path'] != 'inicio' 
            && $_GET['path'] != 'agenda' 
            && $_GET['path'] != 'areas'
            && $_GET['path'] != 'areasInserir'
            && $_GET['path'] != 'areasEditar'
            && $_GET['path'] != 'tarefasAlterar'
            && $_GET['path'] != 'areasAlterar'
            && $_GET['path'] != 'tarefas'
            && $_GET['path'] != 'tarefaInserir'
            && $_GET['pathController'] != 'AreaInsertController'
            && $_GET['pathController'] != 'AreaExcluirController'
            && $_GET['pathController'] != 'AreaEditarController'
            && $_GET['pathController'] != 'TarefaInsertController'
            && $_GET['pathController'] != 'TarefaExcluirController'
            && $_GET['pathController'] != 'TarefaEditarController'
            ){
          
          $erro = "<center>";
            $erro .= "<br/>";
            $erro .= "<span style='font-size: 21px;'>404 | NOT_FOUND</span>";
            $erro .= "<br/>";
            $erro .= "<span style='font-size: 20px;'>O URL fornecido é inválido.</span>";
            $erro .= "<br/><br/>";
            $erro .= "Desculpe não conseguimos encontrar o destino! =/";
            $erro .= "<br/><h1> </h1>";
            $erro .= "<a href='index.php' class='btn btn-sm btn-primary'>Voltar ao início</a>";
          $erro .= "</center>";
          
          echo $erro;

          die();
        }


        if(!empty($_GET['path'])) {
            require_once ('views/'. $_GET['path'] . '.php');
        }

        if(!empty($_GET['pathController'])) {
            require_once ('controller/'. $_GET['pathController'] . '.php');
        }
    ?>
</div>
</body>
</html> 
