<?php
	
	header('content-type: text/html; charset: utf-8');
	
	$task_id = $_GET["task_id"];
	
	$SQL = "UPDATE tasks SET task_status=1 WHERE task_id=$task_id";
			
	try{
	
		// Conexão com o banco de dados mysql
		$con = @mysql_connect("localhost","root","bakugannaruto");

		if(!$con)
			throw new Exception("Problemas ao se conectar!");
			
		$db = @mysql_select_db('bitter');
		
		if(!$db)
			throw new Exception("Problemas ao encontrar o banco de dados!");
		
		if($rs = mysql_query($SQL))
			$status = "Tarefa atualizada com sucesso!";
		else
			throw new Exception("Problemas ao inserir os dados: ".mysql_error());
			
	}catch(Exception $ex){
		$status = $ex->getMessage();
	}
	
	echo $status;
	
?>