<?php

namespace App\Jobs;

use App\Models\Sale;
use App\Services\DashboardService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProccessReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $saleIds;
    public $filters;
    /**
     * Create a new job instance.
     */
    public function __construct(array $saleIds, array $filters)
    {
        $this->saleIds = $saleIds;
        $this->filters = $filters;
    }

    /**
     * Execute the job.
     */
    public function handle(DashboardService $dashboardService): void
    {
        $sales = Sale::whereIn('id', $this->saleIds)->get();
        Log::info('Processando relatorio', ['sales' => $sales]);
    }
}
