<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CartFrontendController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Giả sử bạn có thể lấy sản phẩm từ cơ sở dữ liệu
        $product = DB::table('products')
            ->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('pictures', 'products.id', '=', 'pictures.product_id')
            ->leftJoin('materials', 'product_details.material_id', '=', 'materials.id')
            ->leftJoin('galleries', 'products.gallery_id', '=', 'galleries.id')
            ->where('products.id', $id)
            ->select(
                // Product
                'products.id as product_id',
                'products.category_id',
                'products.gallery_id',
                'products.name as product_name',
                'products.sale_percentage',
                'products.description as product_description',
                'products.content as product_content',
                'products.status as product_status',

                'product_details.price as product_details_price',
                // CATEGORY
                'categories.name as category_name',
                'categories.type as category_type',
                'categories.description as category_description',
                'categories.content as category_content',
                // Gallery
                'galleries.parent as galleries_parent',
                'galleries.description as description',
                // Material
                'materials.name as materials_name',
                'materials.color as materials_color',
                'materials.type as materials_type',
                'materials.description as materials_description',
                DB::raw('GROUP_CONCAT(DISTINCT product_details.size ORDER BY product_details.size ASC) as sizes'),
                DB::raw('GROUP_CONCAT(DISTINCT materials.name ORDER BY materials.name ASC) as materials'),
                DB::raw('SUM(product_details.stock) as total_stock'),
                DB::raw('GROUP_CONCAT(DISTINCT pictures.image ORDER BY pictures.created_at DESC) as images')
            )
            ->groupBy(
                'products.id',
                'products.category_id',
                'products.gallery_id',
                'products.name',
                'products.sale_percentage',
                'products.description',
                'products.content',
                'products.status',
                'product_details.price',
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
                'materials.description'
            )
            ->first(); // Lấy một bản ghi duy nhất cho sản phẩm với ID cụ thể

        //dd($data);

        // Lấy giỏ hàng từ session, nếu chưa có thì khởi tạo mảng rỗng
        $cart = Session::get('cart', []);

        $thumbnail = json_decode($product->product_content)->images[0];

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if (isset($cart[$id])) {
            // Nếu có, tăng số lượng sản phẩm
            $cart[$id]['quantity']++;
        } else {
            // Nếu chưa, thêm sản phẩm mới vào giỏ hàng
            $cart[$id] = [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'price' => $product->product_details_price,
                'sale_percentage' => $product->sale_percentage,
                'image' => $thumbnail,
                'quantity' => 1
            ];
        }

        // Cập nhật giỏ hàng trong session
        Session::put('cart', $cart);

        return redirect()->back()->with('ok', 'Product added to cart!');
    }



    public function view(cart $cart)
    {
        // dd(session('cart'));
        return view('frontend::layout.home', compact('cart'));
    }
}
