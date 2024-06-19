<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../index.php';

class IndexTest extends TestCase {
    public function testGetIndexPageContentNotEmpty() {
        $content = getIndexPageContent();
        $this->assertNotEmpty($content);
    }

    public function testGetIndexPageContentIsString() {
        $content = getIndexPageContent();
        $this->assertIsString($content);
    }

    public function testGetIndexPageContentContainsWelcomeMessage() {
        $content = getIndexPageContent();
        $this->assertStringContainsString("Welcome to Our Restaurant", $content);
    }
}
