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
    die(json_encode(['success' => false, 'error' => 'Conexão falhou: ' . $conn->connect_error]));
}

// Obtenha os dados enviados via POST
$id_pedido = $_POST['id_pedido'];
$status_pedido = $_POST['status_pedido'];

// Prepare a consulta SQL para atualizar o status do pedido
$sql = "UPDATE pedidos SET status_pedido = ? WHERE id_pedido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status_pedido, $id_pedido);

// Execute a consulta e verifique se teve sucesso
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

// Feche a conexão
$stmt->close();
$conn->close();
?>
