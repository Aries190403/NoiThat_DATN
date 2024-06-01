<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainAdminController extends Controller
{
    public function index()
    {
        $title = "home";
        return view('backend::layout.home', compact('title'));
    }
}
