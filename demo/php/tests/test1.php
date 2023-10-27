<?php

require_once 'strategyPattern.php';
require_once 'interfaces.php';
require_once 'discounts.php';
require_once 'shipping.php';	

use PHPUnit\Framework\TestCase;

class test1 extends TestCase {
    private $products;
    private $deliveryRules;

    protected function setUp(): void {
        // Initialize Products
        $this->products = [
            new Product('Red Widget', 'R01', 3295),
            new Product('Green Widget', 'G01', 2495),
            new Product('Blue Widget', 'B01', 795)
        ];

        // Initialize Delivery Rules
        $this->deliveryRules = [
            new DeliveryRule(9000, 0),
            new DeliveryRule(5000, 295),
            new DeliveryRule(0, 495)
        ];
    }

    public function testScenarioOneTotalCost() {
        $basket = new Basket($this->products, $this->deliveryRules);
        $redWidgetDiscount = new RedWidgetDiscountRule();
        $discountStrategy = new DiscountCodeStrategy($redWidgetDiscount);
        $shippingStrategy = new ShippingCostStrategy($this->deliveryRules);

        // Adding products to basket as per scenario 1: B01 + G01
        $basket->addProductByCode('B01');
        $basket->addProductByCode('G01');

        // Calculate total cost
        $totalCost = $basket->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy);

        // Assert
        // Expected total: 3785
        $this->assertEquals(3785, $totalCost);
    }
}
