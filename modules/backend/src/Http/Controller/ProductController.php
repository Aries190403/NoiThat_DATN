<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\material;
use App\Models\picture;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $materials = material::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.index', ['title' => $title, 'products' => $Products, 'types' => $types, 'materials' => $materials]);
    }

    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('type');
        $product->price = $request->input('price');
        $product->material_id = $request->input('material');
        $product->stock = $request->input('stock');
        $product->status = DataType::NORMAL_DATA_TYPE;
        
        $size = [
            'height' => $request->input('height') ?? 0,
            'length' => $request->input('length') ?? 0,
            'width' => $request->input('width') ?? 0,
        ];
        $product->content = json_encode(['size' => $size]);
        $product->description = $request->input('description');
    
        $product->save();
    
        return redirect()->route('admin-product-edit', ['id' => $product->id])->with('success');
    }

    public function edit($id)
    {
        $product = product::find($id);
        if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
            throw new NotFoundHttpException();
        }
        $materials = material::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $images = picture::where('product_id', $id)->where('status', DataType::NORMAL_DATA_TYPE)->get();

        $title = "Edit Product";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.edit', ['title' => $title, 'product' => $product, 'types' => $types, 'materials' => $materials, 'images' => $images]);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product || $product->status === DataType::DELETED_DATA_TYPE) {
                return response()->json(['error' => 'Product not found or deleted'], 404);
            }
    
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->category_id = $request->input('type');
            $product->price = $request->input('price');
            $product->material_id = $request->input('material');
            $product->stock = $request->input('stock');
            $product->sale_percentage = $request->input('sale');
            $content = json_decode($product->content, true);
            $content['size'] = [
                'height' => $request->input('height') ?? ($content['size']['height'] ?? 0),
                'length' => $request->input('length') ?? ($content['size']['length'] ?? 0),
                'width' => $request->input('width') ?? ($content['size']['width'] ?? 0),
            ];
            $product->content = json_encode($content);
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
    
    public function uploadImages(Request $request, $id)
    {
        $disk = 'uploads';
        $directory = 'images/product';
        
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    
        if ($request->hasFile('file')) {
            $filePath = $this->storeImage($request->file('file'), $disk, $directory);
            
            Picture::create([
                'product_id' => $id,
                'image' => $filePath,
                'status' => DataType::NORMAL_DATA_TYPE,
            ]);
    
            return response()->json(['success' => true, 'path' => $filePath]);
        }
    
        return response()->json(['success' => false, 'message' => 'No images have been uploaded.']);
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            $image = Picture::find($id);
            if (!$image || $image->status === DataType::DELETED_DATA_TYPE) {
                return response()->json(['error' => 'Image not found or already deleted'], 404);
            }
            $image->status = DataType::DELETED_DATA_TYPE;
            $image->save();

            $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
            $images = Picture::where('product_id', $image->product_id)->where('status', DataType::NORMAL_DATA_TYPE)->get();
            $product = Product::find($image->product_id);
            $materials = Material::where('status', DataType::NORMAL_DATA_TYPE)->get();

            $html = view('backend::product.table.imagelist', [
                'images' => $images,
                'product' => $product,
                'types' => $types,
                'materials' => $materials
            ])->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the image'], 500);
        }
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

    public function productState(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
    
            $product->locked = ($product->locked == 'normal') ? 'locked' : 'normal';
            $product->save();
    
            return redirect()->back()->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the product'], 500);
        }
    }

    public function deleteProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if ($product->stock != 0) {
                return response()->json(['error' => 'Product cannot be deleted as it still has stock'], 400);
            }
    
            $product->status = DataType::DELETED_DATA_TYPE;
            $product->deleted_at = Carbon::now();
            $product->save();
    
            return redirect()->route('admin-product-index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }
}
