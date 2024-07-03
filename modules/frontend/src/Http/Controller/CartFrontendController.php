<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\coupon;
use App\Models\favorite;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pay;
use App\Models\product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Modules\Backend\Extentions\Address\Address;
use PhpParser\Node\Expr\Cast\Double;

class CartFrontendController extends Controller
{
    public function addToCart($id)
    {
        if (auth()->check()) {
            $userId = auth()->id();
        } else {
            return redirect('/login')->with('no', 'Login to continue!');
        }

        // Lấy số lượng sản phẩm từ request, mặc định là 1 nếu không có input
        $quantity = 1;

        // Lấy giỏ hàng từ session hoặc khởi tạo giỏ hàng mới nếu chưa tồn tại
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$id])) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            if ($cart[$id]['quantity'] < 3) {
                $cart[$id]['quantity'] += $quantity;
            }
            $cart[$id]['updated_at'] = now();
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $cart[$id] = [
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);
        // dd(Session::get('cart'));
        return redirect()->back()->with('ok', 'Product added to cart!');
    }

    public function view(Request $request)
    {
        session()->put('code', []);
        if (auth()->check()) {
            $userId = auth()->id();
        } else {
            return redirect('/login')->with('no', 'Login to continue!');
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Lấy danh sách product_id từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm từ database dựa trên product_id
        $products = Product::whereIn('id', $productIds)->get();

        // Gắn thêm số lượng từ giỏ hàng vào sản phẩm
        foreach ($products as $product) {
            $product->quantity = $cart[$product->id]['quantity'];
        }
        // dd($products);
        return view('frontend::layout.checkout', ['cart' => $products]);
    }

    public function deleteCartItem($id)
    {

        if (auth()->check()) {
            $userId = auth()->id();
        } else {
            return redirect('/login')->with('no', 'Login to continue!');
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm khỏi giỏ hàng

            // Lưu giỏ hàng cập nhật vào session
            session()->put('cart', $cart);

            return redirect('/')->with('ok', 'Deleted item successfully!');
        }

        return redirect('/')->with('no', 'Deleted item failed!');
    }

    public function updateQuantity($ItemId, $quantity)
    {
        // $cartItem = cart::where('product_id', $ItemId)->where('user_id', Auth::user()->id)->firstOrFail();
        // $cartItem->quantity = $quantity;
        // $cartItem->save();

        $cart = session()->get('cart', []);
        if (isset($cart[$ItemId])) {
            // Update the quantity
            $cart[$ItemId]['quantity'] = $quantity;
            $cart[$ItemId]['updated_at'] = now();

            // Save the updated cart back into the session
            session()->put('cart', $cart);

            return response()->json(['success' => true, 'message' => 'Quantity updated successfully.']);
        }

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully.']);
    }

    public function favorite()
    {
        return view('frontend::layout.favorite');
    }
    public function addfavorite($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->with('no', 'Login to continue!');
        }

        $product = Product::find($id);

        if ($product) {
            $userId = auth()->id();

            // Check if the product is already in the favorites
            $favorite = favorite::where('user_id', $userId)->where('product_id', $id)->first();

            if ($favorite) {
                // If it exists, remove it from the favorites
                $favorite->delete();
                return redirect()->back()->with('ok', 'Removed from favorites list!');
            } else {
                // If it does not exist, add it to the favorites
                Favorite::create([
                    'user_id' => $userId,
                    'product_id' => $id,
                ]);
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
        // dd(session()->get('code'));
        $code = coupon::where('code', session()->get('code'))->where('status', 'normal')->first();
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

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Lấy danh sách product_id từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm từ database dựa trên product_id
        $items = Product::whereIn('id', $productIds)->get();

        // Gắn thêm số lượng từ giỏ hàng vào sản phẩm
        foreach ($items as $product) {
            $product->quantity = $cart[$product->id]['quantity'];
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

    public function checkout_3(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        $totalPrice = $request->input('totalPrice');
        $discountMoney = $request->input('discountMoney');
        $finalPrice = $totalPrice - $discountMoney;
        $address = '';
        if ($request->District != null) {
            $fullAddressName = Address::getFullAddressNames($request->City, $request->District, $request->Ward);
            $address = $request->input('street') . ", " .
                $fullAddressName['ward_name'] . ", " .
                $fullAddressName['district_name'] . ", " .
                $fullAddressName['province_name'];
        } else {
            $address = $request->input('street') . ", " .
                $request->input('ward') . ", " .
                $request->input('district') . ", " .
                $request->input('City');
        }
        // Lấy danh sách product_id từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm từ database dựa trên product_id
        $items = Product::whereIn('id', $productIds)->get();

        // Gắn thêm số lượng từ giỏ hàng vào sản phẩm
        foreach ($items as $product) {
            $product->quantity = $cart[$product->id]['quantity'];
        }
        $Delivery = $request->input('Delivery');
        $paymentOption = $request->input('paymentOption');

        $code = coupon::where('code', session()->get('code'))->get('id')->first();
        if (isset($code)) $code = $code->id;
        else $code = null;

        DB::beginTransaction();
        try {
            //Pay
            $pay = Pay::create([
                'name' => $paymentOption,
                'description' => "Unpaid",
                'status' => 1
            ]);

            $payId = $pay->id;

            // Tạo hóa đơn
            $invoice = Invoice::create([
                'invoice_date' => now(),
                'address' => $address,
                'phone' => $request->input('phone'),
                'name' => $request->input('name'),
                'total' => $finalPrice,
                'status' => 'Pending',
                'delivery' => $Delivery,
                'user_id' => $user->id,
                'coupon_id' => $code,
                'pay_id' => $payId,
            ]);

            // Tạo chi tiết hóa đơn
            foreach ($items as $product) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                ]);
                if ($product->quantity > 0)
                    $product->decrement('stock', $product->quantity);
            }
            if ($code) {
                $coupon = Coupon::find($code);
                if ($coupon) {
                    $coupon->increment('count_active');
                }
            }
            DB::commit();
            // return response()->json(['message' => 'Invoice created successfully', 'invoice_id' => $invoice->id], 201);
            // if ($paymentOption == 'VNPAY') return redirect('/pay');
            return redirect('/receipt');
        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json(['message' => 'Invoice creation failed', 'error' => $e->getMessage()], 500);
            return redirect()->back();
        }
    }
    public function receipted()
    {
        $user = Auth::user();
        $latestInvoice = Invoice::where('user_id', $user->id)->latest()->first();
        $cart = session()->get('cart', []);

        // Lấy danh sách product_id từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm từ database dựa trên product_id
        $items = Product::whereIn('id', $productIds)->get();

        // Gắn thêm số lượng từ giỏ hàng vào sản phẩm
        foreach ($items as $product) {
            $product->quantity = $cart[$product->id]['quantity'];
        }
        // dd($product);
        return view('frontend::layout.receipt', ['latestInvoice' => $latestInvoice, 'items' => $items]);
    }

    public function buynow($id)
    {
        $this->addToCart($id);
        return redirect('/viewcart');
    }
}
