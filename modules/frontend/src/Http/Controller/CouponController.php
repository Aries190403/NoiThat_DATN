<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CouponController extends Controller
{
    public function check(Request $request)
    {
        try{
            $coupon = Coupon::where('code', $request->input('code'))->firstOrFail();

            $currentDateTime = Carbon::now();
            if($coupon->limit == $coupon->count_active || $currentDateTime->greaterThanOrEqualTo($coupon->downtime)){
                return response()->json(['error' => 'Voucher is expired or incorrect']);
            }

            return response()->json([
                'coupon' => $coupon,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Voucher is expired or incorrect']);
        }
    }
}
