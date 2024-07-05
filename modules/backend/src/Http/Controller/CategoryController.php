<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataCategoryType;
use Modules\Backend\Http\Data\DataType;
use Modules\Backend\Http\Service\CategoryService;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(CategoryService $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $title = "Categoties";
        $categories = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $path = base_path('modules/backend/resources/configs/icon.json');
        $icons = json_decode(File::get($path), true);
        $types = config('backendconfig.types');
        $products = product::where('status', '!=', DataType::DELETED_DATA_TYPE)->get();
        return view('backend::category.index', ['title' => $title, 'categories' => $categories, 'icons' => $icons, 'types' => $types, 'products' => $products]);
    }

    public function Create(Request $request)
    {
        $icon = $request->input('icon');
        $contentData = [
            'icon' => $icon
        ];

        $category = new Category();
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        $category->content = json_encode($contentData);
        $category->status = DataType::NORMAL_DATA_TYPE;
        $category->save();

        return redirect()->route('admin-category-index')->with('success', 'Category updated successfully');

    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin-category-index')->with('error', 'Category not found');
        }
    
        $content = json_decode($category->content, true);
    
        if ($request->filled('icon')) {
            $content['icon'] = $request->input('icon');
        }
    
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        
        $content['products'] = $request->input('products') ?? [];
        $content['products'] = json_encode($content['products']);
    
        if ($request->hasFile('thumbnail')) {
            $disk = 'uploads';
            $directory = '/uploads/images/product';
            $filePath = $this->storeImage($request->file('thumbnail'), $disk, $directory);
            
            $content['imgThumbnail'] = $filePath;
        }
    
        $category->content = json_encode($content);
        $category->save();
    
        return redirect()->route('admin-category-index')->with('success', 'Category updated successfully');
    }
    
    // public function update(Request $request, $id)
    // {
    //     $category = Category::find($id);
    //     $category->name = (string)$request->input('name');
    //     $category->description= (string)$request->input('description');
    //     $category->save();
    //     return redirect()->route('category-index')->with('success', 'Category updated successfully.');
    // }

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
