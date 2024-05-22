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

// Pegue os dados da requisição
$id_reserva = $_POST['id_reserva'];
$status = $_POST['status'];

// Atualize o status da reserva
$sql = "UPDATE reservas SET status = ? WHERE id_reserva = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id_reserva);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

// Retorne a resposta em formato JSON
echo json_encode($response);
?>
