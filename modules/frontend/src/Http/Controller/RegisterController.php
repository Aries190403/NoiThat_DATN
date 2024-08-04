<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Backend\Extentions\Address\Address as AddressAddress;

class RegisterController extends Controller
{
    public function index()
    {
        $cities = AddressAddress::getProvinces();
        return view('frontend::layout.register', ['cities' => $cities]);
    }


    public function store(Request $request)
    {
        $newAddress = "";
        if ($request->District != null) {
            $fullAddressName = AddressAddress::getFullAddressNames($request->City, $request->District, $request->Ward);
            // dd($fullAddressName);
            $newAddress = [
                'city' => $fullAddressName['province_name'],
                'district' => $fullAddressName['district_name'],
                'ward' => $fullAddressName['ward_name'],
                'street' => $request->input('street'),
                'status' => 'active', // Giả sử mặc định là active khi thêm mới
            ];
        }
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Rule confirmed để xác nhận lại mật khẩu
            'phone' => 'required|string|digits:10|unique:users,phone', // Rule digits:10 để chỉ cho nhập 10 số
            // 'otp' => 'required|string', // Có thể thêm các rules khác tại đây
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'ward' => 'nullable|string',
            'street' => 'required|string',
        ];

        // Custom error messages
        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'phone.required' => 'Please enter your phone number.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'phone.digits' => 'Phone number does exits',
            // 'otp.required' => 'Please enter the OTP.',
            'street.required' => 'Please enter your street address.',
        ];

        // Validate input data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Xử lý lưu thông tin vào database (thêm địa chỉ và người dùng)
        // Tạo địa chỉ mới


        // Thêm địa chỉ vào bảng addresses
        $address = Address::create($newAddress);

        // Lấy ra id của bản ghi vừa thêm vào
        $addressId = $address->id;

        // Tạo mới user
        $newUser = [
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash password trước khi lưu vào database
            'phone' => $request->input('phone'),
            'address_id' => $addressId,
        ];

        // Lưu user vào database
        User::create($newUser);
        // Redirect to login page with success message
        return redirect('/login')->with('ok', 'Register success !');
    }
}
