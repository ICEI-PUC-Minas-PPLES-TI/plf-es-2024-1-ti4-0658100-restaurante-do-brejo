<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../delete_cart_item.php';

class DeleteCartItemTest extends TestCase {
    public function testDeleteCartItemValidId() {
        $result = deleteCartItem(1);
        $this->assertTrue($result);
    }

    public function testDeleteCartItemInvalidId() {
        $result = deleteCartItem(-1);
        $this->assertFalse($result);
    }

    public function testDeleteCartItemZeroId() {
        $result = deleteCartItem(0);
        $this->assertFalse($result);
    }
}
