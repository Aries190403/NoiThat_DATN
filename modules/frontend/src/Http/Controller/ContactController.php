<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend::layout.contact');
    }

    public function store(Request $request)
    {
    }
}
