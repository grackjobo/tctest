namespace App\Http\Controllers;

use App\Services\BasketService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function add(Request $request)
    {
        $productCode = $request->input('product_code');
        $this->basketService->add($productCode);

        return response()->json(['message' => 'Product added successfully.']);
    }

    public function total()
    {
        $total = $this->basketService->total();

        return response()->json(['total' => $total]);
    }
}


