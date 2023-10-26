<?php

class ShippingCostStrategy implements ShippingCost {
    private array $deliveryRules;

    public function __construct(array $deliveryRules) {
        $this->deliveryRules = $deliveryRules;
    }

    public function calculate(array $items): int {
        $totalCostBeforeShipping = 0;
        foreach ($items as $item) {
            $totalCostBeforeShipping += $item->getPrice();
        }

        return $this->calculateBasedOnDiscountedPrice($totalCostBeforeShipping);
    }

    public function calculateBasedOnDiscountedPrice(int $discountedPrice): int {
        $shippingCost = 0;
        foreach ($this->deliveryRules as $rule) {
            if ($discountedPrice >= $rule->getThreshold()) {
                $shippingCost = $rule->getCost();
                break;
            }
        }

        return $shippingCost;
    }
}