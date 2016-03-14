<?php

	require('conn.php');

	//sanitiza inputs para prevenir injecao de SQL
	$nome = mysqli_real_escape_string($conexao, $_POST['nomeUsuario']);
	$sobrenome = mysqli_real_escape_string($conexao, $_POST['sobrenomeUsuario']);
	$cidade = mysqli_real_escape_string($conexao, $_POST['cidadeUsuario']);
	$endereco = mysqli_real_escape_string($conexao, $_POST['enderecoUsuario']);
	$telefone = mysqli_real_escape_string($conexao, $_POST['telefoneUsuario']);
	$email = mysqli_real_escape_string($conexao, $_POST['emailUsuario']);
	$login = mysqli_real_escape_string($conexao, $_POST['login']);
	$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
	$senhaHasheada = password_hash($senha, PASSWORD_DEFAULT);				//hash simples

	$sql = "INSERT INTO usuarios.credenciais (Nome, Sobrenome, Cidade, Endereco, Telefone, Email, Login, Senha)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
			
	$expressao = $conexao->prepare($sql);
	
	if(!$expressao){
		die('Função de preparação falhou.');
	}
	
	$flag = $expressao->bind_param("ssssssss", $nome, $sobrenome, $cidade, $endereco, $telefone, $email, $login, $senhaHasheada);
	
	if(!$flag){		
		die('Função de aplicação de argumentos falhou.');
	}
	
	$flag = $expressao->execute();
	
	if(!$flag){
		die('Função de execução da expressão SQL falhou.');
	}
		
	header("refresh:3; url=http://localhost:81/PagDeLogin.html");
	echo('Cadastro efetuado com sucesso! Redirecionando para a página de Login...');	
	mysqli_close($conexao);
	exit();
		

?>