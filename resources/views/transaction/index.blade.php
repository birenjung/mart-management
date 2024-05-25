@extends('layouts.main')
@section('title')
    Transaction
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
                        <form action="{{ route('transaction.search') }}" method="post">
                            @csrf
                            <input type="date" name="date" class="form-control">
                            <button type="submit" class="btn btn-outline-primary mt-3">Search</button>
                        </form>
                        <div class="table-responsive mt-3">
                            <table id="example" class="display" class="table">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Sold At</th>
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
                                                <td>{{ $item['sold_at'] }}</td>
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
