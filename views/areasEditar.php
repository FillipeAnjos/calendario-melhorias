<?php 

session_start();

use DAO\Area;

	$idArea = $_GET['idArea'];

	$table = 'area';
	$table2 = 'melhorias';

	$verificarTcAs = Area::getInstance()->verificarTcA($table, $table2);

	$verificar = false;//Verificar se pode ou não editar

	foreach ($verificarTcAs as $verificarTcA) :
		if($verificarTcA->area == $idArea){
			$verificar = true;
		}
	endforeach;

	if($verificar == false){
		//Pode editar

		echo ("<script LANGUAGE='JavaScript'>
			window.location.href='index.php?path=areasAlterar&idArea=".$idArea."';
		</script>");

	}else{
		//Não pode editar
		$_SESSION['errorArea'] = "Error. Essa área não pode ser editada, somente áreas livres de tarefas podem ser editadas!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areas';
			</script>");
		die();
	}

?>