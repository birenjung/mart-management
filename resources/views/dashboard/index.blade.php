@extends('layouts.main')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Recent Top Selling Products
                    </div>
                    <div class="card-body">
                        @php
                            $sn = 1;
                        @endphp
                        @foreach ($topProducts as $item)
                            <h4>{{ $sn++ }}. {{ $item->product_name }}</h4>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <canvas id="monthlySalesChart"></canvas>
                
            </div>
        </div>
        <div>

        </div>
    </div>
    <script>
        console.log(@json($months));
        console.log(@json($quantities));
        var ctx = document.getElementById('monthlySalesChart').getContext('2d');
        var monthlySalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Quantity Sold',
                    data: @json($quantities),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
