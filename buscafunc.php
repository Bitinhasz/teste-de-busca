<?php
require 'conexaobusca.php';
require('../menu.php');

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
<body>
	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<h1><div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
   			<div class="col-md-10">
   			<h1 class="page-header">Funcionários</h1>
   			</div>
  			<div class="col-md-2">
      		<a class="btn btn-primary btn-block" href="<?php echo $url."sa/funcionario/form_funcionario.php";?>">Novo Funcionário</a>
 		    </div></h1><legend></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
				<label class="col-md-2 control-label" for="termo">Pesquisar</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Infome o Nome ou CPF">
				</div>
			    <button type="submit" class="btn btn-primary">Pesquisar</button>
			    <a href='index.php' class="btn btn-primary">Ver Todos</a> <br> <hr>
			</form>


			<?php if(!empty($funcionarios)):?>

				<!-- Tabela de Funcionários -->
				    <div class="col-md-12">
        <table class ="table table-striped">
            <tr align="center" >
                <td><strong>CÓDIGO</strong></td>
                <td><strong>NOME</strong></td>
                <td><strong>DATA DE NASCIMENTO</strong></td>
                <td><strong>NOME DA MÃE</strong></td>
                <td><strong>CPF</strong></td>
                <td><strong>RG</strong></td>
                <td></td>
                
            </tr>


					<?php foreach($funcionarios as $funcionarios):?>
						<tr style="color=<?php echo $ft ?>" bgcolor="<?php echo $bg ?>">
							<td align="center"><?=$funcionarios->codigo?></td>
							<td align="center"><?=$funcionarios->nome?></td>
							<td align="center"><?=$funcionarios->data_nascimento?></td>
							<td align="center"><?=$funcionarios->nome_mae?></td>
							<td align="center"><?=$funcionarios->cpf?></td>
							<td align="center"><?=$funcionarios->rg?></td>
							      <td align="right"><a href="editar_funcionario.php?cpf=<?php echo $registros_select['cpf'];?>" class="btn btn-primary btn-group">Alterar</a>
          <a href="excluir_funcionario.php?cpf=<?php echo $registros_select['cpf'];?>" class="btn btn-danger btn-group" onclick="return confirm('Deseja realmente excluir o funcionário?');">Excluir</a>
      </td>
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