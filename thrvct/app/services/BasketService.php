namespace App\Services;

use App\Models\Product;

class BasketService
{
    protected $products = [];
    protected $deliveryRules = [
        ['max' => 50, 'cost' => 4.95],
        ['max' => 90, 'cost' => 2.95],
        ['max' => INF, 'cost' => 0]
    ];

    public function add($productCode)
    {
        $product = Product::where('code', $productCode)->first();
        if ($product) {
            $this->products[] = $product;
        }
    }

    public function total()
    {
        $total = 0;
        $redWidgetCount = 0;

        foreach ($this->products as $product) {
            if ($product->code == 'R01') {
                $redWidgetCount++;
                if ($redWidgetCount % 2 == 0) {
                    $total += ($product->price / 2);
                } else {
                    $total += $product->price;
                }
            } else {
                $total += $product->price;
            }
        }

        foreach ($this->deliveryRules as $rule) {
            if ($total <= $rule['max']) {
                $total += $rule['cost'];
                break;
            }
        }

        return $total;
    }
}

