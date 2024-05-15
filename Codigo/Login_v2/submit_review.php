<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id_cliente'])) {
    $id_pedido = $_POST['id_pedido'];
    $nota = $_POST['nota'];
    $comentario = $_POST['comentario'];

    // Insere a avaliação no banco de dados
    $stmt = $conexao->prepare("INSERT INTO avaliacoes_pedidos (id_pedido, id_cliente, nota, comentario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $id_pedido, $_SESSION['id_cliente'], $nota, $comentario);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Avaliação enviada com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar avaliação.']);
    }
    $stmt->close();
    $conexao->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requisição inválida.']);
}
?>
