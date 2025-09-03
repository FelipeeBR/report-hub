<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Jobs\GeneratePdfReport;
use App\Jobs\ProccessReport;
use App\Jobs\SendEmailReport;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService) {
        $filters = $request->only(['name', 'product', 'total']);
        $sales = $dashboardService->getSales($filters);

        $saleIds = $sales->pluck('id')->toArray();

        ProccessReport::dispatch($saleIds, $filters);
        
        return view('dashboard', compact('sales'));
    }

    public function generatePdf(Request $request, DashboardService $dashboardService) {
        try {
            $user = Auth::user();
            $filters = $request->only(['name', 'product', 'total']);
            $sales = $dashboardService->getForPdf($filters);
            
            $pdf = Pdf::loadView('generate-pdf', compact('sales', 'filters'));
            
            $hash = Str::random(10);
            $pdfPath = storage_path("app/public/relatorio_{$hash}.pdf");
            $pdf->save($pdfPath);

            SendEmailReport::dispatch($pdfPath, $user);

            return redirect()->route('dashboard')->with('success', 'Relatorio enviado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erro ao enviar relatorio: ' . $e->getMessage());
        }
    }

    /*public function generatePdf(Request $request, DashboardService $dashboardService) {
        try {
            $user = Auth::user();
            $filters = $request->only(['name', 'product', 'total']);
            $sales = $dashboardService->getForPdf($filters);
            GeneratePdfReport::dispatch($filters, $user);
            return redirect()->route('dashboard')->with('success', 'Relatorio enviado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erro ao enviar relatorio: ' . $e->getMessage());
        }
    }*/
}
