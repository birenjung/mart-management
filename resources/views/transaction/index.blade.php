@extends('layouts.main')
@section('title')
    Transactions
@endsection

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card content">
                    <div class="card-header">
                        Transactions
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaction.index') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="date" name="date" class="form-control">
                                <button type="submit" class="btn btn-outline-primary">Search</button>
                            </div>
                            
                        </form>
                        <div class="table-responsive mt-3">
                            <table id="example" class="display" class="table">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>CP</th>
                                        <th>SP</th>
                                        <th>Sold At</th>
                                        <th>Profit|loss</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sn = 1;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        @foreach ($transaction['check_out']['products'] as $item)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $item['product_name'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>Rs. {{ $item['CP'] }}</td>
                                                <td>Rs. {{ $item['SP'] }}</td>
                                                <td>{{ $item['sold_at'] }}</td>
                                                <td>Rs. {{ $item['SP'] - $item['CP'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
