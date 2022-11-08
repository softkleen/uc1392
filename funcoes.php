<?php 
function parcelar(float $taxa, int $parcelas=1): float
{   
    $coeficiente = pow((1 + ($taxa/100)), $parcelas)/$parcelas;
    return $coeficiente; // parcelas fixas
}
?>