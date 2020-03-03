<?php 

session_start();

use DAO\Melhoria;

	$idTarefa = $_GET['idTarefa'];

	$table = 'melhorias';

	$excluir = Melhoria::getInstance()->excluirAreaOrMelhorias($table, $idTarefa);

		if($excluir){
			$_SESSION['sucessoTarefas'] = "Tarefa excluida com sucesso!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=tarefas';
				</script>");
			die();
		}else{
			$_SESSION['errorTarefas'] = "Error. Ocorreu um erro ao excluir a tarefa!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=tarefas';
				</script>");
			die();
		}


?>