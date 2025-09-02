<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService) {
        if($request->filled('name')) {
            $sales = $dashboardService->getSalesClient($request->name);
            return view('dashboard', compact('sales'));
        }

        if($request->filled('product')) {
            $sales = $dashboardService->getProductClient($request->product);
            return view('dashboard', compact('sales'));
        }

        $sales = $dashboardService->getRecentSales();
        return view('dashboard', compact('sales'));
    }
}
