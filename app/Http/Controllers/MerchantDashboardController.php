namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->count();
        $discounts = Discount::where('user_id', $user->id)->count();
        $jobs = Job::where('user_id', $user->id)->count();
        
        // رابط المتجر الآمن (يفرض استخدام https)
        $storeUrl = secure_url('/merchants/' . $user->id);
        
        return view('merchant.dashboard', compact('user', 'products', 'discounts', 'jobs', 'storeUrl'));
    }
}