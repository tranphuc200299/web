<?php

namespace Core\Http\Controllers\Web;

use Core\Http\Controllers\Controller;

class TopController extends Controller
{
    public function index()
    {
        return view('core::index');
    }
}