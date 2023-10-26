<?php

interface CalculateTotalCostStrategy {
    public function calculate(array $items): int;
}

interface ShippingCost {
    public function calculate(array $items): int;
}

interface DiscountRule {
    public function appliesTo(Product $product): bool;
    public function getDiscountAmount(int $count, int $productPrice): int;
}