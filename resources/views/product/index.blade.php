@extends('layouts.main')
@section('title')
    Product
@endsection

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card content">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Products</h3>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add product</a>
                    </div>

                    <div class="card-body">
                        {{-- @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif --}}
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Product name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Cost Price</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Stock</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sn = 1;

                                    @endphp
                                    @foreach ($products as $item)
                                        <tr>
                                            <td>{{ $sn++ }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->product_sku }}</td>
                                            <td>Rs. {{$item->product_price}}</td>
                                            <td>Rs. {{$item->product_cost_price}}</td>
                                            <td>{{$item->category}}</td>
                                            <td>
                                                <img src="{{ asset($item->product_image) }}" alt="" width="150px">
                                            </td>
                                            <td>{{ $item->product_stock }}</td>
                                            <td>
                                                <a href="{{route('products.edit', $item->product_id)}}"  class="btn btn-secondary">Edit</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('add.to.cart', ['product_id' => $item->product_id, 'user_id' => auth()->user()->user_id]) }}" class="btn btn-primary">Add to cart</a>

                                            </td>
                                            <td>
                                                <form action="{{ route('products.destroy', $item->product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Product name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Stock</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
