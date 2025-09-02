<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboardService) {
        $sales = $dashboardService->getRecentSales();
        return view('dashboard', compact('sales'));
    }
}
