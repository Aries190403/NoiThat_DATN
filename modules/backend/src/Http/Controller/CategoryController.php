<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        return view('backend::category.index', ['title' => $title, 'categories' => $categories, 'icons' => $icons, 'types' => $types]);
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
        // $category->save();

        return redirect()->route('admin-category-index')->with('success', 'Category updated successfully');

    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $content = json_decode($category->content, true);
        $content['icon'] = $request->input('icon');
        
        $category->name = $request->input('name');
        $category->type = $request->input('type');
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
}
