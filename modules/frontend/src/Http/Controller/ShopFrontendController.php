<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\picture;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopFrontendController extends Controller
{
    public function index()
    {
        // $data = product::orderBy('id', 'DESC')->paginate(10);
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('pictures', 'products.id', '=', 'pictures.product_id')
            ->leftJoin('materials', 'products.material_id', '=', 'materials.id')
            ->select(
                //Product
                'products.id as product_id',
                'products.category_id',
                'products.name as product_name',
                'products.price as product_price',
                'products.stock as total_stock',
                'products.sale_percentage',
                'products.description as product_description',
                'products.content as product_content',
                'products.status as product_status',

                //CATEGORY
                'categories.name as category_name',
                'categories.type as category_type',
                'categories.description as category_description',
                'categories.content as category_content',
                //material
                'materials.name as materials_name',
                'materials.color as materials_color',
                'materials.type as materials_type',
                'materials.description as materials_description',
                'materials.content as content',
                DB::raw('GROUP_CONCAT(DISTINCT materials.name ORDER BY materials.name ASC) as materials'),
                DB::raw('GROUP_CONCAT(DISTINCT pictures.image ORDER BY pictures.created_at DESC) as images')
            )
            ->groupBy(
                'products.id',
                'products.category_id',
                'products.name',
                'products.price',
                'products.stock',
                'products.sale_percentage',
                'products.description',
                'products.content',
                'products.status',
                'categories.id',
                'categories.name',
                'categories.type',
                'categories.description',
                'categories.content',
                'materials.name',
                'materials.color',
                'materials.type',
                'materials.description',
                'materials.content',
            )
            ->where('products.status', 'normal')
            ->orderBy('products.id', 'DESC')
            ->paginate(10);
        // dd($data);
        return view('frontend::layout.shop', ['data' => $data]);
    }

    public function detail($id = '')
    {
        $product = product::find($id);
        if($product->status != 'normal' || !$product){
            return response()->view('frontend::error.404', ['title' => 'error'], 403);
        }
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('pictures', 'products.id', '=', 'pictures.product_id')
            ->leftJoin('materials', 'products.material_id', '=', 'materials.id')
            ->where('products.id', $id)
            ->select(
                //Product
                'products.id as product_id',
                'products.category_id',
                'products.name as product_name',
                'products.price as product_price',
                'products.stock as total_stock',
                'products.sale_percentage',
                'products.description as product_description',
                'products.content as product_content',
                'products.status as product_status',

                //CATEGORY
                'categories.name as category_name',
                'categories.type as category_type',
                'categories.description as category_description',
                'categories.content as category_content',
                //material
                'materials.name as materials_name',
                'materials.color as materials_color',
                'materials.type as materials_type',
                'materials.description as materials_description',
                'materials.content as content',
                DB::raw('GROUP_CONCAT(DISTINCT materials.name ORDER BY materials.name ASC) as materials'),
                DB::raw('GROUP_CONCAT(DISTINCT pictures.image ORDER BY pictures.created_at DESC) as images')
            )
            ->groupBy(
                'products.id',
                'products.category_id',
                'products.name',
                'products.price',
                'products.stock',
                'products.sale_percentage',
                'products.description',
                'products.content',
                'products.status',
                'categories.id',
                'categories.name',
                'categories.type',
                'categories.description',
                'categories.content',
                'materials.name',
                'materials.color',
                'materials.type',
                'materials.description',
                'materials.content',
            )
            ->first();
        $rates = DB::table('rates')
            ->select('rates.*', 'users.name as user_name')
            ->join('users', 'rates.user_id', '=', 'users.id')
            ->where('rates.product_id', $id)
            ->where('rates.status', 1)
            ->orderByDesc('rates.id')
            ->get();
        foreach ($rates as $rate) {
            $rate->image_user = picture::where('id', User::where('id', $rate->user_id)->pluck('avatar'))->pluck('image');
        }
        // dd($rates);
        return view('frontend::layout.productdetail', ['data' => $data, 'rates' => $rates]);
    }
    public function filterProducts(Request $request)
    {
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('pictures', 'products.id', '=', 'pictures.product_id')
            ->leftJoin('materials', 'products.material_id', '=', 'materials.id')
            ->select(
                //Product
                'products.id as product_id',
                'products.category_id',
                'products.name as product_name',
                'products.price as product_price',
                'products.stock as total_stock',
                'products.sale_percentage',
                'products.description as product_description',
                'products.content as product_content',
                'products.status as product_status',

                //CATEGORY
                'categories.name as category_name',
                'categories.type as category_type',
                'categories.description as category_description',
                'categories.content as category_content',
                //material
                'materials.name as materials_name',
                'materials.color as materials_color',
                'materials.type as materials_type',
                'materials.description as materials_description',
                'materials.content as content',
                DB::raw('GROUP_CONCAT(DISTINCT materials.name ORDER BY materials.name ASC) as materials'),
                DB::raw('GROUP_CONCAT(DISTINCT pictures.image ORDER BY pictures.created_at DESC) as images')
            )
            ->groupBy(
                'products.id',
                'products.category_id',
                'products.name',
                'products.price',
                'products.stock',
                'products.sale_percentage',
                'products.description',
                'products.content',
                'products.status',
                'categories.id',
                'categories.name',
                'categories.type',
                'categories.description',
                'categories.content',
                'materials.name',
                'materials.color',
                'materials.type',
                'materials.description',
                'materials.content',
            )
            ->where('products.status', 'normal')
            ->orderBy('products.id', 'DESC');

        $query = $data;
        if ($request->input('price')) {
            list($minPrice, $maxPrice) = explode(';', $request->input('price'));
            $query->whereBetween('products.price', [(float) $minPrice, (float) $maxPrice]);
        }

        if ($request->input('type') && $request->input('type') !== 'All') {
            $query->where('products.category_id', (int) $request->input('type'));
        }

        if ($request->input('material') && $request->input('material') !== 'All') {
            $query->where('products.material_id', (int) $request->input('material'));
        }

        $products = $query->paginate(100); // Phân trang, mỗi trang 10 sản phẩm
        return response()->json(['products' => $products]);
    }
}
