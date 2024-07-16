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
        if (session()->get('cart') == null) return redirect('/')->with('no', 'ERROR !');
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
        if (session()->get('cart') == null) return redirect('/')->with('no', 'ERROR !');

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
        if (session()->get('cart') == null) return redirect('/')->with('no', 'ERROR !');

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
        if (session()->get('cart') == null) return redirect('/')->with('no', 'ERROR !');

        $discountprecent = 0;
        $discountmoney = 0;
        //checkcode
        // dd(session()->get('code'));
        $Aaa= session()->get('code');
        if($Aaa != []){
            $code = coupon::where('code', session()->get('code',[]))->where('status', 'normal')->first();
        }
        else{
            $code = null;
        }
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
        if (session()->get('cart') == null) return redirect('/')->with('no', 'ERROR !');

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

        $Aaa= session()->get('code');
        $code = null;
        $id_coupon = null;
        if($Aaa != []){
            $code = coupon::where('code', session()->get('code'))->get('id')->first();
            $id_coupon = $code->id;
        }

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
                'discountMoney' => $discountMoney,
                'status' => 'Pending',
                'delivery' => $Delivery,
                'user_id' => $user->id,
                'coupon_id' => $id_coupon,
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
            if ($id_coupon != null) {
                $coupon = Coupon::find($id_coupon);
                    $coupon->increment('count_active');
            }

            DB::commit();
            // return response()->json(['message' => 'Invoice created successfully', 'invoice_id' => $invoice->id], 201);
            if ($paymentOption == 'VNPAY') {
                $vnp_TmnCode = "707ER4OT"; // Mã Website tại VNPAY
                $vnp_HashSecret = "KZC6E0KWQQUVHXINEGP384PCI6F8QV4X"; // Chuỗi bí mật

                $vnp_Returnurl = route('receipt'); // Đường dẫn trả về sau khi thanh toán thành công

                $vnp_TxnRef = "#mobel" . $invoice->id; // Mã đơn hàng
                $vnp_OrderInfo = "Mobel order no." . $invoice->id; // Thông tin đơn hàng
                $vnp_OrderType = $Delivery; // Loại đơn hàng
                $api_url = 'https://v6.exchangerate-api.com/v6/380f982aff4995c2f5f6475b/latest/USD';

                // Gọi API và lấy dữ liệu tỷ giá
                $response = file_get_contents($api_url);
                $data = json_decode($response, true);
                // Kiểm tra dữ liệu trả về
                if (isset($data['conversion_rates']['VND'])) {
                    // Lấy tỷ giá USD -> VND
                    $exchangeRate = $data['conversion_rates']['VND'];
                } else {
                    // Sử dụng tỷ giá cố định nếu không lấy được từ API
                    $exchangeRate = 25000;
                }
                $vnp_Amount = $finalPrice * 100 * ceil($exchangeRate); // Số tiền thanh toán (đơn vị: USD)
                $vnp_Locale = 'vn'; // Ngôn ngữ
                $vnp_BankCode = $request->input('bank_code'); // Mã ngân hàng


                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $request->ip(),
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );

                ksort($inputData);
                $query = http_build_query($inputData);
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . $query;
                $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
                $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
                session()->put('cart', []);
                if ($request->vnp_TransactionStatus == '00') return redirect()->to($vnp_Url)->with("ok", "You have successfully paid.");
                return redirect()->to($vnp_Url);
            }
            session()->put('cart', []);
            return redirect('/receipt');
        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json(['message' => 'Invoice creation failed', 'error' => $e->getMessage()], 500);
            return redirect()->back();
        }
    }
    public function receipted(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        $latestInvoice = Invoice::where('user_id', $user->id)->latest()->first();
        $productDetails = $latestInvoice->invoicedetails->mapWithKeys(function ($detail) {
            return [$detail->product_id => $detail->quantity];
        });
        $discountprecent = 0;
        $discountmoney = 0;
        $code = coupon::where('id', $latestInvoice->coupon_id)->first();
        if (isset($code)) {
            $discountprecent = $code->discount;
            $discountmoney = $code->discount_money;
        }
        $productIds = $productDetails->keys();
        $items = Product::whereIn('id', $productIds)->get();

        // Để truy cập số lượng của từng sản phẩm, bạn có thể làm như sau:
        foreach ($items as $item) {
            $item->quantity = $productDetails[$item->id];
            // Xử lý sản phẩm và số lượng tương ứng tại đây
        }
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

        $pay = Pay::where('id', $latestInvoice->pay_id)->first(); // Sử dụng first() thay vì get() vì bạn chỉ cần một bản ghi duy nhất

        if (
            $pay != null && $pay->name == "VNPAY" && $request->vnp_TransactionStatus == '00'
        ) {
            $pay->description = "Paid";

            // Chuỗi ngày giờ cần chuyển đổi
            $vnp_PayDate = $request->vnp_PayDate;

            // Tạo đối tượng DateTime từ chuỗi ngày giờ
            $date = DateTime::createFromFormat('YmdHis', $vnp_PayDate);

            // Định dạng lại ngày giờ theo định dạng mong muốn
            $pay->processing_time = $date->format('Y-m-d H:i:s');
            $pay->notes = $request->vnp_TransactionNo;
            $pay->save();
        }
        if ($latestInvoice->pay->name == 'VNPAY' && $latestInvoice->pay->description == 'Paid') {
            $latestInvoice->status = "Confirmed";
            $latestInvoice->save();
        }
        // dd($items);
        // dd($product);
        return view('frontend::layout.receipt', ['latestInvoice' => $latestInvoice, 'items' => $items, 'totalPrice' => $totalPrice, 'discountMoney' => $discountMoney]);
    }

    public function buynow($id)
    {
        $this->addToCart($id);
        return redirect('/viewcart');
    }
}
