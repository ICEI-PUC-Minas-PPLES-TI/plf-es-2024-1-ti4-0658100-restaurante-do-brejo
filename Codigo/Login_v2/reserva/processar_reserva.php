<?php
// Dados de conexão ao banco de dados
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pRestaurante';


// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegue os dados do formulário
$data = $_POST['data'];
$hora = $_POST['hora'];
$capacidade_mesa = $_POST['capacidade_mesa'];
$id_cliente = 1; // Substitua com o ID real do cliente logado

// Prepare a consulta SQL
$sql = "INSERT INTO reservas (id_cliente, data, hora, capacidade_mesa) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $id_cliente, $data, $hora, $capacidade_mesa);

// Execute a consulta
if ($stmt->execute()) {
    $_SESSION['message'] = "Reserva realizada com sucesso!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Erro: " . $stmt->error;
    $_SESSION['message_type'] = "error";
}

// Feche a conexão
$stmt->close();
$conn->close();

// Redirecione de volta para a página de reservas
header("Location: index.php");
exit();
?>
