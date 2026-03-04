@extends('layouts.admin')

@section('content')
    <div class="px-8 py-6">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold text-gold-400 mb-4 tracking-wider">Top Selling Perfumes</h1>
            <p class="text-gold-300 text-lg font-light tracking-widest uppercase">Sales Report</p>
        </div>

        <div class="bg-black/40 backdrop-blur-sm border border-gold-400/20 rounded-lg shadow-2xl p-6">
            @php
                // Debug: Check if chart has data
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
@endsection

@section('scripts')
    {!! $chart->script() !!}
@endsection
