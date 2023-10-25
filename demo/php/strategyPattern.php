<?php

interface CalculateTotalCostStrategy {
	public function calculate(array $items): int;
}

Class DiscountCodeStrategy implements CalculateTotalCostStrategy {
    public function calculate(array $items): int {
        $redWidgetCount = 0;
        $totalCost = 0;

        /** @var Product $item */
        foreach ($items as $item) {
            $totalCost += $item->getPrice();

            if ($item->getCode() === 'R01') {
                $redWidgetCount++;
            }
        }

        // Calculate the discount for every two Red Widgets
        $redWidgetDiscountAmount = 0;
        foreach ($items as $item) {
            if ($item->getCode() === 'R01' && $redWidgetCount >= 2) {
                $redWidgetDiscountAmount += ceil($item->getPrice() / 2);
                $redWidgetCount -= 2;
            }
        }

        return $totalCost - $redWidgetDiscountAmount;
    }
}


class ShippingCostStrategy implements CalculateTotalCostStrategy {
	/** @var DeliveryRule[] */
	private array $deliveryRules;

	public function __construct(array $deliveryRules) {
		$this->deliveryRules = $deliveryRules;
	}

	public function calculate(array $items): int {
		$totalCost = 0;

		/** @var Product $item */
		foreach ($items as $item) {
			$totalCost += $item->getPrice();
		}

		$deliveryCost = 0;
		foreach ($this->deliveryRules as $rule) {
			if ($totalCost >= $rule->getThreshold()) {
				$deliveryCost = $rule->getCost();
				break;
			}
		}

		return $deliveryCost; 
	}
}

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
	/** @var Product[] */
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

	public function calculateTotalCost(CalculateTotalCostStrategy $strategy): int {
		return $strategy->calculate($this->items);
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


// Scenario 1: B1+G1
$basket1 = new Basket($products, $deliveryRules);
$basket1->addProductByCode('B01');
$basket1->addProductByCode('G01');
echo "Total for B01, G01 (37.85)$" . number_format(($basket1->calculateTotalCost(new DiscountCodeStrategy()) + $basket1->calculateTotalCost(new ShippingCostStrategy($deliveryRules))) / 100, 2) . "\n";
echo "\n";

// Scenario 2: R01, R01
$basket2 = new Basket($products, $deliveryRules);
$basket2->addProductByCode('R01');
$basket2->addProductByCode('R01');
echo "Total for 01, R01: (54.37)$" . number_format(($basket2->calculateTotalCost(new DiscountCodeStrategy()) + $basket2->calculateTotalCost(new ShippingCostStrategy($deliveryRules))) / 100, 2) . "\n";
echo "\n";

// Scenario 3: R01, G01
$basket3 = new Basket($products, $deliveryRules);
$basket3->addProductByCode('R01');
$basket3->addProductByCode('G01');
echo "Total for R01, G01:(60.85) $" . number_format(($basket3->calculateTotalCost(new DiscountCodeStrategy()) + $basket3->calculateTotalCost(new ShippingCostStrategy($deliveryRules))) / 100, 2) . "\n";
echo "\n";

// Scenario 4: B01, B01, R01, R01, R01
$basket4 = new Basket($products, $deliveryRules);
$basket4->addProductByCode('B01');
$basket4->addProductByCode('B01');
$basket4->addProductByCode('R01');
$basket4->addProductByCode('R01');
$basket4->addProductByCode('R01');
echo "Total for B01, B01, R01, R01, R01: (98.27)$" . number_format(($basket4->calculateTotalCost(new DiscountCodeStrategy()) + $basket4->calculateTotalCost(new ShippingCostStrategy($deliveryRules))) / 100, 2) . "\n";
echo "\n";
?>
TEst!