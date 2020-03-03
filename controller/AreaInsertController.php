<?php

session_start();

use DAO\Area;

//http://localhost/phppgadmin/
//PgAdmin 4

$table = 'area';
$descricao = $_POST['descricao'];

$areas = Area::getInstance()->getAll();

	foreach ($areas as $area) :
		if(trim($descricao) == trim($area->descricao)){
			$_SESSION['errorAriaInserida'] = "Error. Não foi possível salvar essa área, a área já se encontra em nossa base de dados!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=areasInserir';
				</script>");
			die();	
		}
	endforeach; 

$insert = Area::getInstance()->insertArea($table, $descricao);

	if($insert){

		$_SESSION['sucessoAriaInserida'] = "Área inserida com sucesso!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areasInserir';
			</script>");
		die();

	}else{
		
		$_SESSION['errorAriaInserida'] = "Error ao inserir a área";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='index.php?path=areasInserir';
			</script>");
		die();

	}





?>