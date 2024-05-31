@extends('layouts.main')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container content">
        <div class="row dashboard-box">
            <form action="" method="post" class="mb-3">
                <select name="" id="">
                    <option value="">All</option>
                    <option value="">Today</option>
                    <option value="">This week</option>
                    <option value="">This month</option>                   
                </select>
            </form>
            <div class="col-md-3">
                <div class="card text-center p-2">
                    <h4>Total Products</h4>
                    <h4>{{ count($products) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-2">
                    <h4>Total Sales</h4>
                    <h4>Rs. {{ $totalSales }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-2">
                    <h4>Total Investment</h4>
                    <h4>Rs. {{ $total_investment }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-2">
                    <h4>Total Revenue</h4>
                    <h4>Rs. {{ $totalSales - $totalCost }}</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
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
