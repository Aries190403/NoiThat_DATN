<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pay;
use App\Models\product;
use Illuminate\Http\Request;
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
                $invoice->status = DataType::INVOICE_RETURNDING_DATA_TYPE;  
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
        $data = Invoice::with('details')->where('id', $id)->first();
        $pay = $data->pay;
        return response()->json([
            'data' => $data,
            'payment' => $pay
        ]);
    }
}