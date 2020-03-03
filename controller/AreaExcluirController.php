<?php 

session_start();

use DAO\Area;

	$idArea = $_GET['idArea'];

	$table = 'area';
	$table2 = 'melhorias';

	$verificarTcAs = Area::getInstance()->verificarTcA($table, $table2);

	$verificar = false;//Verificar se pode ou não excluir

	foreach ($verificarTcAs as $verificarTcA) :
		if($verificarTcA->area == $idArea){
			$verificar = true;
		}
	endforeach;

	if($verificar == false){
		//Pode excluir

		$excluir = Area::getInstance()->excluirAreaOrMelhorias($table, $idArea);

		if($excluir){
			$_SESSION['sucessoArea'] = "Área excluida com sucesso!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=areas';
				</script>");
			die();
		}else{
			$_SESSION['errorArea'] = "Error. Ocorreu um erro ao excluir a área!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=areas';
				</script>");
			die();
		}

	}else{
		//Não pode excluir

		$_SESSION['errorArea'] = "Error. Essa área não pode ser excluída, somente áreas livres de tarefas podem ser excluídas!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areas';
			</script>");
		die();
	}


?>