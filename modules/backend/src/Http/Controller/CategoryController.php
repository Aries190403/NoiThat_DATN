<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
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
        $categories = Category::all();
        return view('backend::category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend::category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        Category::create($request->all());

        return redirect()->route('category-index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        return view('backend::category.edit',['category'=>$this->category->getId($id)]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = (string)$request->input('name');
        $category->description= (string)$request->input('description');
        $category->save();
        return redirect()->route('category-index')->with('success', 'Category updated successfully.');
    }
}
