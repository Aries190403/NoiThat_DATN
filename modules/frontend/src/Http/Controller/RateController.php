<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\rate;
use Illuminate\Http\Request;

class RateController extends Controller
{

    public function store(Request $request, $id)
    {
        $latestInvoice = Invoice::where('id', $id)->first();
        $productIds = $latestInvoice->invoicedetails->pluck('product_id')->toArray();
        // dd($productIds, $id);
        foreach ($productIds as $productId) {
            Rate::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'content' => $request->input('comment'),
                'quanlity' => $request->input('rating'),
                'status' => 1,
            ]);
        }

        return redirect()->back()->with('ok', 'Rate success.');
    }
}
