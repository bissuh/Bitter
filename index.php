<html>
	<head>
		<title>Bitter</title>
		
		<!-- StyleSheets -->
		<link rel='stylesheet' href='css/pagestyle.css' type='text/css' />
		
		<!-- Javascript -->
		<script language="Javascript">
		
			/**
			* Generates XMLHttpRequest Object
			*/
			function objXMLHttp(){
								
				if(window.XMLHttpRequest){ //Mozila, Safari ...
					var objetoXMLHttp = new XMLHttpRequest();
					return objetoXMLHttp;
				} else if (window.ActiveXObject) { // IE
					
					var versoes = ["MSXML2.XMLHttp.6.0","MSXML2.XMLHttp.5.0","MSXML2.XMLHttp.4.0",
									"MSXML2.XMLHttp.3.0","MSXML2.XMLHttp","MSXML.XMLHttp"];
					
					for(var i = 0; i < versoes.length;i++){
						try{
							var objetoXMLHttp = new ActiveXObject(versoes[i]);
							return objetoXMLHttp;
						}catch (ex){
							// Null
						}
					}
					
					return false;
				}	
			}
			
			/**
			* Add a new task.
			*/
			function enviar(formulario){
				
				var dados = "task_description="+formulario.task_description.value;
				
				var oXMLHttp = objXMLHttp();
				
				oXMLHttp.open("POST","operationtask.php",true);
				oXMLHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				
				oXMLHttp.onreadystatechange = function(){
					if(oXMLHttp.readyState == 4){
						if(oXMLHttp.status == 200){
							document.getElementById('task_description').value = '';
							update();
						}else{
							alert("Ocorreu o erro: "+oXMLHttp.statusText);
						}
					}
				};
				
				oXMLHttp.send(dados);
				 
				return false;
			}
			
			/**
			* Gets all the tasks in database
			*/
			function update(){
				var ajax = false;
				if(window.XMLHttpRequest){ // Mozilla, Safari, Chrome...
					ajax = new XMLHttpRequest();
				}else if(window.ActiveXObject){ // IE
					ajax = objXMLHttp();
				}
				
				//se tiver suporte ajax
				if(ajax){
					ajax.open("GET","updatelist.php");
					ajax.onreadystatechange = function() {
						//chama função processaXML que vai varrer os dados
						if(ajax.readyState == 4){
							if(ajax.status == 200){
								limparResultadosAnteriores();
								processarXML(ajax.responseXML);
							} else {
								alert(ajax.responseXML);
							}
						}
					}
					ajax.send(null);
				}
			}
			
			/**
			* Remove task from database
			*/
			function removeTask(task_id,status){
				var ajax = false;
				if(window.XMLHttpRequest){ // Mozilla, Safari, Chrome...
					ajax = new XMLHttpRequest();
				}else if(window.ActiveXObject){ // IE
					ajax = objXMLHttp();
				}
				
				//se tiver suporte ajax
				if(ajax){
					ajax.open("GET","removetask.php?id="+task_id,true);
					ajax.onreadystatechange = function() {
						//chama função processaXML que vai varrer os dados
						if(ajax.readyState == 4){
							if(ajax.status == 200){
								removeFromList(task_id,status);
							} else {
								alert(ajax.responseXML);
							}
						}
					}
					ajax.send(null);
				}
			}
			
			/**
			* Reecive XML from update and insert updates the task list
			*/
			function processarXML(obj){
				// pega a tag livro do XML
				var dados = obj.getElementsByTagName("task");
				
				//total de aelementos contidos na tag livro
				if(dados.length > 0){
					//percorrer o arquivo XML para extrair os dados
					for(var i = 0; i < dados.length; i++){
						var item = dados[i];
						
						//conteúdo dos campos no arquivo XML
						var task_description = item.getElementsByTagName("task_description")[0].firstChild.nodeValue;
						var task_id = item.getElementsByTagName("task_id")[0].firstChild.nodeValue;
						var task_status = item.getElementsByTagName("task_status")[0].firstChild.nodeValue;
						adicionarLinhaNaTabela(task_id,task_description,task_status);
					}
				}
			}
			
			/**
			* Clean the list displayed
			*/
			function limparResultadosAnteriores(){
				var tBody  = document.getElementById("todolist");
				
				while(tBody.childNodes.length > 0){
					tBody.removeChild(tBody.childNodes[0]);
				}
				
				tBody  = document.getElementById("donelist");
				
				while(tBody.childNodes.length > 0){
					tBody.removeChild(tBody.childNodes[0]);
				}
			}
			
			/**
			* Add a new task to the list
			*/
			function adicionarLinhaNaTabela(task_id,task_description,task_status){
				
				var addTask = document.createElement('div');
				if(task_status == 0){
					var newTask = '<input type="button" class="taskcontroller" onclick="removeTask('+task_id+',0)" value="X"/>';
					newTask += '<input type="button" class="taskcontroller" onclick="markDone('+task_id+')" value="Done"/>';
					newTask += task_description;
					
					addTask.id = task_id;
					addTask.innerHTML = newTask;
					addTask.className = 'oneListTask';
					
					var linha = document.getElementById("todolist").appendChild(addTask);
				}else{
					var newTask = '<input type="button" class="taskcontroller" onclick="removeTask('+task_id+',1)" value="X"/>';
					newTask += '<input type="button" class="taskcontroller" onclick="markUnDone('+task_id+')" value="Back"/>';
					newTask += task_description;
					
					addTask.id = task_id;
					addTask.innerHTML = newTask;
					addTask.className = 'oneListDoneTask';
					
					var linha = document.getElementById("donelist").appendChild(addTask);
				}
			}
			
			/**
			* Remove the task identified from the list
			*/
			function removeFromList(task_id,status){
				if(status == 0) var tBody  = document.getElementById("todolist");
				else var tBody  = document.getElementById("donelist");
				
				for(var i = 0;i < tBody.childNodes.length; i++){
					if(tBody.childNodes[i].id == task_id) tBody.removeChild(tBody.childNodes[i]);
				}
			}
			
			/**
			* Mark a task done
			*/
			function markDone(task_id){
				
				var ajax = false;
				if(window.XMLHttpRequest){ // Mozilla, Safari, Chrome...
					ajax = new XMLHttpRequest();
				}else if(window.ActiveXObject){ // IE
					ajax = objXMLHttp();
				}
				
				//se tiver suporte ajax
				if(ajax){
					ajax.open("GET","donetask.php?id="+task_id);
					ajax.onreadystatechange = function() {
						//chama função processaXML que vai varrer os dados
						if(ajax.readyState == 4){
							if(ajax.status == 200){
								update();
							} else {
								alert(ajax.responseXML);
							}
						}
					}
					ajax.send(null);
				}
			}
			
		</script>
		
	</head>
	<body onload='update();'>
		<div id='mainwrapper' align='center'>
			<div id='maincontent' align='left'>
				<div id='editor'>
					<form id="form1" name="form1" method="post" action="" onsubmit="if(this.task_description.value!='') return enviar(this);">
						<input id='task_description' type='text' />
						<input id='btnNewTask' type="submit" name="Submit" value='Add' />
						<!-- 
							This button refresh the list
							<input id='btnUpdate' type="button" name="" value='Update' onclick="update();" /> 
						-->
					</form>
				</div>
				<div id='todolist'>
				</div>
				<div id='donelist'>
				</div>
			</div>
		</div>
	</body>
</html>