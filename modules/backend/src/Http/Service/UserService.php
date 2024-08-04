<?php

namespace Modules\Backend\Http\Service;

use App\Models\Address;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Backend\Extentions\Address\Address as AddressAddress;
use Modules\Backend\Http\Data\DataUserType;
use Modules\Backend\Http\Request\UserRequest;

class UserService
{
    public function getId($id)
    {
        return Category::where('id', $id)->firstOrFail();
    }

    public function createUser(UserRequest $data): User
    {
        $validated = $data->validated();
    
        $fullAddressName = AddressAddress::getFullAddressNames($data->City, $data->District, $data->Ward);
    
        try {
            DB::beginTransaction();
    
            $address = Address::create([
                'street' => $data['street'],
                'ward' => $fullAddressName['ward_name'],
                'district' => $fullAddressName['district_name'],
                'city' => $fullAddressName['province_name'],
                'created_at' => now(),
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'address_id' => $address->id,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => $data['role'],
                'locked' => DataUserType::LOCK_USER_NORMAL,
                'status' => DataUserType::STATUS_USER_ACTIVE,
                'created_at' => now(),
            ]);
            DB::commit();
    
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}