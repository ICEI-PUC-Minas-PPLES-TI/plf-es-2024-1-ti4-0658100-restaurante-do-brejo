<?php

session_start();  // Inicia a sessão

// Verifica se o usuário não está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');  // Redireciona para a página de login
    exit();  // Encerra a execução do script
}

// Importar configuração de conexão
include 'config.php';

// Checar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura dados do formulário
    $nome = $_POST['nome'];
    $comentario = $_POST['comentario'];
    $nota = $_POST['nota'];

    // Preparar a query para inserção no banco de dados
    $sql = "INSERT INTO avaliacao_rest (nome, comentario, nota) VALUES (?, ?, ?)";

    if ($stmt = $conexao->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $nome, $comentario, $nota);
        // Executa a query
        if ($stmt->execute()) {
            // Redireciona com sucesso
            header('Location: avaliacao.php?status=success');
        } else {
            // Redireciona com erro
            header('Location: avaliacao.php?status=error&message=' . urlencode($stmt->error));
        }
        // Fecha statement
        $stmt->close();
    } else {
        // Redireciona com erro de preparação
        header('Location: avaliacao.php?status=error&message=' . urlencode($conexao->error));
    }

    // Fecha a conexão
    $conexao->close();
    exit();
} else {
    // Redireciona o usuário de volta ao formulário se o método não for POST
    header('Location: avaliacao.php');
    exit();
}
?>
