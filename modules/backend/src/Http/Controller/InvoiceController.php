<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pay;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataType;

class InvoiceController extends Controller
{
    public function index()
    {
        $title = "Invoice";
        $invoices = Invoice::whereDoesntHave('pay', function ($query) {
            $query->where('description', 'unpaid')
                  ->where('name', 'VNPAY');
        })->get();      
        return view('backend::invoice.index', [
            'title' => $title,
            'invoices' => $invoices,
        ]);
    }
    public function update(Request $request)
    {
        $ids = $request->input('ids');
        foreach($ids as $id){
            $invoice = Invoice::find($id);
            $payment = Pay::find($invoice->pay_id);
            if($request->input('requestType') == 'Confirmed'){
                $invoice->status = DataType::INVOICE_COMFIRMED_DATA_TYPE;
            }
            elseif($request->input('requestType') == 'Shipping'){
                $invoice->status = DataType::INVOICE_SHIPPING_DATA_TYPE;  
            }
            elseif($request->input('requestType') == 'Completed'){
                $invoice->status = DataType::INVOICE_COMPLETED_DATA_TYPE;
                $payment->description = 'Paid';
                $payment->save();
            }
            elseif($request->input('requestType') == 'Returning'){
                if($invoice->pay->description == 'paid'){
                    $invoice->status = DataType::INVOICE_REFUNDING_DATA_TYPE;  
                }
                else{
                    $invoice->status = DataType::INVOICE_RETURNDING_DATA_TYPE;  
                }
            }
            elseif($request->input('requestType') == 'Shipping'){
                $invoice->status = DataType::INVOICE_SHIPPING_DATA_TYPE;  
            }
            elseif($request->input('requestType') == 'Refunded'){
                $invoice->status = DataType::INVOICE_REFUNED_DATA_TYPE;  
            }
            elseif($request->input('requestType') == 'Returned'){
                $invoice->status = DataType::INVOICE_RETURNED_DATA_TYPE;  
            }
            $invoice->save();
        };
    }

    public function detail($id)
    {
        $data = Invoice::with('details.product')->where('id', $id)->first();
        $pay = $data->pay;
        return response()->json([
            'data' => $data,
            'payment' => $pay
        ]);
    }

    public function splip(Request $request)
    {
        $originalInvoice = Invoice::with('invoiceDetails', 'pay', 'coupon')->findOrFail($request->input('invoice_id'));
        $splitData = $request->input('products');

        DB::beginTransaction();

        try {
            $originalInvoice->status = 'Cancelled';
            $originalInvoice->save();

            // Xử lý hoá đơn thứ nhất
            $coupon = $originalInvoice->coupon;
            $totalInvoice1 = 0;
            $payment1 = Pay::create([
                'name' => $originalInvoice->pay->name,
                'description' => $originalInvoice->pay->description,
                'status' => $originalInvoice->pay->status,
            ]);
            
            foreach ($splitData as $detail) {
                $product = product::find($detail['product_id']);
                $totalInvoice1 = $totalInvoice1 + $product->price * $detail['quantity'];
            }

            $discount1 = null;
            if($coupon != null)
            {
                $discount1 = $coupon->discount * $totalInvoice1 / 100;
                if($discount1 > $coupon->discount_money){
                    $discount1 = $coupon->discount_money;
                }
            }

            $discount1 = null;
            if($coupon != null)
            {
                $discount1 = $coupon->discount * $totalInvoice1 / 100;
                if($discount1 > $coupon->discount_money){
                    $discount1 = $coupon->discount_money;
                }
            }

            $invoice1 = Invoice::create([
                'customer_id' => $originalInvoice->customer_id,
                'status' => 'Pending',
                'invoice_date' => now()->format('Y-m-d'),
                'address' => $originalInvoice->address,
                'phone' => $originalInvoice->phone,
                'name' => $originalInvoice->name,
                'delivery' => $originalInvoice->delivery,
                'user_id' => $originalInvoice->user_id,
                'coupon_id' => $originalInvoice->coupon_id,
                'total' => $totalInvoice1,
                'pay_id' => $payment1->id,
                'discountMoney' => $discount1
            ]);

            foreach ($splitData as $detail) {
                $product = product::find($detail['product_id']);
                InvoiceDetail::create([
                    'invoice_id' => $invoice1->id,
                    'product_id' => $detail['product_id'],
                    'product_name' => $product->name,
                    'quantity' => $detail['quantity'],
                    'price' => $product->price
                ]);
            }

            // dd($invoice1);

            // Xử lý hoá đơn thứ hai
            $remainingDetails = $originalInvoice->invoiceDetails->reject(function ($detail) use ($splitData) {
                foreach ($splitData as $splitDetail) {
                    if ($detail->product_id == $splitDetail['product_id']) {
                        return true;
                    }
                }
                return false;
            });

            $totalInvoice2 = 0;
            $payment2 = Pay::create([
                'name' => $originalInvoice->pay->name,
                'description' => $originalInvoice->pay->description,
                'status' => $originalInvoice->pay->status,
            ]);

            foreach ($remainingDetails as $detail) {
                $totalInvoice2 += $detail->price * $detail->quantity;
            }

            $discount2 = null;
            if ($coupon != null) {
                $discount2 = $coupon->discount * $totalInvoice2 / 100;
                if ($discount2 > $coupon->discount_money) {
                    $discount2 = $coupon->discount_money;
                }
            }

            $invoice2 = Invoice::create([
                'customer_id' => $originalInvoice->customer_id,
                'status' => 'Pending',
                'invoice_date' => now()->format('Y-m-d'),
                'address' => $originalInvoice->address,
                'phone' => $originalInvoice->phone,
                'name' => $originalInvoice->name,
                'delivery' => $originalInvoice->delivery,
                'user_id' => $originalInvoice->user_id,
                'coupon_id' => $originalInvoice->coupon_id,
                'total' => $totalInvoice2,
                'pay_id' => $payment2->id,
                'discountMoney' => $discount2,
            ]);

            foreach ($remainingDetails as $detail) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice2->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product_name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Invoices split successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to split invoices'], 500);
        }
    }

    public function Cancel($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->status = "Cancelled";
        $invoice->save();
        return response()->json([
            'message' => 'Invoices split successfully',
        ]);
    }
}