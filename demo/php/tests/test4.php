<?php
require_once 'strategyPattern.php';
require_once 'interfaces.php';
require_once 'discounts.php';
require_once 'shipping.php';	

use PHPUnit\Framework\TestCase;

class test4 extends TestCase {
    public function testBasketWithB01B01R01R01R01() {
        // Setup
        $products = [
            new Product('Red Widget', 'R01', 3295),
            new Product('Green Widget', 'G01', 2495),
            new Product('Blue Widget', 'B01', 795)
        ];

        $deliveryRules = [
            new DeliveryRule(9000, 0),
            new DeliveryRule(5000, 295),
            new DeliveryRule(0, 495)
        ];

        $redWidgetDiscount = new RedWidgetDiscountRule();
        $discountStrategy = new DiscountCodeStrategy($redWidgetDiscount);
        $shippingStrategy = new ShippingCostStrategy($deliveryRules);

        // Test B01 + B01 + R01 + R01 + R01 scenario
        $basket = new Basket($products, $deliveryRules);
        $basket->addProductByCode('B01');
        $basket->addProductByCode('B01');
        $basket->addProductByCode('R01');
        $basket->addProductByCode('R01');
        $basket->addProductByCode('R01');

        // Total cost calculation
        $totalCost = $basket->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy);

        // Expected value calculation
        // 2x Blue Widgets (B01) at 795 each = 1590
        // 3x Red Widgets (R01) at 3295 each = 9885
        // Total before discounts = 11475
        // Discount on 2 Red Widgets = ceil(3295 * 0.5) = 1648
        // Total after discount = 11475 - 1648 = 9827
        // Since the total cost before shipping (9827) is > 5000, the shipping cost is 295.
        // Expected total = 9827 (no shipping cost)
        $expectedCost = 9827;

        $this->assertEquals($expectedCost, $totalCost, "Total cost does not match expected for B01, B01, R01, R01, R01 scenario.");
    }
}
