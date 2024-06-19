<?php
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase {
    protected $conn;

    protected function setUp(): void {
        require __DIR__ . '/../config.php'; // Caminho para o arquivo config.php
        $this->conn = $conn;
    }

    public function testDatabaseConnection() {
        $this->assertFalse($this->conn->connect_error, "Conexão com o banco de dados falhou: " . $this->conn->connect_error);
    }

    public function testCharsetIsUtf8() {
        $charset = $this->conn->character_set_name();
        $this->assertEquals('utf8', $charset, "O charset deve ser utf8, mas é $charset");
    }

    protected function tearDown(): void {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
