<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class BestSellingPerfume extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // fetch top 10 best-selling products by quantity
        $data = \App\Models\Product::select('products.product_name', \DB::raw('SUM(order_details.quantity) as total'))
            ->join('order_details', 'products.product_id', '=', 'order_details.product_id')
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // Only set chart data if we have results
        if ($data->isNotEmpty()) {
            $this->labels($data->pluck('product_name')->toArray());
            $this->dataset('Units Sold', 'bar', $data->pluck('total')->toArray())
                ->backgroundColor('rgba(54, 162, 235, 0.5)')
                ->color('rgba(54, 162, 235, 1)');
        }
    }
}
