<?php
	
	header('content-type: text/html; charset: utf-8');
	
	$task_id = $_POST["task_id"];
	$task_description = $_POST["task_description"];
	
	$SQL = "INSERT INTO tasks (task_description)
			VALUES ('$task_description')";
			
	try{
	
		// Conexão com o banco de dados mysql
		$con = @mysql_connect("localhost","root","bakugannaruto");

		if(!$con)
			throw new Exception("Problemas ao se conectar!");
			
		$db = @mysql_select_db('bitter');
		
		if(!$db)
			throw new Exception("Problemas ao encontrar o banco de dados!");
		
		if($rs = mysql_query($SQL))
			$status = "Tarefa adicionada com sucesso!";
		else
			throw new Exception("Problemas ao inserir os dados: ".mysql_error());
			
	}catch(Exception $ex){
		$status = $ex->getMessage();
	}
	
	echo $status;
	
?>