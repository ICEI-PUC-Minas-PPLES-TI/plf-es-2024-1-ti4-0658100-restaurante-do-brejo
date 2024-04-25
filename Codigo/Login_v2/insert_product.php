<?php
// Conexão com o banco de dados (altere de acordo com as suas configurações)
include_once('config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];

    // Verifica se um arquivo de imagem foi enviado
    if ($_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_nome = $_FILES['imagem']['name'];
        
        // Move a imagem para o diretório desejado
        $caminho_imagem = "images/produtos/" . $imagem_nome;
        move_uploaded_file($imagem_tmp, $caminho_imagem);
    } else {
        // Caso não seja enviada uma imagem, você pode definir um valor padrão para o caminho da imagem
        $caminho_imagem = ""; // Altere para o valor padrão desejado
    }

    // Insere os dados do produto no banco de dados
    $sql = "INSERT INTO produtos (nome, preco, categoria, descricao, caminho_img) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sdsss", $nome, $preco, $categoria, $descricao, $caminho_imagem);

    if ($stmt->execute()) {
        echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        echo "<script>window.location.href='gerenciamentoMenu.php';</script>";
    } else {
        echo "Erro ao cadastrar o produto: " . $conexao->error;
    }
}
?>
