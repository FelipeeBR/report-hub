<?php

namespace App\Jobs;

use App\Mail\PdfMail;
use App\Models\User;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// class GeneratePdfReport implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     public $filters;
//     public $userId;

//     /**
//      * Create a new job instance.
//      */
//     public function __construct($filters, $userId)
//     {
//         $this->filters = $filters;
//         $this->userId = $userId;
//     }

//     /**
//      * Execute the job.
//      */
//     public function handle(DashboardService $dashboardService): void {
//         $user = User::find($this->userId);
//         $sales = $dashboardService->getForPdf($this->filters);

//         $pdf = Pdf::loadView('generate-pdf', [
//             'sales' => $sales,
//             'filters' => $this->filters
//         ]);

//         $hash = Str::random(10);
//         $pdfPath = storage_path("app/public/relatorio_{$hash}.pdf");
//         $pdf->save($pdfPath);

//         Mail::to($user->email)->send(new PdfMail($pdfPath, $user));

//         if (file_exists($pdfPath)) {
//             unlink($pdfPath);
//         }

//         Log::info("Rodando job GeneratePdfReport", ['user' => $user]);
//     }
// }
