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

// Consulta SQL para pegar todas as reservas
$sql = "SELECT id_reserva, id_cliente, data, hora, capacidade_mesa, status FROM reservas";
$result = $conn->query($sql);

$reservas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

$conn->close();

// Retorne os dados em formato JSON
echo json_encode($reservas);
?>
