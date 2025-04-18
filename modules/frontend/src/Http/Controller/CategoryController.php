<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('pictures', 'products.id', '=', 'pictures.product_id')
            ->leftJoin('materials', 'products.material_id', '=', 'materials.id')
            ->leftJoin('galleries', 'products.id', '=', 'galleries.id')
            ->select(
                //Product
                'products.id as product_id',
                'products.category_id',
                'products.name as product_name',
                'products.slug as product_slug',
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
                //Gallery
                'galleries.parent as galleries_parent',
                'galleries.description as description',
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
                'galleries.parent',
                'galleries.description',
                'materials.name',
                'materials.color',
                'materials.type',
                'materials.description',
                'materials.content',
            )
            ->orderBy('products.id', 'DESC');

        $query = $data;

        if ($request->input('type') && $request->input('type') !== 'All') {
            $query->where('products.category_id', (int) $request->input('type'));
        }

        $products = $query->paginate(100); // Phân trang, mỗi trang 10 sản phẩm
        return response()->json(['products' => $products]);
    }
}
