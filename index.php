<?php
require 'conexaobusca.php';

// Recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
if (empty($termo)):

	$conexao = conexao::getInstance();
	$sql = 'SELECT codigo, nome, data_nascimento, nome_mae, cpf, rg FROM funcionario';
	$stm = $conexao->prepare($sql);
	$stm->execute();
	$funcionarios = $stm->fetchAll(PDO::FETCH_OBJ);

else:

	// Executa uma consulta baseada no termo de pesquisa passado como parâmetro
	$conexao = conexao::getInstance();
	$sql = 'SELECT codigo, nome, data_nascimento, nome_mae, cpf, rg FROM funcionario WHERE nome LIKE :nome OR cpf LIKE :cpf';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':nome', $termo.'%');
	$stm->bindValue(':cpf', $termo.'%');
	$stm->execute();
	$funcionarios = $stm->fetchAll(PDO::FETCH_OBJ);

endif;
?>

<html>
<head>
    <meta charset="utf-8">
	<title>Listagem Funcionários</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend><h1>Listagem de Funcinários</h1></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
				<label class="col-md-2 control-label" for="termo">Pesquisar</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Infome o Nome ou CPF">
				</div>
			    <button type="submit" class="btn btn-primary">Pesquisar</button>
			    <a href='index.php' class="btn btn-primary">Ver Todos</a>
			</form>



			<?php if(!empty($funcionarios)):?>

				<!-- Tabela de Funcionários -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Codigo</th>
						<th>Nome</th>
						<th>Data de Nascimento</th>
						<th>Nome da Mãe</th>
						<th>CPF</th>
						<th>RG</th>
					</tr>
					<?php foreach($funcionarios as $funcionarios):?>
						<tr>
							<td><?=$funcionarios->codigo?></td>
							<td><?=$funcionarios->nome?></td>
							<td><?=$funcionarios->data_nascimento?></td>
							<td><?=$funcionarios->nome_mae?></td>
							<td><?=$funcionarios->cpf?></td>
							<td><?=$funcionarios->rg?></td>
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista funcionários ou não encontrado  -->
				<h3 class="text-center text-primary">Não existem funcionários cadastrados!</h3>
			<?php endif; ?>
		</fieldset>
	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>