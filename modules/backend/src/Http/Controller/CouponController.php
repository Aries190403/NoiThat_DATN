<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\coupon;
use App\Models\material;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CouponController extends Controller
{
    public function index()
    {
        $title = "Coupon";
        $coupons = coupon::where('status', '!=', DataType::DELETED_DATA_TYPE)->get();
        return view('backend::coupon.index', [
            'title' => $title,
            'coupons' => $coupons,
        ]);
    }

    public function create(Request $request){
        $coupon = new coupon();
        $existingCoupon = coupon::where('code', $request->input('code'))->first();
        if ($existingCoupon) {
            return response()->json(['error' => 'Code đã tồn tại'], 409);
        }
        $coupon->code = $request->input('code');
        $coupon->limit = $request->input('limit');
        $coupon->discount = $request->input('discount') ?? 0;
        $coupon->discount_money = $request->input('discount_money') ?? 0;
        $coupon->count_active = 0;
        $coupon->description = $request->input('description');
        $coupon->status = DataType::NORMAL_DATA_TYPE;

        $date = $request->input('date');
        $time = $request->input('time');
        $datetime_string = $date . ' ' . $time;
        $datetime = new DateTime($datetime_string);
        $timestamp = $datetime->format('Y-m-d H:i:s');
        $coupon->downtime = $timestamp;
        $coupon->user_create = Auth::user()->id;

        $coupon->save();
        return response()->json(['success' => 'Coupon created successfully']);
    }

    public function couponState($id)
    {
        try {
            $coupon = coupon::findOrFail($id);
            $coupon->status = ($coupon->status == 'normal') ? 'locked' : 'normal';
            $coupon->save();
    
            return redirect()->back()->with('success', 'coupon updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }

    public function view($id)
    {
        try{
            $coupon = coupon::findOrFail($id);
            $user_create = $coupon->user->name;
            return response()->json([
                'coupon' => $coupon,
                'user_name' => $user_create
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $coupon = coupon::findOrFail($id);
            $coupon->limit = $request->input('limit');
            $coupon->discount = $request->input('discount');
            $coupon->discount_money = $request->input('discount_money');

            $date = $request->input('date');
            $time = $request->input('time');
            $datetime_string = $date . ' ' . $time;
            $datetime = new DateTime($datetime_string);
            $timestamp = $datetime->format('Y-m-d H:i:s');
            $coupon->downtime = $timestamp;

            $coupon->description = $request->input('description');

            $coupon->save();
            
            return response()->json(['success' => 'Coupon change successfully']);
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }
}
