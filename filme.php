<?php 
include 'conecta.php';

// cria a consulta sql
$consulta = "select * from filme funcionario where demissao is null";

// trazer as lista completa dos dados
$lista = $pdo->query($consulta);

// separar os dados em linhas
$linha = $lista->fetch();
$num_linhas = $lista->rowCount();

//echo 'A consulta retornou <strong>'.$num_linhas.'</strong> Filmes <br>';

// do {
//     echo $linha['titulo'].' - '.$linha['lancamento'].'<br>';
// } while ($linha = $lista->fetch());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes <?php echo '('.$num_linhas.')' ?></title>
    <style>
        td{
            border-bottom: 1px solid blue;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <th>ID</th>
            <th>Título</th>
            <th>Sinopse</th>
            <th>Lançamento</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td><?php echo $linha['cod_filme']?></td>  
                    <td><?php echo $linha['titulo']?></td>
                    <td><?php echo $linha['sinopse']?></td>
                    <td><?php echo $linha['lancamento']?></td>
                </tr>
            <?php } while ($linha = $lista->fetch());?>
        </tbody>
    </table>
</body>
</html>