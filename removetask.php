<?php
	
	header('content-type: text/html; charset: utf-8');
	
	$task_id = $_GET["id"];
	
	$SQL = "DELETE FROM tasks WHERE task_id = $task_id LIMIT 1";
			
	try{
	
		// Conexão com o banco de dados mysql
		$con = @mysql_connect("localhost","root","bakugannaruto");

		if(!$con)
			throw new Exception("Problemas ao se conectar!");
			
		$db = @mysql_select_db('bitter');
		
		if(!$db)
			throw new Exception("Problemas ao encontrar o banco de dados!");
		
		if($rs = mysql_query($SQL))
			$status = "Tarefa removida com sucesso!";
		else
			throw new Exception("Problemas ao remover os dados: ".mysql_error());
			
	}catch(Exception $ex){
		$status = $ex->getMessage();
	}
	
	echo $status;
	
?>