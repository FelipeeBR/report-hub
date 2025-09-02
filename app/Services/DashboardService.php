<?php

namespace App\Services;

use App\Models\Sale;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getRecentSales() {
        return Sale::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
