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
            ->paginate(15);
    }

    public function getSalesClient($name) {
        return Sale::with(['user'])->whereHas('user', function ($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%');
        })->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getProductClient($product) {
        return Sale::with(['product'])->whereHas('product', function ($q) use ($product) {
            $q->where('name', 'like', '%' . $product . '%');
        })->orderBy('created_at', 'desc')->paginate(15);
    }
}
