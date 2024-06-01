<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use Modules\Backend\Extentions\Address\Address;

class AddressController extends Controller
{
    public function getDistricts($cityCode)
    {
        try {
            $districts = Address::getDistrictsByProvinceId($cityCode);
            return response()->json(array_values($districts));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch districts'], 500);
        }
    }

    public function getWards($districtCode)
    {
        try {
            $wards = Address::getWardsByDistrictId($districtCode);
            return response()->json(array_values($wards));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch wards'], 500);
        }
    }
}
