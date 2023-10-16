interface PricingRule {
    public function calculatePrice($basket);
}

interface DiscountRule {
    public function applyDiscount($basket);
}

interface DeliveryRule {
    public function calculateDelivery($basketTotal);
}

