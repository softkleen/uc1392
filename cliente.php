<?php
include 'conecta.php';
// criando consulta SQL 
$consultaSql = "SELECT * FROM cliente where deleted is null order by nome, cpf asc";
$consultaSqlArq = "SELECT * FROM cliente where deleted is not null order by nome, cod_cliente asc";

// buscando e listando os dados da tabela (completa)
$lista = $pdo->query($consultaSql);
$listaArq = $pdo->query($consultaSqlArq);
$listaClass = $pdo->query("select cod_classificacao as id, classificacoes as class from classificacao");
// separar em linhas
$row = $lista->fetch();
$rowArq = $listaArq->fetch();
$rowClass = $listaClass->fetch();
// retornando o númaru de linhas
$num_rows = $lista->rowCount();
$num_rows_arq = $listaArq->rowCount();

// busca cliente por código
$nome = "";
$cpf = "";
$cod = 0;
if (isset($_GET['codedit'])) {
    $queryEdit = "SELECT * FROM cliente where cod_cliente=" . $_GET['codedit'];
    $cliente = $pdo->query($queryEdit)->fetch();
    $cod = $_GET['codedit'];
    $nome = $cliente['nome'];
    $cpf = $cliente['cpf'];
}
// comando para incluir campo deleted na tabela cliente
// alter table cliente add deleted datetime null;

// codigo para arquivar(excluir)
if (isset($_GET['codarq'])) {
    $queryArq = "update cliente set deleted = now() where cod_cliente=" . $_GET['codarq'];
    $cliente = $pdo->query($queryArq)->fetch();
    header('location: cliente.php');
}

// restaurar o cliente
if (isset($_GET['codres'])) {
    $queryArq = "update cliente set deleted = null where cod_cliente=" . $_GET['codres'];
    $cliente = $pdo->query($queryArq)->fetch();
    header('location: cliente.php');
}
// remover definitivamente (LGPD)
if (isset($_GET['codexc'])) {
    $queryExc = "delete from cliente where cod_cliente=" . $_GET['codexc'];
    $cliente = $pdo->query($queryExc)->fetch();
    header('location: cliente.php');
}

if (isset($_POST['enviar'])) // inserir ou alterar
{ // insere o cliente
    $nome = $_POST['nome'];
    $cpf =  $_POST['cpf'];
    $consulta = "insert cliente (nome, cpf) values ('$nome','$cpf')";
    $resultado = $pdo->query($consulta);
    $_POST['enviar'] = null;
    header('location: cliente.php');
}
if (isset($_POST['alterar'])) {
    // altera os dados do cliente
    $cod = $_POST['cod-cliente'];
    $nome = $_POST['nome'];
    $cpf =  $_POST['cpf'];
    $updateSql = "update cliente set nome = '$nome', cpf='$cpf' where cod_cliente = $cod";
    $resultado = $pdo->query($updateSql);
    header('location: cliente.php');
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes (<?php echo $num_rows ?>)</title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <!-- <style>
        td{
            border-bottom: 1px solid red;
        }
    </style> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <!-- <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/img1.jpg" class="d-block w-100 img-fluid" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/img2.jpg" class="d-block w-100 img-fluid" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/img3.jpg" class="d-block w-100 img-fluid" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div> -->
    <section class="formulario">

        <div class="card" style="width: 18rem;">
            <img src="img/img4.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Dados Cliente</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Novo +
                </button>
            </div>
        </div>




    </section>
    <h3>Clientes Ativos</h3>
    <table class="table table-striped table-hover">
        <thead>
            <?php if ($num_rows > 0) { ?>
                <th hidden>Cod</th>
                <th>Nome</th>
                <th>CPF</th>
                <th colspan="2">Ações</th>
        </thead>
        <tbody>
            <?php

                do { ?>
                <tr>
                    <td hidden><?php echo $row['cod_cliente']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cpf']; ?></td>
                    <td><a href="cliente.php?codedit=<?php echo $row['cod_cliente']; ?>">Editar</a></td>
                    <td><a href="cliente.php?codarq=<?php echo $row['cod_cliente']; ?>">Arquivar</a></td>

                </tr>
        <?php } while ($row = $lista->fetch());
            } else {
                echo "<tr><td colspan=5>Não há clientes Cadastrados</td></tr>";
            }
        ?>
        </tbody>
    </table>
    <h3>Clientes Arquivados</h3>
    <table class="table">
        <thead>
            <?php
            if ($num_rows_arq > 0) { ?>
                <th hidden>Cod</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Arquivado em</th>
                <th colspan="2">Ações</th>
        </thead>
        <tbody>
            <?php

                do { ?>
                <tr>
                    <td hidden><?php echo $rowArq['cod_cliente']; ?></td>
                    <td><?php echo $rowArq['nome']; ?></td>
                    <td><?php echo $rowArq['cpf']; ?></td>
                    <td><?php echo $rowArq['deleted']; ?></td>
                    <td><a href="cliente.php?codres=<?php echo $rowArq['cod_cliente']; ?>">Restaurar</a></td>
                    <td><a href="cliente.php?codexc=<?php echo $rowArq['cod_cliente']; ?>">Excluir</a></td>

                </tr>
        <?php } while ($rowArq = $listaArq->fetch());
            } else {
                echo "<tr><td colspan=5>Não há clientes arquivados</td></tr>";
            } ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clientes Arquivados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        <div hidden>
                            <label for="cod-cliente">
                                Código
                                <input class="form-control" type="text" name="cod-cliente" value="<?php echo $cod; ?>">
                            </label>
                        </div>
                        <div>
                            <label for="Nome">
                                Nome
                                <input class="form-control" type="text" name="nome" required value="<?php echo $nome; ?>">
                            </label>
                        </div>
                        <div>
                            <label for="cpf">
                                CPF
                                <input class="form-control" type="number" name="cpf" required value="<?php echo $cpf; ?>">
                            </label>
                        </div>

                        <div>
                            <label for="Classificacao">
                                Classificação
                                <select name="class" id="">
                                    <?php do { ?>
                                    <option value="<?php echo $rowClass['id']?>"><?php echo $rowClass['class']?></option>
                                    <?php } while($rowClass = $listaClass->fetch());?>
                                </select>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Envio de documentos</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div>
                            <!-- usamos o if ternário para trocar texto do botão -->
                            <button class="btn btn-success" type="submit" name="<?php echo $cod < 1 ? 'enviar' : 'alterar'; ?>"><?php echo $cod < 1 ? 'Enviar' : 'Alterar'; ?></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    
                    <button type="button" class="btn btn-primary">Restaurar</button>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>