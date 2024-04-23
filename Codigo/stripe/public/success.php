<?php
require_once '../../vendor/autoload.php';
require_once '../secrets.php';
\Stripe\Stripe::setApiKey($stripeSecretKey);

session_start(); // Iniciar ou retomar uma sessão

// Verifica se o session_id foi passado
if (empty($_GET['session_id'])) {
    die("Erro: session_id não foi fornecido.");
}
$sessionId = $_GET['session_id'];

// Obtém o ID do usuário da sessão ou define um fallback seguro
$userId = $_SESSION['userId'] ?? 1; // Fallback só para desenvolvimento

try {
    $pdo = new PDO('mysql:host=localhost;dbname=prestaurante', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    // Verificar o status do pagamento com Stripe antes de prosseguir
    $session = \Stripe\Checkout\Session::retrieve($sessionId);
    if ($session->payment_status === 'paid') {
        $stmt = $pdo->prepare("
        SELECT c.id_produto, c.quantidade, p.preco
        FROM carrinho c
        JOIN produtos p ON c.id_produto = p.id_produto
        WHERE c.id_usuario = :id_usuario
    ");
    $stmt->execute(['id_usuario' => $userId]);
    
        $carrinhoItens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$carrinhoItens) {
            throw new Exception("Carrinho está vazio.");
        }

        $total = array_sum(array_map(function ($item) {
            return $item['preco'] * $item['quantidade']; }, $carrinhoItens));

        $stmt = $pdo->prepare("INSERT INTO pedidos (id_cliente, total, status_pedido, data, endereco) VALUES (:id_cliente, :total, 'Pago', NOW(), 'Endereço aqui')");
        $stmt->execute(['id_cliente' => $userId, 'total' => $total]);

        $id_pedido = $pdo->lastInsertId();

        foreach ($carrinhoItens as $item) {
            $stmt = $pdo->prepare("INSERT INTO pedido_produtos (id_pedido, id_produto) VALUES (:id_pedido, :id_produto)");
            $stmt->execute([
                'id_pedido' => $id_pedido,
                'id_produto' => $item['id_produto']
            ]);
        }

        $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_usuario = :id_usuario");
        $stmt->execute(['id_usuario' => $userId]);

        $pdo->commit();
        echo "Pedido realizado com sucesso!";
    } else {
        throw new Exception("Pagamento não confirmado pelo Stripe.");
    }
} catch (\Stripe\Exception\ApiErrorException $stripeException) {
    $pdo->rollBack();
    die("Stripe API Error: " . $stripeException->getMessage());
} catch (PDOException $pdoException) {
    $pdo->rollBack();
    die("Database Error: " . $pdoException->getMessage());
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>