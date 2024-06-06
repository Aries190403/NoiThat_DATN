<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\picture;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Backend\Http\Data\DataType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{

    public function index()
    {
        $title = "Products";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $Products = product::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.index', ['title' => $title, 'products' => $Products, 'types' => $types]);
    }

    public function create(Request $request)
    {
        $product = new product();
        $product->name = $request->input('name');
        // $product->type = $request->input('type');
        $product->status = DataType::NORMAL_DATA_TYPE;
        $product->save();

        return redirect()->route('admin-product-edit',['id' => $product->id])->with('success');
    }

    public function edit($id)
    {
        $product = product::find($id);
        if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
            throw new NotFoundHttpException();
        }

        $title = "Edit Product";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.edit', ['title' => $title, 'product' => $product, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
                return response()->json(['error' => 'Product not found or deleted'], 404);
            }
            
            $product->name = $request->name;
            $product->description = $request->description;
            // $product->type = $request->type;
            $product->save();
    
            return response()->json(['success' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the product'], 500);
        }
    }
    













    public function upThumbnail(Request $request, $id)
    {
        $disk = 'uploads';
        $directory = 'images/product';
        
        $product = product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    
        if ($request->hasFile('image')) {
            $filePath = $this->storeImage($request->file('image'), $disk, $directory);
            
            $content = json_decode($product->content, true);
            if (!is_array($content)) {
                $content = [];
            }
    
            $content['imgThumbnail'] = $filePath;
    
            $product->content = json_encode($content);
            $product->save();
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'No images have been uploaded.']);
    }
    
    
    private function storeImage($file, $disk, $directory)
    {
        if (!Storage::disk($disk)->exists($directory)) {
            Storage::disk($disk)->makeDirectory($directory);
        }
    
        $randomFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($directory, $randomFileName, $disk);
        return $disk . '/' . $filePath;
    }
}
