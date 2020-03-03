<?php 

session_start();

use DAO\Area;

	$id        = $_POST['id'];
	$descricao = $_POST['descricao'];

	$table = 'area';

	$update = Area::getInstance()->updateEditar($table, $id, $descricao);

	if($update){
		$_SESSION['sucessoArea'] = "Área atualizada com sucesso!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areas';
			</script>");
		die();
	}else{
		$_SESSION['errorArea'] = "Error. Ocorreu um erro ao atualizar a área!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areas';
			</script>");
		die();
	}

?>