<?php

interface DiscountRule {
    public function appliesTo(Product $product): bool;
    public function getDiscountAmount(int $count, int $productPrice): int;
}

class RedWidgetDiscountRule implements DiscountRule {
    private string $productCode;
    private int $discountQuantityThreshold;
    private float $discountFraction;

    public function __construct(string $productCode = 'R01', int $discountQuantityThreshold = 2, float $discountFraction = 0.5) {
        $this->productCode = $productCode;
        $this->discountQuantityThreshold = $discountQuantityThreshold;
        $this->discountFraction = $discountFraction;
    }

    public function appliesTo(Product $product): bool {
        return $product->getCode() === $this->productCode;
    }

    public function getDiscountAmount(int $count, int $productPrice): int {
        if ($count >= $this->discountQuantityThreshold) {
            return (int) ceil($productPrice * $this->discountFraction);
        }
        return 0;
    }
}

interface CalculateTotalCostStrategy {
    public function calculate(array $items): int;
}

class DiscountCodeStrategy implements CalculateTotalCostStrategy {
    private DiscountRule $discountRule;

    public function __construct(DiscountRule $discountRule) {
        $this->discountRule = $discountRule;
    }

    /**
     * Calculate the total cost after applying discount.
     * The discount logic needs to be moved to a separate class but there's an interdependency between the discount logic and the shipping logic.  
     * @param Product[] $items An array of Product objects
     * @return int The total cost
     */
    public function calculate(array $items): int {
        $totalCost = 0;
        $discountAmount = 0;
        $redWidgetCount = 0;

        foreach ($items as $item) {
            $totalCost += $item->getPrice();
            if ($this->discountRule->appliesTo($item)) {
                $redWidgetCount++;
            }
        }

        $redWidgetCountCopy = $redWidgetCount;
        foreach ($items as $item) {
            if ($this->discountRule->appliesTo($item) && $redWidgetCountCopy >= 2) {
                $discountAmount += $this->discountRule->getDiscountAmount($redWidgetCountCopy, $item->getPrice());
                $redWidgetCountCopy -= 2;
            }
        }

        return $totalCost - $discountAmount;
    }
}

// Assuming a Product class exists, it must at least implement the following methods:
// - getPrice(): int
// - getCode(): string
