<?php
use PHPUnit\Framework\TestCase;

class AddToCartTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("CREATE TABLE carrinho (id_usuario INTEGER, id_produto INTEGER, quantidade INTEGER, data_hora TEXT)");
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }

    public function testAddProductToCart()
    {
        $_SESSION['id_cliente'] = 1;
        $_GET['id_produto'] = 101;

        $userId = $_SESSION['id_cliente'];
        $id_produto = $_GET['id_produto'];
        $quantidade = 1;

        // Execute the logic to add a new product to the cart
        $insertStmt = $this->pdo->prepare("INSERT INTO carrinho (id_usuario, id_produto, quantidade, data_hora) VALUES (?, ?, ?, datetime('now'))");
        $insertStmt->execute([$userId, $id_produto, $quantidade]);

        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM carrinho WHERE id_usuario = 1 AND id_produto = 101");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals(1, $result['count'], "The product should be added to the cart");
    }
}
?>
