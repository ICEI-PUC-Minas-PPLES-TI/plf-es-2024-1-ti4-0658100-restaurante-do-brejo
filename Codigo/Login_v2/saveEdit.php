<?php

session_start();

include_once('config.php'); // Inclua sua conexão ao banco de dados

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Obtenha os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $papel = $_POST['papel'];

    // Prepare a declaração SQL para atualizar os dados do usuário
    $sql = "UPDATE usuarios SET nome = ?, email = ?, papel = ? WHERE id = ?";

    if ($stmt = $conexao->prepare($sql)) {
        // Vincule os parâmetros (s = string, i = integer)
        $stmt->bind_param("sssi", $nome, $email, $papel, $id);

        // Execute a declaração preparada
        if ($stmt->execute()) {
            // Se os dados forem atualizados com sucesso, redirecione ou exiba uma mensagem
            header('Location: paginaAdm.php');
            // Opção: Redirecione de volta à página de listagem
            // header('Location: nome_da_sua_pagina_de_listagem.php');
            // exit;
        } else {
            // Se houver um problema ao atualizar o usuário, exiba uma mensagem de erro
            echo "Erro ao atualizar o usuário.";
        }
    } else {
        // Se houver um problema ao preparar a declaração, exiba uma mensagem de erro
        echo "Erro ao preparar a declaração.";
    }
} else {
    // Se o formulário não foi enviado ou o ID está faltando, exiba uma mensagem de erro
    echo "Formulário inválido ou ID faltando.";
}

?>
