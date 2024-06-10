<?php
include_once('config.php');
session_start();
$_SESSION['id_cliente'] ;
$userId = $_SESSION['id_cliente'] ?? 0;  // Certifique-se de que o usuário esteja logado
$id_produto = $_GET['id_produto'] ?? 0;
$quantidade = 1;  // Este é o valor padrão para adicionar ao carrinho

if ($userId > 0 && $id_produto > 0) {
    // Primeiro, verifique se o produto já está no carrinho
    $checkStmt = $conn->prepare("SELECT quantidade FROM carrinho WHERE id_usuario = ? AND id_produto = ?");
    $checkStmt->bind_param("ii", $userId, $id_produto);
    $checkStmt->execute();
    $resultado = $checkStmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Produto já está no carrinho, atualize a quantidade
        $row = $resultado->fetch_assoc();
        $quantidade += $row['quantidade'];
        $updateStmt = $conn->prepare("UPDATE carrinho SET quantidade = ?, data_hora = NOW() WHERE id_usuario = ? AND id_produto = ?");
        $updateStmt->bind_param("iii", $quantidade, $userId, $id_produto);
        $updateStmt->execute();
    } else {
        // Produto não está no carrinho, adicione um novo
        $insertStmt = $conn->prepare("INSERT INTO carrinho (id_usuario, id_produto, quantidade, data_hora) VALUES (?, ?, ?, NOW())");
        $insertStmt->bind_param("iii", $userId, $id_produto, $quantidade);
        $insertStmt->execute();
    }

    // Verifique se a operação foi bem-sucedida e redirecione
    if (isset($updateStmt) && $updateStmt->affected_rows > 0 || isset($insertStmt) && $insertStmt->affected_rows > 0) {
        header("Location: food.php?status=success");
        exit();
    } else {
        header("Location: food.php?status=error");
        exit();
    }
} else {
    header("Location: food.php?status=error");
    exit();
}


?>
