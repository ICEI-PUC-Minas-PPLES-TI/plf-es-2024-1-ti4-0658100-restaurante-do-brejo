<?php
session_start();

// Checa se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit();
}

// Importar configuração de conexão
include 'config.php';

// Checar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura dados do formulário
    $comentario = $_POST['comentario'];
    $nota = $_POST['nota'];
    $id_cliente = $_SESSION['id_cliente']; // Supõe que o ID do cliente esteja armazenado na sessão

    // Preparar a query para inserção no banco de dados
    $sql = "INSERT INTO avaliacao_rest (id_avaliacaorest, nome, comentario, nota) VALUES (?, ?, ?)";

    if ($stmt = $conexao->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("isi", $id_cliente, $comentario, $nota);

        // Executa a query
        if ($stmt->execute()) {
            echo "Avaliação enviada com sucesso!";
        } else {
            echo "Erro ao enviar avaliação: " . $stmt->error;
        }

        // Fecha statement
        $stmt->close();
    } else {
        echo "Erro ao preparar statement: " . $conexao->error;
    }

    // Fecha a conexão
    $conexao->close();
} else {
    // Redireciona o usuário de volta ao formulário se o método não for POST
    header('Location: avaliacao_form.php');
    exit();
}
?>
