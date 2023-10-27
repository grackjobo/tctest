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