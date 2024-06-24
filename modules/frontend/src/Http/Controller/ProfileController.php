<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Address as ModelsAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Backend\Extentions\Address\Address;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $cities = Address::getProvinces();
        return view('frontend::layout.profile', ['user' => $user, 'cities' => $cities]);
    }

    public function updateprofile(Request $request)
    {
        $rules = [
            'phone' => 'required|string|digits:10|unique:users,phone', // Rule digits:10 để chỉ cho nhập 10 số
        ];
        $messages = [
            'phone.digits' => 'Phone number does exits',
        ];

        // Validate input data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->District != null) {
                $fullAddressName = Address::getFullAddressNames($request->City, $request->District, $request->Ward);
                $newAddress = [
                    'city' => $fullAddressName['province_name'],
                    'district' => $fullAddressName['district_name'],
                    'ward' => $fullAddressName['ward_name'],
                    'street' => $request->input('street'),
                    'status' => 'active', // Giả sử mặc định là active khi thêm mới
                ];
                ModelsAddress::where('id', Auth::user()->address_id)->update($newAddress);
            }

            $newUser = [
                "name" => $request->input('name'),
                "phone" => $request->input('phone'),
            ];

            User::where('id', Auth::user()->id)->update($newUser);

            return back()->with('ok', 'Update information success!');
        } catch (\Exception $e) {
            // Xử lý ngoại lệ tại đây
            return back()->with('no', 'Update information failed: ' . $e->getMessage());
        }
    }
}
