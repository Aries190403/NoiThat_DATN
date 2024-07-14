<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MainAdminController extends Controller
{
    public function index()
    {
        $title = "home";
        $user = Auth::user();
        return view('backend::layout.home', compact('title','user'));
    }
}
