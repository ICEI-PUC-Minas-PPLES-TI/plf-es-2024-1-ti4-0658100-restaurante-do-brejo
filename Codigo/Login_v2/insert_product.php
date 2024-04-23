<?php
// Inclua o arquivo de configuração para estabelecer a conexão com o banco de dados
include 'config.php';

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];

    // Prepare a instrução SQL para inserir os dados
    $sql = "INSERT INTO produtos (nome, preco, categoria, descricao, atividade) VALUES ('$nome', '$preco', '$categoria', '$descricao', 'ativo')";

    // Execute a instrução SQL
    if ($conn->query($sql) === TRUE) {
        // Se a inserção for bem-sucedida, retorne uma resposta JSON indicando sucesso
        echo json_encode(array("success" => true));
    } else {
        // Se houver algum erro, retorne uma resposta JSON indicando o erro
        echo json_encode(array("success" => false, "error" => $conn->error));
    }
} else {
    // Se o formulário não foi submetido, retorne uma resposta JSON indicando um erro
    echo json_encode(array("success" => false, "error" => "Formulário não submetido"));
}

// Feche a conexão com o banco de dados
$conn->close();
?>
