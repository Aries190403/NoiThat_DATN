<?php

namespace Modules\Backend\Http\Service;

use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryService
{
    public function getId($id)
    {
        return Category::where('id', $id)->firstOrFail();
    }

    public function getProduct($menu, $request)
    {
        $query = $menu->product()
            ->select('id', 'name', 'description', );
        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}