<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService) {
        $filters = $request->only(['name', 'product', 'total']);
        $sales = $dashboardService->getSales($filters);
        
        return view('dashboard', compact('sales'));
    }

    public function generatePdf(Request $request, DashboardService $dashboardService) {
        $filters = $request->only(['name', 'product', 'total']);
        $sales = $dashboardService->getForPdf($filters);
        
        $pdf = Pdf::loadView('generate-pdf', compact('sales', 'filters'));
        return $pdf->download('relatorio.pdf');
    }
}
