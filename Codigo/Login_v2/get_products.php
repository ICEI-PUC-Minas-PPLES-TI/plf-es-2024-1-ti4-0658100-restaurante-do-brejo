<?php
// Inclua o arquivo de configuração para estabelecer a conexão com o banco de dados
include 'config.php';

// Consulta SQL para selecionar todos os produtos
$sql = "SELECT nome, preco, categoria, descricao, atividade FROM produtos";
$result = $conn->query($sql);

// Array para armazenar os resultados
$product_data = array();

// Verifique se existem resultados
if ($result->num_rows > 0) {
    // Loop através dos resultados e adicione-os ao array
    while($row = $result->fetch_assoc()) {
        $product_data[] = $row;
    }
}

// Feche a conexão com o banco de dados
$conn->close();

// Configure o cabeçalho para indicar que os dados são JSON
header('Content-Type: application/json');

// Retorne os dados como JSON
echo json_encode($product_data);
?>
