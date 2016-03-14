<?php

	require('conn.php');
	
	function exibeDetalhes($login){
		
		$sqlDados = "SELECT * FROM usuarios.credenciais WHERE Login='$login';";
		global $conexao; 
		$resultadoBuscaDados = mysqli_query($conexao, $sqlDados);
		
		if(!$resultadoBuscaDados){
			die('Busca de dados do usuário falhou: ' . mysqli_error($conexao));
		}
		
		$dadosDoUsuario = mysqli_fetch_array($resultadoBuscaDados, MYSQLI_ASSOC);
		
		echo 'Dados do Usuário: ' . '</br>' . 
		'Nome: ' . $dadosDoUsuario['Nome'] . '</br>' .
		'Sobrenome: ' . $dadosDoUsuario['Sobrenome'] . '</br>' .
		'Cidade: ' . $dadosDoUsuario['Cidade'] . '</br>' .
		'Endereço: ' . $dadosDoUsuario['Endereco'] . '</br>' .
		'Telefone: ' . $dadosDoUsuario['Telefone'] . '</br>' .
		'Email :' . $dadosDoUsuario['Email'] . '</br>' ;
	}

	$login = isset($_GET['login']) ? mysqli_real_escape_string($conexao, $_GET['login']) : '';
	$senha = isset($_GET['senha']) ? mysqli_real_escape_string($conexao, $_GET['senha']) : '';
	

	$sql = "SELECT Login, Senha FROM usuarios.credenciais WHERE Login='$login';";
	$resultadoQuery = mysqli_query($conexao, $sql);


	if(!$resultadoQuery){
		
		die('Houve o seguinte erro: ' . mysqli_error($conexao));
		
	}else{
		
		$resultadoPesquisa = mysqli_fetch_array($resultadoQuery, MYSQLI_ASSOC);
		$senhaHasheada = $resultadoPesquisa['Senha'];
		
		$verificaSenha = password_verify($senha, $senhaHasheada);
		
		if($resultadoPesquisa['Login'] != $login || !$verificaSenha){
			echo 'Erro de login. Certifique-se que seu login e senha estão corretos' . '</br>' . 'Senha hasheada: ' . $senhaHasheada . '</br>' . 'Login: ' .
			$resultadoPesquisa['Login'];
		}else{
			echo 'Login efetuado com sucesso!' . '</br>' . '</br>';
			exibeDetalhes($resultadoPesquisa['Login']);
		}
	}
	
	mysqli_free_result($resultadoQuery);
	mysqli_close($conexao);
	
?>