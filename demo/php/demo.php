<?php
require_once 'interfaces.php';
require_once 'discounts.php';
require_once 'shipping.php';	

class Product {
    private string $name;
    private string $code;
    private int $price;

    public function __construct(string $name, string $code, int $price) {
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getPrice(): int {
        return $this->price;
    }
}

class DeliveryRule {
    private int $threshold;
    private int $cost;

    public function __construct(int $threshold, int $cost) {
        $this->threshold = $threshold;
        $this->cost = $cost;
    }

    public function getThreshold(): int {
        return $this->threshold;
    }

    public function getCost(): int {
        return $this->cost;
    }
}

class Basket {
    private array $items = [];
    private array $deliveryRules;
    private array $productData;

    public function __construct(array $products, array $deliveryRules) {
        $this->productData = $products;
        $this->deliveryRules = $deliveryRules;
    }

    public function addProductByCode(string $code): void {
        foreach ($this->productData as $product) {
            if ($product->getCode() === $code) {
                $this->items[] = $product;
                return;
            }
        }
    }

    public function calculateTotalCostWithShipping(CalculateTotalCostStrategy $discountStrategy, ShippingCostStrategy $shippingStrategy): int {
        $totalCostAfterDiscount = $discountStrategy->calculate($this->items);
        $shippingCost = $shippingStrategy->calculateBasedOnDiscountedPrice($totalCostAfterDiscount);

        return $totalCostAfterDiscount + $shippingCost;
    }
}

// Sample Usage
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

// Scenario 1: B1+G1
$basket1 = new Basket($products, $deliveryRules);
$basket1->addProductByCode('B01');
$basket1->addProductByCode('G01');
echo "Total for B01, G01: " . number_format($basket1->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy) / 100, 2) . "\n";

// Scenario 2: R01, R01
$basket2 = new Basket($products, $deliveryRules);
$basket2->addProductByCode('R01');
$basket2->addProductByCode('R01');
echo "Total for R01, R01: " . number_format($basket2->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy) / 100, 2) . "\n";

// Scenario 3: R01, G01
$basket3 = new Basket($products, $deliveryRules);
$basket3->addProductByCode('R01');
$basket3->addProductByCode('G01');
echo "Total for R01, G01: " . number_format($basket3->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy) / 100, 2) . "\n";

// Scenario 4: B01, B01, R01, R01, R01
$basket4 = new Basket($products, $deliveryRules);
$basket4->addProductByCode('B01');
$basket4->addProductByCode('B01');
$basket4->addProductByCode('R01');
$basket4->addProductByCode('R01');
$basket4->addProductByCode('R01');
echo "Total for B01, B01, R01, R01, R01: " . number_format($basket4->calculateTotalCostWithShipping($discountStrategy, $shippingStrategy) / 100, 2) . "\n";

