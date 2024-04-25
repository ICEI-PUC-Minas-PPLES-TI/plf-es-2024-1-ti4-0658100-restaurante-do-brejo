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

// Obtém o ID do cliente da sessão ou define um fallback seguro
$id_cliente = $_SESSION['id_cliente'] ; // Fallback só para desenvolvimento

try {
    // Conecta ao banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=prestaurante', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    // Verificar o status do pagamento com Stripe antes de prosseguir
    $session = \Stripe\Checkout\Session::retrieve($sessionId);
    if ($session->payment_status === 'paid') {
        // Recupera o endereço do cliente do URL de sucesso
        $endereco = $_GET['address'] ?? 'Endereço não especificado';

        // Consulta o endereço do cliente na tabela de usuários
        $stmt = $pdo->prepare("SELECT endereco FROM usuarios WHERE id = :id_cliente");
        $stmt->execute(['id_cliente' => $id_cliente]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o endereço do cliente foi encontrado
        if (!$cliente || empty($cliente['endereco'])) {
            throw new Exception("Endereço do cliente não encontrado.");
        }

        // Consulta os itens no carrinho de compras do cliente
        $stmt = $pdo->prepare("
            SELECT c.id_produto, c.quantidade, p.preco
            FROM carrinho c
            JOIN produtos p ON c.id_produto = p.id_produto
            WHERE c.id_usuario = :id_cliente
        ");
        $stmt->execute(['id_cliente' => $id_cliente]);

        // Recupera todos os itens do carrinho
        $carrinhoItens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$carrinhoItens) {
            throw new Exception("Carrinho está vazio.");
        }

        // Calcula o total do pedido
        $total = array_sum(array_map(function ($item) {
            return $item['preco'] * $item['quantidade'];
        }, $carrinhoItens));

        // Insere o pedido no banco de dados
        $stmt = $pdo->prepare("INSERT INTO pedidos (id_cliente, total, status_pedido, data, endereco) VALUES (:id_cliente, :total, 'Pago', NOW(), :endereco)");
        $stmt->execute([
            'id_cliente' => $id_cliente,
            'total' => $total,
            'endereco' => $cliente['endereco'] // Usando o endereço do cliente
        ]);

        // Restante do código para inserir itens do pedido, limpar carrinho, etc.
        // ...

        // Limpa o carrinho do cliente
        $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_usuario = :id_cliente");
        $stmt->execute(['id_cliente' => $id_cliente]);

        // Confirma a transação do banco de dados
        $pdo->commit();

        // Redireciona para a página principal ou para outra página de sucesso
        header('Location: ../../Login_v2/indexLogado.php');
        exit();
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
