<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($id)
    {
        return redirect('/shop');
    }

    public function store(Request $request)
    {
    }
}
