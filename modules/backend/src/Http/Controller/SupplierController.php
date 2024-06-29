<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Address as ModelsAddress;
use App\Models\picture;
use App\Models\Supplier;
use Illuminate\Http\Request;
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
        $suppliers = supplier::where('status', DataType::NORMAL_DATA_TYPE)->get();
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
        dd($request);
    }

    public function update(Request $request, $id)
    {
        
    }
}
