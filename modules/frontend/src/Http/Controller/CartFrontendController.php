<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\coupon;
use App\Models\product;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Modules\Backend\Extentions\Address\Address;
use PhpParser\Node\Expr\Cast\Double;

class CartFrontendController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if (auth()->check())
            // Lấy thông tin user ID từ session hoặc auth (tùy thuộc vào cấu trúc của bạn)
            $userId = auth()->id();
        else {
            return redirect('/login')->with('no', 'Login to continue !');
        }
        // Lấy số lượng sản phẩm từ request
        $quantity = 1; // Mặc định là 1 nếu không có input

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity < 3)
                $cartItem->quantity += $quantity;
            $cartItem->updated_at = now();
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $id;
            $cartItem->quantity = $quantity;
            $cartItem->created_at = now();
            $cartItem->updated_at = now();
            $cartItem->save();
        }

        return redirect()->back()->with('ok', 'Product added to cart!');
    }

    public function view(Request $request)
    {
        // dd($request);
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cartItems = Cart::where('user_id', $userId)->whereNull('deleted_at')->orderByDesc('created_at')->orderByDesc('updated_at')->get();

            $products = [];
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity = $item->quantity;
                    $products[] = $product;
                }
            }
        }
        // dd($products);
        return view('frontend::layout.checkout', ['cart' => $products]);
    }

    public function deleteCartItem($id)
    {

        $item = cart::where('product_id', $id)->where('user_id', Auth::user()->id);
        if ($item) {
            $item->delete();
            return redirect('/')->with('ok', 'Deleted item successfuly !');
        }
        return redirect('/')->with('no', 'Deleted item failed !');
    }

    public function updateQuantity(Request $request, $ItemId, $quantity)
    {
        $cartItem = cart::where('product_id', $ItemId)->where('user_id', Auth::user()->id)->firstOrFail();
        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully.']);
    }

    public function favorite()
    {
        return view('frontend::layout.favorite');
    }
    public function addfavorite($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->with('no', 'Login to continue !');
        }
        $product = Product::find($id);

        if ($product) {
            $favorites = Session::get('favorite', []);

            if (array_key_exists($id, $favorites)) {
                unset($favorites[$id]);
                Session::put('favorite', $favorites);
                return redirect()->back()->with('ok', 'Removed from favorites list!');
            } else {
                $favorites[$id] = $product;
                Session::put('favorite', $favorites);
                return redirect()->back()->with('ok', 'Added to favorites list!');
            }
        } else {
            return redirect()->back()->with('error', 'Product not found!');
        }
    }

    public function calculateDiscountedPrice(int $originalPrice, int $discountMoney, int $discountPercent)
    {
        // Ensure the discounts are valid and the original price is greater than 0
        if ($originalPrice > 0 && $discountPercent > 0) {
            // Calculate the maximum possible discount from the percentage
            $percentDiscountAmount = $originalPrice * ($discountPercent / 100);

            // The effective discount is the lesser of the percentage discount and the discount money
            $effectiveDiscount = min($percentDiscountAmount, $discountMoney);

            // Calculate the final price after applying the effective discount
            $finalPrice = $originalPrice - $effectiveDiscount;

            // Ensure the final price is not negative
            $finalPrice = max($finalPrice, 0);

            return $finalPrice;
        } elseif ($originalPrice > 0 && $discountPercent <= 0 && $discountMoney > 0) {
            // If only a fixed discount is provided without a percentage discount
            $finalPrice = $originalPrice - $discountMoney;

            // Ensure the final price is not negative
            $finalPrice = max($finalPrice, 0);

            return $finalPrice;
        } else {
            // No discounts apply or invalid inputs
            return $originalPrice;
        }
    }

    public function checkout_2(Request $req)
    {
        $discountprecent = 0;
        $discountmoney = 0;
        //checkcode
        $req = '123';
        $code = coupon::where('code', $req)->where('status', 'normal')->first();
        if (isset($code)) {
            $getdate = getdate();
            $currentDateTime = new DateTime();
            $currentDateTime->setDate($getdate['year'], $getdate['mon'], $getdate['mday']);
            $currentDateTime->setTime($getdate['hours'], $getdate['minutes'], $getdate['seconds']);

            $downlineDateTime = new DateTime($code->downline);

            if (($code->count_active < $code->limit && $currentDateTime < $downlineDateTime) || ($code->count_active < $code->limit && $currentDateTime == $downlineDateTime)) {
                $discountprecent = $code->discount;
                $discountmoney = $code->discount_money;
            }
            // dd($code, $discountmoney, $discountprecent, $currentDateTime, $downlineDateTime);
        }
        //loadcart
        $items = [];
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cartItems = Cart::where('user_id', $userId)->whereNull('deleted_at')->orderByDesc('created_at')->orderByDesc('updated_at')->get();

            $products = [];
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity = $item->quantity;
                    $products[] = $product;
                    $items[] = $product;
                }
            }
        }
        //loaduser
        $user = Auth::user();
        //totalprice
        $totalPrice = 0;
        $discountMoney = 0;
        $finalPrice = 0;
        foreach ($items as $item) {
            if (isset($item->sale_percentage))
                $totalPrice += $item->quantity * ($item->price - ($item->price * $item->sale_percentage * 0.01));
            else
                $totalPrice += $item->quantity * $item->price;
        }
        // dump($totalPrice);
        $finalPrice = $totalPrice;

        if ($finalPrice > 0 && $discountmoney > 0 && $discountprecent != 0) {
            $finalPrice = $this->calculateDiscountedPrice($finalPrice, $discountmoney, $discountprecent);
            $discountMoney = $totalPrice - $finalPrice;
        }


        //dd('user', $user, 'items', $items, 'totalPrice', $totalPrice, 'finalPrice', $finalPrice, 'discountMoney', $discountMoney, 'discountprecent', $discountprecent);
        $cities = Address::getProvinces();
        return view('frontend::layout.checkout_2', ['user' => $user, 'items' => $items, 'totalPrice' => $totalPrice, 'finalPrice' => $finalPrice, 'discountMoney' => $discountMoney, 'discountprecent' => $discountprecent, 'cities' => $cities]);
    }
}
