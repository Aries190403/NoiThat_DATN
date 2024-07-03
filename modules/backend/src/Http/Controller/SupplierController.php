<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Address as ModelsAddress;
use App\Models\picture;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Backend\Extentions\Address\Address;
use Modules\Backend\Http\Data\DataType;
use Modules\Backend\Http\Service\CategoryService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupplierController extends Controller
{
    public function index()
    {
        $title = "suppliers";
        $getAddress = Address::getProvinces();
        $suppliers = Supplier::where('status', '!=', DataType::DELETED_DATA_TYPE)->get();
        return view('backend::supplier.index', ['title' => $title, 'suppliers' => $suppliers, 'getAddress' => $getAddress]);
    }

    public function Create(Request $request)
    {
        $fullAddressName = Address::getFullAddressNames($request->City, $request->District, $request->Ward);
        try {
            DB::beginTransaction();
            
            $address = new ModelsAddress();
            $address->street = $request->input('street');
            $address->ward = $fullAddressName['ward_name'];
            $address->district = $fullAddressName['district_name'];
            $address->city = $fullAddressName['province_name'];
            $address->save();
            
            $supplier = new Supplier();
            $supplier->name = $request->input('name');
            $supplier->phone = $request->input('phone');
            $supplier->email = $request->input('email');
            $supplier->description = $request->input('description');
            $supplier->address_id = $address->id;
            $supplier->status = DataType::NORMAL_DATA_TYPE;
            $supplier->save();
            
            DB::commit();
            return redirect()->route('admin-supplier-index')->with('success', 'Supplier updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin-supplier-index')->with('error', 'Error adding supplier: ' . $e->getMessage());
        }
    }
    
    public function getInfor($id)
    {
        try{
            $supplier = Supplier::find($id);
            if (!$supplier || $supplier->status === DataType::DELETED_DATA_TYPE) {
                throw new NotFoundHttpException();
            }
            $address = ModelsAddress::find($supplier->address_id);
            $picture = picture::find($supplier->avatar);
            return response()->json([
                'supplier' => $supplier,
                'address' => $address,
                'avatar' => $picture??null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $data = $request->only('name', 'email', 'phone', 'street', 'city', 'district', 'ward', 'description');
    
        if (!empty($data['name'])) {
            $supplier->name = $data['name'];
        }
        if (!empty($data['email'])) {
            $supplier->email = $data['email'];
        }
        if (!empty($data['phone'])) {
            $supplier->phone = $data['phone'];
        }
        if (!empty($data['description'])) {
            $supplier->description = $data['description'];
        }
    
        if($data['city'] == null || $data['district'] == null || $data['ward'] == null)
        {
            return response()->json(['error' => 'Please re-enter the address'], 400);
        }
        else{
            $fullAddressName = Address::getFullAddressNames($data['city'], $data['district'], $data['ward']);
            $address = ModelsAddress::findOrFail($supplier->address_id);
    
            $address->street = $data['street'];
            $address->ward = $fullAddressName['ward_name'];
            $address->district = $fullAddressName['district_name'];
            $address->city = $fullAddressName['province_name'];
        };
        try {
            $address->save();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Must enter full address'], 400);
        }
        try {
            $supplier->save();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to save supplier'], 500);
        }
    
        return response()->json(['success' => 'Supplier updated successfully']);
    }
    
    public function update(Request $request, $id)
    {
        
    }

    public function couponState($id)
    {
        try {
            $coupon = Supplier::findOrFail($id);
            $coupon->status = ($coupon->status == 'normal') ? 'locked' : 'normal';
            $coupon->save();

            return redirect()->back()->with('success', 'coupon updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred, please try again later'], 500);
        }
    }

    public function upAvatar(Request $request, $id)
    {
        $disk = 'public';
        $directory = 'uploads/images/avatars';
    
        if ($request->hasFile('image')) {
            $filePath = $this->storeImage($request->file('image'), $disk, $directory);
            
            $user = Supplier::find($id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy người dùng.']);
            }
    
            $image = $user->avatar ? picture::find($user->avatar) : new picture();
    
            if (!$image) {
                $image = new picture();
            }
    
            $image->image = $filePath;
            $image->save();
    
            $user->avatar = $image->id;
            $user->save();
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'Không có hình ảnh nào được tải lên.']);
    }

    private function storeImage($file, $disk, $directory)
    {
        $destinationPath = public_path($directory);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
    
        $randomFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $directory . '/' . $randomFileName;
    
        $file->move($destinationPath, $randomFileName);
    
        return $filePath;
    }

}