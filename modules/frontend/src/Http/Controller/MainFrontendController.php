<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MainFrontendController extends Controller
{
    public function index()
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
            ->orderBy('products.id', 'DESC')
            ->paginate(6);
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cart = cart::where('user_id', $userId)->get();
            return view('frontend::layout.home', ['data' => $data, 'globalCart' => $cart]);
        }
        return view('frontend::layout.home', ['data' => $data]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        try {
            // Perform the search on the 'name' and 'category' fields
            $products = Product::where('name', 'LIKE', "%{$query}%")
                ->get();

            // Return the search results as JSON
            return response()->json($products);
        } catch (\Exception $e) {
            // Log the error and return a server error response
            // Log::error('Error searching products: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
