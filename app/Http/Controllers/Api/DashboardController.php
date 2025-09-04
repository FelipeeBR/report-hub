<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailReport;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService) {
        $sales = $dashboardService->getSales($request->all());

        return response()->json([
            'data' => $sales,
        ], Response::HTTP_OK);
    }

    public function generatePDF(Request $request, DashboardService $dashboardService) {
        try {
            $user = Auth::user();
            $filters = $request->only(['name', 'product', 'total']);
            $sales = $dashboardService->getForPdf($filters);
            
            $pdf = Pdf::loadView('generate-pdf', compact('sales', 'filters'));
            
            $hash = Str::random(10);
            $pdfPath = storage_path("app/public/relatorio_{$hash}.pdf");
            $pdf->save($pdfPath);

            SendEmailReport::dispatch($pdfPath, $user);
            return response()->json(['success' => 'Relatorio enviado com sucesso'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao enviar relatorio: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
