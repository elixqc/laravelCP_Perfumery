
@extends('layouts.admin')

@section('content')
<div class="pa-page">
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Reports</span>
            <h1 class="pa-page-title">Top Selling Perfumes</h1>
        </div>
    </div>
    <div class="pa-section">
        <div class="pa-card pa-card--chart">
            @php
                $chartLabels = $chart->labels ?? [];
            @endphp
            @if(empty($chartLabels))
                <div class="text-center py-12 text-gold-300">
                    <p class="text-lg">No sales data available yet.</p>
                    <p class="text-sm">Create some orders to see the chart populate.</p>
                </div>
            @else
                <div class="chart-wrapper" style="position: relative; height:400px; width:100%;">
                    {!! $chart->container() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {!! $chart->script() !!}
@endsection
