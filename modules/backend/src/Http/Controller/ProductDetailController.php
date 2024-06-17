<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\product_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataType;

class ProductDetailController extends Controller
{
    public function Create(Request $request)
    {
        $size = json_encode([
            'height' => $request->input('height'),
            'length' => $request->input('length'),
            'width' => $request->input('width'),
        ]);
        $productDetail = new product_detail();
        $productDetail->product_id = $request->input('product_id');
        $productDetail->material_id = $request->input('material');
        $productDetail->size = $size;
        $productDetail->price = $request->input('price');
        $productDetail->stock = $request->input('stock');
        $productDetail->description = $request->input('description');
        $productDetail->status = DataType::NORMAL_DATA_TYPE;
        $productDetail->save();
        return redirect()->route('admin-material-index')->with('success', 'material updated successfully');
    }

    // public function edit($id)
    // {
    //     $material = material::find($id);
    //     return response()->json($material);
    // }

    // public function update(Request $request, $id)
    // {
    //     $material = material::find($id);
    //     $material->name = $request->input('name');
    //     $material->color = $request->input('color');
    //     $material->type = $request->input('type');
    //     $material->description = $request->input('description');
    //     $material->save();

    //     return redirect()->route('admin-material-index')->with('success', 'material updated successfully');
    // }
}
