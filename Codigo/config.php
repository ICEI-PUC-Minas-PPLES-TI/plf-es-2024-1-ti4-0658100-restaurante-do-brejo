<?php

$usuario = 'root';
$senha = '';
$database = 'pRestaurante';
$host = 'localhost';

// Estabelecer conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $database);

// Verificar se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $conn->connect_error);
}

// Defina o charset para garantir que os dados sejam tratados corretamente
$conn->set_charset("utf8");

?>
