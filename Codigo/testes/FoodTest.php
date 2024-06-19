<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../food.php';

class FoodTest extends TestCase {
    public function testGetFoodItemsNotEmpty() {
        $items = getFoodItems();
        $this->assertNotEmpty($items);
    }

    public function testGetFoodItemsIsArray() {
        $items = getFoodItems();
        $this->assertIsArray($items);
    }

    public function testGetFoodItemsHasCorrectStructure() {
        $items = getFoodItems();
        foreach ($items as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('price', $item);
        }
    }
}
