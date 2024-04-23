<?php

$usuario = 'root';
$senha = '';
$database = 'pRestaurante';
$host = 'localhost';

// Estabelecer conexão com o banco de dados
$conexao = new mysqli($host, $usuario, $senha, $database);

// Verificar se ocorreu algum erro na conexão
if ($conexao->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $conexao->connect_error);
}

// Defina o charset para garantir que os dados sejam tratados corretamente
$conexao->set_charset("utf8");


?>
