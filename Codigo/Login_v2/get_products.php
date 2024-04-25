<?php
// Conecta ao banco de dados
include 'config.php';

$sql = "SELECT * FROM produtos";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nome']}</td><td>{$row['preco']}</td><td>{$row['categoria']}</td><td>{$row['descricao']}</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>Nenhum produto encontrado</td></tr>";
}
?>
