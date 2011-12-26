<?php
	header("content-type: text/xml; charset: utf-8");
	
	// Conexão com o banco de dados mysql
	$conexao = mysql_connect("localhost","root","bakugannaruto");
	
	// Acessa o banco de dados bitter
	$banco = mysql_select_db("bitter");
	
	// Executa a query
	$rs = mysql_query("SELECT * FROM tasks");
	
	$dados = "";
	
	$dados = "<?xml version='1.0' encoding='utf-8' ?>\n";
	$dados .= "<tasks>\n";
	
	while($row = mysql_fetch_array($rs)){
		$dados .= "<task>\n";
		$dados .= "<task_id>".$row['task_id']."</task_id>\n";
		$dados .= "<task_description>".$row['task_description']."</task_description>\n";
		$dados .= "<task_status>".$row['task_status']."</task_status>\n";
		$dados .= "</task>\n";
	} //end while
	
	$dados .= "</tasks>\n";
	
	// Imprime os resultados
	echo $dados;
?>