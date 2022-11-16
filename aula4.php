<?php
include('config.php');
include('funcoes.php');

$parcelas = array();
$coeficiente = 0.0;
if(isset($_POST['calcular']))
{
    $capital = $_POST['capital'];
    $taxa    = $_POST['taxa'];
    $parcela = $_POST['parcela'];
    $coeficiente = parcelar(floatval($taxa), intval($parcela));
    $dias = 30;
    $montante = $coeficiente*$capital*$parcela;
    for ($i=0; $i < $parcela; $i++) { 
        $parcelas[$i] = [($i+1).'ª',($coeficiente*floatval($capital)),new DateTime('+'.$dias.'days')];    
        $dias += 30; //$dias = $dias + 30;
    }  

    //print_r($parcelas);
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Parcelamento</title>
</head>
<body>

    <form action="#" method="post">
        <input type="text" name="capital" placeholder="Capital (R$)..."><br>
        <input type="text" name="taxa" placeholder="Taxa (%)..."><br>
        <input type="text" name="parcela" placeholder="Parcelas (1)..."><br>
        <button type="submit" name="calcular">Calcular</button>
    </form>
    <br><hr>
    <?php if(count($parcelas)>0) {?>
        <h4>Valor da Capital: R$ <?php echo number_format($capital,2,',','.'); ?></h4>
        <h4>Taxa de juro: <?php echo number_format($taxa,2,',','.'); ?> %</h4>
        <h4>Parcelas: <?php echo $parcela; ?> meses</h4>
        <h4>Total do Financiamento: R$ <?php echo number_format($montante,2,',','.'); ?></h4>
    <table class="tabelinha">
        <th>#</th>
        <th>Valor</th>
        <th>Vencimento</th>

    <?php foreach ($parcelas as $valores) { ?>
            <tr>
                <td><?php echo($valores[0]);?></td>
                <td>R$ <?php echo number_format($valores[1],2,',','.'); ?></td>
                <td><?php echo $valores[2]->format('d-m-Y');?></td>
            </tr>
        <?php }?>
    </table>
    <?php } ?>
</body>
</html>