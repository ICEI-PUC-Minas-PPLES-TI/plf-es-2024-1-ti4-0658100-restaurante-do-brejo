<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, password TEXT)");
        $this->pdo->exec("INSERT INTO users (username, password) VALUES ('testuser', '" . password_hash('password123', PASSWORD_DEFAULT) . "')");
        $_POST = [];
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }

    public function testSuccessfulLogin()
    {
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'password123';

        ob_start();
        include '/mnt/data/login.php';
        ob_end_clean();

        $this->assertTrue($_SESSION['loggedin']);
        $this->assertEquals('testuser', $_SESSION['username']);
    }

    public function testFailedLogin()
    {
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'wrongpassword';

        ob_start();
        include '/mnt/data/login.php';
        $output = ob_get_clean();

        $this->assertArrayNotHasKey('loggedin', $_SESSION);
        $this->assertStringContainsString('Invalid password', $output);
    }
}
?>
