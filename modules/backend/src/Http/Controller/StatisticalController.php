<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    public function index()
    {
        $title = "statistical";
        $statisticsOrder = Invoice::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(CASE WHEN status = 'Completed' OR status = 'Completed - Rated' THEN 1 ELSE 0 END) as complete_count"),
            DB::raw("SUM(CASE WHEN status = 'Refuned' THEN 1 ELSE 0 END) as return_count"),
            DB::raw("SUM(CASE WHEN status = 'Returned' THEN 1 ELSE 0 END) as refund_count")
        )
        ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $productStatistics = Product::select(
            DB::raw("SUM(invoice_details.quantity) as total_quantity_sold"),
            'products.name as name'
        )
        ->join('invoice_details', 'products.id', '=', 'invoice_details.product_id')
        ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
        ->whereIn('invoices.status', ['Completed', 'Completed - Rated'])
        ->whereRaw('invoice_details.created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)')
        ->groupBy('products.id', 'products.name')
        ->orderBy('name', 'asc')
        ->get()
        ->toArray();

        $revenueStatistics = Invoice::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(total) as total_revenue")
        )
        ->where(function($query) {
            $query->where('status', 'Completed')
                  ->orWhere('status', 'Completed - Rated');
        })
        ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get()
        ->toArray();

        $productRevenueData = InvoiceDetail::select(
            'product_name',
            DB::raw('SUM(quantity * price) as total_revenue')
        )
        ->whereHas('invoice', function($query) {
            $query->where(function($query) {
                $query->where('status', 'Completed')
                      ->orWhere('status', 'Completed - Rated');
            })
            ->whereRaw('invoice_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)');
        })
        ->groupBy('product_name')
        ->orderBy('total_revenue', 'desc')
        ->get()
        ->toArray();

        $now = Carbon::now();
        $oneYearAgo = $now->copy()->subMonths(12);

        $statisticsData = Invoice::whereBetween('invoice_date', [$oneYearAgo, $now])
        ->where(function($query) {
            $query->where('status', 'Completed')
                    ->orWhere('status', 'Completed - Rated');
        })
        ->select(
            DB::raw('SUM(total) as total_revenue'),
            DB::raw('COUNT(id) as total_orders'),
            DB::raw('SUM(CASE WHEN coupon_id IS NOT NULL THEN 1 ELSE 0 END) as total_vouchers'),
            DB::raw('SUM(discountMoney) as total_discount')
        )
        ->first();

        return view('backend::statistical.index', [
            'title' => $title,
            'statisticsOrder' => json_encode($statisticsOrder),
            'productStatistics' => json_encode($productStatistics),
            'revenueStatistics' => json_encode($revenueStatistics),
            'productRevenueData' => json_encode($productRevenueData),
            'statisticsData' => ($statisticsData),
        ]);
    }   
}