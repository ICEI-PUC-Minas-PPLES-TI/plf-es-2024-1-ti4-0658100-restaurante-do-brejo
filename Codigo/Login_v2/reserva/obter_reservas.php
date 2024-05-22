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
    error_log("Conexão falhou: " . $conn->connect_error);
    die(json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]));
}

// ID do cliente logado (substitua com o ID real do cliente logado)
$id_cliente = 1;

// Consulta SQL para pegar as reservas do cliente logado em ordem decrescente de data e hora
$sql = "SELECT data, hora, capacidade_mesa, status FROM reservas WHERE id_cliente = ? ORDER BY data DESC, hora DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Erro ao preparar statement: " . $conn->error);
    die(json_encode(['error' => 'Erro ao preparar statement: ' . $conn->error]));
}
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

// Feche a conexão
$stmt->close();
$conn->close();

// Retorne os dados em formato JSON
echo json_encode($reservas);
?>
