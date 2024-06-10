<?php
include_once ('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['id_produto'];
    $userId = $_SESSION['id_cliente'] ;  // Supondo que você esteja rastreando o ID do usuário

    $query = "DELETE FROM carrinho WHERE id_produto = ? AND id_cliente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $productId, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Item deletado com sucesso.";
    } else {
        echo "Falha ao deletar o item.";
    }
    $stmt->close();
    $conn->close();
}
?>
