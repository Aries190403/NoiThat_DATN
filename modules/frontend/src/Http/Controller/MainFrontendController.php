<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
class MainFrontendController extends Controller
{
    public function index()
    {
        return view('frontend::layout.home');
    }
}
