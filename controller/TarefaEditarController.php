<?php 

session_start();

use DAO\Melhoria;

	$id            = $_POST['id'];
	$tarefa        = $_POST['tarefa'];
	$area          = $_POST['area'];
	$descricao     = $_POST['descricao'];
	$prazoAcordado = $_POST['prazoAcordado'];
	$gravidade     = $_POST['gravidade'];
	$urgencia      = $_POST['urgencia'];
	$tendencia     = $_POST['tendencia'];
	$prazoLegal    = $_POST['prazoLegal'];

	/*
	echo $id;
	echo "<br/>";
	echo $tarefa;
	echo "<br/>";
	echo $area;
	echo "<br/>";
	echo $descricao;
	echo "<br/>";
	echo $prazoAcordado;
	echo "<br/>";
	echo $gravidade;
	echo "<br/>";
	echo $urgencia;
	echo "<br/>";
	echo $tendencia;
	echo "<br/>";
	echo $prazoLegal;

	die();
	*/

	$table = 'melhorias';

	$array = array();

	$array[] = $tarefa;
	$array[] = $descricao;
	$array[] = $prazoAcordado;
	$array[] = $prazoLegal;
	$array[] = $gravidade;
	$array[] = $urgencia;
	$array[] = $tendencia;
	$array[] = $area;


	if($array[4] == '' && $array[5] == '' && $array[6] == ''){
		$_SESSION['errorTarefas'] = "Error. Informe ao menos um campo entre Gravidade, Urgência ou Tendencia.";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=tarefas';
			</script>");
		die();
	}

	$update = Melhoria::getInstance()->updateEditarTarefas($table, $id, $array);

	if($update){
		$_SESSION['sucessoTarefas'] = "Tarefa atualizada com sucesso!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=tarefas';
			</script>");
		die();
	}else{
		$_SESSION['errorTarefas'] = "Error. Ocorreu um erro ao atualizar a tarefa!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=tarefas';
			</script>");
		die();
	}

?>