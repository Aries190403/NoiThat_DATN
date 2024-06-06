<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataType;

class ProductController extends Controller
{

    public function index()
    {
        $title = "Products";
        $types = Category::where('status', DataType::NORMAL_DATA_TYPE)->get();
        $Products = product::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::product.index', ['title' => $title, 'products' => $Products, 'types' => $types]);
    }
}
