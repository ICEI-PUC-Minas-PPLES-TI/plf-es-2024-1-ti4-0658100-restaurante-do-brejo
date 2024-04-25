<?php

require_once '../../vendor/autoload.php';
require_once '../secrets.php';
\Stripe\Stripe::setApiKey($stripeSecretKey);

session_start(); // Inicia a sessão para acessar as variáveis de sessão

if (!isset($_SESSION['id_cliente'])) {
    // Se o ID do cliente não estiver definido na sessão, redirecione para a página de login
    header("Location: login.php");
    exit(); // Encerra o script para evitar execução adicional
}

$userId = $_SESSION['id_cliente']; // Obtém o ID do cliente da sessão

// Conecta ao banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=prestaurante', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro de conexão com o banco de dados: ' . $e->getMessage());
}

// Consulta os itens no carrinho de compras do usuário, incluindo preços e nome do produto da tabela produtos
$stmt = $pdo->prepare("
    SELECT c.id_produto, c.quantidade, p.nome as nome_produto, p.preco
    FROM carrinho c
    JOIN produtos p ON c.id_produto = p.id_produto
    WHERE c.id_usuario = :id_usuario
");
$stmt->execute(['id_usuario' => $userId]);

$line_items = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'brl',
            'product_data' => [
                'name' => $row['nome_produto'],  // Usando o nome do produto da tabela produtos
            ],
            'unit_amount' => $row['preco'] * 100,  // Usando o preço do produto da tabela produtos, convertido em centavos
        ],
        'quantity' => $row['quantidade'],
    ];
}

if (empty($line_items)) {
    die('Não há itens no carrinho.');
}

// Define o domínio
$YOUR_DOMAIN = 'http://localhost';

// Cria a sessão de checkout
try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/projeto1/stripe/public/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . '/projeto1/food.php',
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    die('Erro ao criar sessão de checkout: ' . $e->getMessage());
}

header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>
