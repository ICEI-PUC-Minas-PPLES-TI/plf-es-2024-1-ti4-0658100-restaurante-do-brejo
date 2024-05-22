<?php
header('Content-Type: application/json');

// Inclua o arquivo de configuração
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pRestaurante';

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]));
}

// Consulta SQL para pegar todos os pedidos
$sql = "SELECT id_pedido, id_cliente, total, status_pedido, data, endereco FROM pedidos";
$result = $conn->query($sql);

$pedidos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['total'] = floatval($row['total']); // Assegura que o total é um número
        $pedidos[] = $row;
    }
}

$conn->close();

// Retorne os dados em formato JSON
echo json_encode($pedidos);
?>
