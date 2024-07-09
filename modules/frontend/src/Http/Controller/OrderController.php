<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\coupon;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pay;
use App\Models\product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $Invoices = Invoice::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('frontend::layout.order', ['Invoices' => $Invoices]);
        } catch (\Throwable $th) {
            return view('frontend::error.404');
        }
    }

    public function filterInvoices(Request $request)
    {
        $user_id = Auth::user()->id;
        $query = Invoice::where('user_id', $user_id);
        if ($request->input('dateOrder') != 'all') {
            if ($request->input('dateOrder') == 'newest') {
                $query->orderBy('created_at', 'desc');
            }
            if ($request->input('dateOrder') == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }
        if ($request->input('status') != 'all') {
            if ($request->input('status') == 'completed') {
                $query->where('status', 'like', '%Completed%');
            } else
                $query->where('status', $request->input('status'));
        }
        $invoices = $query->get();
        if ($invoices != null)

            foreach ($invoices as $invoice) {
                $invoice->payname = $invoice->pay->name;
                $invoice->des = $invoice->pay->description;
            }
        return response()->json(['invoices' => $invoices]);
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

    public function repay(Request $request, $id)
    {
        try {
            $invoice = Invoice::where('id', $id)->first();
        } catch (\Throwable $th) {
            return view('frontend::error.404');
        }
        $invoice = Invoice::where('id', $id)->first();
        if ($invoice->pay->description != "Unpaid" || $invoice->pay->name != "VNPAY") return view("frontend::error.404");
        $vnp_TmnCode = "707ER4OT"; // Mã Website tại VNPAY
        $vnp_HashSecret = "KZC6E0KWQQUVHXINEGP384PCI6F8QV4X"; // Chuỗi bí mật

        $vnp_Returnurl = route('vieworder'); // Đường dẫn trả về sau khi thanh toán thành công

        $vnp_TxnRef = "#mobel" . $invoice->id; // Mã đơn hàng
        $vnp_OrderInfo = "Mobel order no." . $invoice->id; // Thông tin đơn hàng
        $vnp_OrderType = $invoice->delivery; // Loại đơn hàng

        $api_url = 'https://v6.exchangerate-api.com/v6/380f982aff4995c2f5f6475b/latest/USD';

        // Gọi API và lấy dữ liệu tỷ giá
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);
        // dd($data);
        // Kiểm tra dữ liệu trả về
        if (isset($data['conversion_rates']['VND'])) {
            // Lấy tỷ giá USD -> VND
            $exchangeRate = $data['conversion_rates']['VND'];
        } else {
            // Sử dụng tỷ giá cố định nếu không lấy được từ API
            $exchangeRate = 25000;
        }

        $vnp_Amount = $invoice->total * 100 * ceil($exchangeRate); // Số tiền thanh toán (đơn vị: VNĐ)
        $vnp_Locale = 'vn'; // Ngôn ngữ
        // $vnp_BankCode = $request->input('bank_code'); // Mã ngân hàng


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
        if ($request->vnp_TransactionStatus == '00') return redirect()->to($vnp_Url)->with("ok", "You have successfully paid.");
        return redirect()->to($vnp_Url);
    }

    public function view(Request $request)
    {
        $id = str_replace('#mobel', '', $request->vnp_TxnRef);

        $Invoices = Invoice::where('id', $id)->first();
        $Invoices->status = 'Confirmed';
        $Invoices->save();
        $productDetails = $Invoices->invoicedetails->mapWithKeys(function ($detail) {
            return [$detail->product_id => $detail->quantity];
        });
        $discountprecent = 0;
        $discountmoney = 0;
        $code = coupon::where('id', $Invoices->coupon_id)->first();
        if (isset($code)) {
            $discountprecent = $code->discount;
            $discountmoney = $code->discount_money;
        }
        $productIds = $productDetails->keys();
        $items = product::whereIn('id', $productIds)->get();

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
        $finalPrice = $totalPrice;

        if ($finalPrice > 0 && $discountmoney > 0 && $discountprecent != 0) {
            $finalPrice = $this->calculateDiscountedPrice($finalPrice, $discountmoney, $discountprecent);
            $discountMoney = $totalPrice - $finalPrice;
        }

        $pay = Pay::where('id', $Invoices->pay_id)->first();
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
        return view('frontend::layout.vieworder', ['Invoices' => $Invoices, 'items' => $items, 'totalPrice' => $totalPrice, 'discountMoney' => $discountMoney]);
    }

    public function viewmore($id)
    {
        try {
            $Invoices = Invoice::where('id', $id)->first();
        } catch (\Throwable $th) {
            return view('frontend::error.404');
        }
        $Invoices = Invoice::where('id', $id)->first();
        $productDetails = $Invoices->invoicedetails->mapWithKeys(function ($detail) {
            return [$detail->product_id => $detail->quantity];
        });
        $discountprecent = 0;
        $discountmoney = 0;
        $code = coupon::where('id', $Invoices->coupon_id)->first();
        if (isset($code)) {
            $discountprecent = $code->discount;
            $discountmoney = $code->discount_money;
        }
        $productIds = $productDetails->keys();
        $items = product::whereIn('id', $productIds)->get();

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
        $finalPrice = $totalPrice;

        if ($finalPrice > 0 && $discountmoney > 0 && $discountprecent != 0) {
            $finalPrice = $this->calculateDiscountedPrice($finalPrice, $discountmoney, $discountprecent);
            $discountMoney = $totalPrice - $finalPrice;
        }
        return view('frontend::layout.viewmore', ['Invoices' => $Invoices, 'items' => $items, 'totalPrice' => $totalPrice, 'discountMoney' => $discountMoney]);
    }

    public function cancel($id)
    {
        try {
            $invoice = Invoice::where('id', $id)->first();
            if ($invoice->status != 'Pending' && $invoice->status != 'Confirmed') return redirect()->back()->with('no', 'Cancel failed');
            $invoice->status = 'Cancelled';
            if ($invoice->pay->description == 'Paid') {
                $pay = pay::where('id', $invoice->pay_id)->first();
                $pay->description = 'Refunding';
                $pay->save();
            }
            $invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();
            foreach ($invoiceDetails as $detail) {
                $product = Product::where('id', $detail->product_id)->first();
                if ($product) {
                    $product->increment('stock', $detail->quantity);
                    $product->save();
                }
            }
            $invoice->save();
            //code...
        } catch (\Throwable $th) {
            return redirect()->back()->with('no', 'Cancel failed');
        }
        return redirect()->back()->with('ok', 'Cacelled');
    }

    public function return($id)
    {
        try {
            $invoice = Invoice::where('id', $id)->first();
            if ($invoice->status != 'Completed') return redirect()->back()->with('no', 'Return failed');
            $invoice->status = 'Returning';
            if ($invoice->pay->description == 'Paid') {
                $pay = pay::where('id', $invoice->pay_id)->first();
                $pay->description = 'Refunding';
                $pay->save();
            }
            $invoice->save();
            //code...
        } catch (\Throwable $th) {
            return redirect()->back()->with('no', 'Return failed');
        }
        return redirect()->back()->with('ok', 'Returned');
    }
}
