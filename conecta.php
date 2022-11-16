<?php 
include 'config.php';

// dados de acesso banco de dados

// $banco = "db_locadora";
// $server = "127.0.0.1";
// $senha = "";
// $userdb = "root";

try {
    // testa
    $pdo = new PDO("mysql:dbname=".DATABASE.";port=3306;host=".SERVER_DB,USER_DB,SENHA_DB); 
} catch (Exception $e) {
    // caso de falha
    echo "Falha ao conectar ao banco ".DATABASE.". Verifique! - ".$e;
}


?>