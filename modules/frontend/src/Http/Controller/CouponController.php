<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CouponController extends Controller
{
    public function check(Request $request)
    {
        try {
            $coupon = Coupon::where('code', $request->input('code'))->firstOrFail();
            $currentDateTime = Carbon::now();
            if ($coupon->limit == $coupon->count_active || $currentDateTime->greaterThanOrEqualTo($coupon->downtime)) {
                return response()->json(['no' => 'Voucher is expired or incorrect']);
            }
            session()->put('code', $coupon->code);
            return response()->json([
                'coupon' => $coupon,
            ]);
        } catch (\Exception $e) {
            return response()->json(['no' => 'Voucher is expired or incorrect']);
        }
    }
}
