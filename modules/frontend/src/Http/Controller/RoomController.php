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

class RoomController extends Controller
{
    public function index($id)
    {
        try {
            $Category = Category::where('id', $id)->where('status', 'normal')->where('type', 'Rooms')->get();

            if ($Category->isEmpty()) {
                return view('frontend::error.404');
            }

            $content = json_decode($Category[0]->content);
            $Ids = json_decode($content->products);
            $data = [];
            foreach ($Ids as $id) {
                $product = Product::find($id);
                if ($product) {
                    $data[] = $product;
                }
            }
            $imgThumbnail = json_decode($Category[0]->content)->imgThumbnail;
            // dd($imgThumbnail);
            return view('frontend::layout.room', ['data' => $data, 'imgThumbnail' => $imgThumbnail]);
        } catch (\Throwable $th) {
            return view('frontend::error.404');
        }
    }

    public function filterroomProducts(Request $request, $id)
    {
        try {
            // Lấy danh mục phòng theo $id
            $Category = Category::where('id', $id)
                ->where('status', 'normal')
                ->where('type', 'Rooms')
                ->firstOrFail();

            // Lấy danh sách ID sản phẩm từ nội dung danh mục
            $content = json_decode($Category->content);
            $productIds = json_decode($content->products);

            // Lấy danh sách sản phẩm từ ID
            $query = Product::whereIn('id', $productIds);

            // Áp dụng điều kiện lọc theo giá nếu có
            if ($request->input('price')) {
                list($minPrice, $maxPrice) = explode(';', $request->input('price'));
                $query->whereBetween('price', [(float) $minPrice, (float) $maxPrice]);
            }

            // Thực hiện phân trang
            $products = $query->paginate(10); // Số sản phẩm trên mỗi trang là 10

            return response()->json(['products' => $products]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error fetching room products'], 500);
        }
    }
}
