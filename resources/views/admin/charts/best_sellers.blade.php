@extends('layouts.admin')

@section('title', 'Top Selling Perfumes — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Reports</span>
            <h1 class="pa-page-title">Top Selling Perfumes</h1>
        </div>
        <span style="font-size:0.62rem; letter-spacing:0.18em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
            {{ now()->format('F d, Y') }}
        </span>
    </div>

    {{-- ── Filter Bar ── --}}
    <div style="background:#FDFBF8; border:1px solid #D6D0C8;">

        {{-- Bar label --}}
        <div style="padding:0.6rem 2rem; background:var(--ink); display:flex; align-items:center; gap:0.6rem;">
            <span style="width:5px; height:5px; background:var(--gold); display:inline-block; flex-shrink:0;"></span>
            <span style="font-size:0.55rem; letter-spacing:0.3em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                Date Range Filter
            </span>
            @if(request('start_date') || request('end_date'))
                <span style="margin-left:auto; font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300;">
                    ● Active
                </span>
            @endif
        </div>

        <div style="padding:1.5rem 2rem;">
            <form id="date-range-form" style="display:flex; align-items:flex-end; gap:1.5rem; flex-wrap:wrap;">

                <div style="display:flex; flex-direction:column; gap:0.4rem;">
                    <label for="start_date" style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                        From
                    </label>
                    <input type="date" id="start_date" name="start_date"
                           value="{{ request('start_date') }}"
                           style="background:#fff; border:1px solid #C8BEB2; color:#1A1714; font-family:'Jost',sans-serif; font-weight:300; font-size:0.85rem; padding:0.6rem 0.9rem; outline:none; transition:border-color 0.2s; width:180px;"
                           onfocus="this.style.borderColor='#B5975A'"
                           onblur="this.style.borderColor='#C8BEB2'">
                </div>

                <div style="display:flex; flex-direction:column; gap:0.4rem;">
                    <label for="end_date" style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                        To
                    </label>
                    <input type="date" id="end_date" name="end_date"
                           value="{{ request('end_date') }}"
                           style="background:#fff; border:1px solid #C8BEB2; color:#1A1714; font-family:'Jost',sans-serif; font-weight:300; font-size:0.85rem; padding:0.6rem 0.9rem; outline:none; transition:border-color 0.2s; width:180px;"
                           onfocus="this.style.borderColor='#B5975A'"
                           onblur="this.style.borderColor='#C8BEB2'">
                </div>

                <div style="display:flex; gap:0.75rem; align-items:center;">
                    <button type="submit"
                            style="background:var(--ink); color:var(--ivory); border:1px solid var(--ink); font-family:'Jost',sans-serif; font-size:0.62rem; font-weight:300; letter-spacing:0.22em; text-transform:uppercase; padding:0.65rem 2rem; cursor:pointer; transition:background 0.25s, color 0.25s, border-color 0.25s; white-space:nowrap;"
                            onmouseover="this.style.background='#B5975A'; this.style.borderColor='#B5975A'; this.style.color='#1A1714'"
                            onmouseout="this.style.background='var(--ink)'; this.style.borderColor='var(--ink)'; this.style.color='var(--ivory)'">
                        Apply Filter
                    </button>

                    @if(request('start_date') || request('end_date'))
                        <a href="{{ request()->url() }}"
                           style="font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--stone); text-decoration:none; font-family:'Jost',sans-serif; font-weight:300; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
                           onmouseover="this.style.color='#C97A7A'; this.style.borderBottomColor='#C97A7A'"
                           onmouseout="this.style.color='var(--stone)'; this.style.borderBottomColor='transparent'">
                            ✕ Clear
                        </a>
                    @endif
                </div>

                {{-- Active range pill --}}
                @if(request('start_date') || request('end_date'))
                    <div style="margin-left:auto; padding:0.45rem 1rem; border:1px solid rgba(181,151,90,0.3); background:rgba(181,151,90,0.06); display:flex; align-items:center; gap:0.6rem;">
                        <span style="width:5px; height:5px; background:var(--gold); display:inline-block; border-radius:50%; flex-shrink:0;"></span>
                        <span style="font-size:0.6rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300;">
                            @if(request('start_date') && request('end_date'))
                                {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }} — {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                            @elseif(request('start_date'))
                                From {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }}
                            @elseif(request('end_date'))
                                Until {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                            @endif
                        </span>
                    </div>
                @endif

            </form>
        </div>
    </div>

    {{-- ── Charts / Empty State ── --}}
    <div class="pa-section">
        @php $chartLabels = $chart->labels ?? []; @endphp

        @if(empty($chartLabels))

            {{-- ── Empty State ── --}}
            <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:7rem 2rem; text-align:center;">
                <div style="display:flex; align-items:center; justify-content:center; gap:1.2rem; margin-bottom:2rem;">
                    <span style="display:block; height:1px; width:50px; background:linear-gradient(to right, transparent, var(--stone));"></span>
                    <span style="font-size:0.55rem; letter-spacing:0.35em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">No Data</span>
                    <span style="display:block; height:1px; width:50px; background:linear-gradient(to left, transparent, var(--stone));"></span>
                </div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:var(--ink); letter-spacing:0.06em; font-style:italic; margin-bottom:0.75rem;">
                    No sales data available
                </p>
                <p style="font-size:0.72rem; color:var(--stone); letter-spacing:0.12em; font-family:'Jost',sans-serif; font-weight:300; text-transform:uppercase;">
                    @if(request('start_date') || request('end_date'))
                        No orders found for the selected date range
                    @else
                        Orders will appear here once sales are recorded
                    @endif
                </p>
            </div>

        @else

            {{-- ── Bar Chart ── --}}
            <div style="background:#FDFBF8; border:1px solid #D6D0C8;">
                <div style="padding:0.6rem 2rem; background:var(--ink); display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span style="width:5px; height:5px; background:var(--gold); display:inline-block; flex-shrink:0;"></span>
                        <span style="font-size:0.55rem; letter-spacing:0.3em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                            Units Sold
                        </span>
                    </div>
                    <span style="font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; opacity:0.6;">
                        Top {{ count($chartLabels) }} Products
                    </span>
                </div>
                <div style="padding:2rem 2rem 2.5rem;">
                    <h2 style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:300; color:var(--ink); letter-spacing:0.06em; font-style:italic; line-height:1; margin-bottom:2rem;">
                        Best Performing Products
                    </h2>
                    <div style="position:relative; height:400px; width:100%;">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>

            {{-- ── Two-column: Pie + Yearly ── --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1px; background:#D6D0C8; margin-top:1px;">

                {{-- Pie Chart --}}
                <div style="background:#FDFBF8;">
                    <div style="padding:0.6rem 2rem; background:var(--ink); display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <span style="width:5px; height:5px; background:var(--gold); display:inline-block; flex-shrink:0;"></span>
                            <span style="font-size:0.55rem; letter-spacing:0.3em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                                Sales Share
                            </span>
                        </div>
                        <span style="font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; opacity:0.6;">
                            Top {{ count($chartLabels) }}
                        </span>
                    </div>
                    <div style="padding:2rem 2rem 2.5rem;">
                        <h2 style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:300; color:var(--ink); letter-spacing:0.06em; font-style:italic; line-height:1; margin-bottom:2rem;">
                            Product Contribution
                        </h2>
                        <div style="position:relative; height:320px; width:100%;">
                            {!! $pieChart->container() !!}
                        </div>
                    </div>
                </div>

                {{-- Yearly Sales Chart --}}
                <div style="background:#FDFBF8;">
                    <div style="padding:0.6rem 2rem; background:var(--ink); display:flex; align-items:center;">
                        <span style="width:5px; height:5px; background:var(--gold); display:inline-block; flex-shrink:0; margin-right:0.6rem;"></span>
                        <span style="font-size:0.55rem; letter-spacing:0.3em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                            Year on Year
                        </span>
                    </div>
                    <div style="padding:2rem 2rem 2.5rem;">
                        <h2 style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:300; color:var(--ink); letter-spacing:0.06em; font-style:italic; line-height:1; margin-bottom:2rem;">
                            Total Sales Per Year
                        </h2>
                        <div style="position:relative; height:320px; width:100%;">
                            {!! $yearlyChart->container() !!}
                        </div>
                    </div>
                </div>

            </div>

        @endif
    </div>

</div>
@endsection

@section('scripts')
    {!! $chart->script() !!}
    {!! $pieChart->script() !!}
    {!! $yearlyChart->script() !!}
    <script>
        document.getElementById('date-range-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const start = document.getElementById('start_date').value;
            const end   = document.getElementById('end_date').value;
            const url   = new URL(window.location.href);
            url.searchParams.set('start_date', start);
            url.searchParams.set('end_date', end);
            window.location.href = url.toString();
        });
    </script>
@endsection