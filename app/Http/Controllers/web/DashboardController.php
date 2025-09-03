<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\PdfMail;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService) {
        $filters = $request->only(['name', 'product', 'total']);
        $sales = $dashboardService->getSales($filters);
        
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

            Mail::to($user->email)->send(new PdfMail($pdfPath, $user));

            if(file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return redirect()->route('dashboard')->with('success', 'Relatorio enviado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erro ao enviar relatorio: ' . $e->getMessage());
        }
    }
}
