<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $sales = Sale::with(['user', 'product'])->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard', compact('sales'));
    }
}
