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

    public function getSales(array $filters) {
        $query = Sale::with(['user', 'product'])->orderBy('created_at', 'desc');

        if(!empty($filters['name'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%');
            });
        }

        if(!empty($filters['product'])) {
            $query->whereHas('product', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['product'] . '%');
            });
        }

        if(!empty($filters['total'])) {
            $query->where('total', '<=', $filters['total']);
        }

        return $query->paginate(15);
    }
}
