<?php 

session_start();

use DAO\Melhoria;

	$dataAtual = date("Y-m-d");
	$AnoAtual = date("Y");

	$tarefa        = $_POST['tarefa'];
	$area          = $_POST['area'];
	$descricao     = $_POST['descricao'];
	$prazoAcordado = $_POST['prazoAcordado'];
	$gravidade     = $_POST['gravidade'];
	$urgencia      = $_POST['urgencia'];
	$tendencia     = $_POST['tendencia'];
	$prazoLegal    = $_POST['prazoLegal'];

/*
	****************************************************************************************************************************
	******************************************************** Validações ********************************************************
	****************************************************************************************************************************
*/
	if($prazoAcordado < $dataAtual || $prazoLegal < $dataAtual){
		$_SESSION['errorTarefaInserida'] = "Erro. Favor informar as datas 'Prazo Acordado' e 'Prazo Legal' entre a data atual até o último dia do ano!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='javascript:history.back()';
			</script>");
		die();
	}
	
	$anoPrazoAcordado = explode("-", $prazoAcordado);
	if($AnoAtual != $anoPrazoAcordado[0]){
		$_SESSION['errorTarefaInserida'] = "Erro. O prazo acordado necessariamente deverá estar no ano corrente!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='javascript:history.back()';
			</script>");
		die();
	}

	$anoPrazoLegal = explode("-", $prazoLegal);
	if($AnoAtual != $anoPrazoLegal[0]){
		$_SESSION['errorTarefaInserida'] = "Erro. O prazo legal necessariamente deverá estar no ano corrente!";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='javascript:history.back()';
			</script>");
		die();
	}
	
	if($gravidade == '' && $urgencia == '' && $tendencia == ''){
		$_SESSION['errorTarefaInserida'] = "Error. Informe ao menos um campo entre Gravidade, Urgência ou Tendencia.";
			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='javascript:history.back()';
			</script>");
		die();
	}
/*
	****************************************************************************************************************************
	****************************************************************************************************************************
	****************************************************************************************************************************
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
	
	
	
	

	$insert = Melhoria::getInstance()->insertTarefa($table, $array);

		if($insert){

			$_SESSION['sucessoTarefaInserida'] = "Tarefa inserida com sucesso!";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=tarefaInserir';
				</script>");
			die();

		}else{
			
			$_SESSION['errorTarefaInserida'] = "Error ao inserir a tarefa";
				echo ("<script LANGUAGE='JavaScript'>
					window.location.href='index.php?path=tarefaInserir';
				</script>");
			die();

		}

/*
	
	echo $array[0];
	echo "<br/>";
	echo $array[1];
	echo "<br/>";
	echo $array[2];
	echo "<br/>";
	echo $array[3];
	echo "<br/>";
	echo $array[4];
	echo "<br/>";
	echo $array[5];
	echo "<br/>";
	echo $array[6];
	echo "<br/>";
	echo $array[7];
	echo "<br/>";
*/	
	

?>