<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        return view('auth.login');
    }
}
