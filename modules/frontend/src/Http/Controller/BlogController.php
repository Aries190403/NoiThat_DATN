<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend::layout.blog');
    }

    public function store(Request $request)
    {
    }
}
