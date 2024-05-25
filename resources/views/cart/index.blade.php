@extends('layouts.main')
@section('title')
    Cart
@endsection

@section('content')
    <div class="container content">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Cart Items
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sn = 1;
                                    @endphp
                                    @if ($cart_items && is_array($cart_items['products']))
                                        @foreach ($cart_items['products'] as $item)
                                            <tr data-product-id="{{ $item['product_id'] }}">
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $item['product']->product_name }}</td>
                                                <td>Rs. {{ number_format($item['product']->product_price, 2) }}</td>
                                                <td>
                                                    <input type="number" class="quantity" value="{{ $item['quantity'] }}"
                                                        min="1" data-product-id="{{ $item['product_id'] }}">
                                                </td>
                                                <td class="subtotal">
                                                    Rs.
                                                    {{ number_format($item['product']->product_price * $item['quantity'], 2) }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('cart.remove', $item['product_id']) }}"
                                                        method="POST">
                                                        @csrf

                                                        <button type="submit" class="btn btn-danger">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @if ($grandTotal > 0)
                                                <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                                                <td colspan="2" id="grand-total">
                                                    <strong>Rs. {{ number_format($grandTotal, 2) }}</strong>
                                                </td>
                                            @endif
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Your cart is empty.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-column justify-content-center mt-5">
                            @if ($grandTotal > 0)
                                <p>After the payment, click below.</p>

                                <form action="{{ route('check.out') }}" method="post">
                                    @csrf
                                    <button class="btn btn-success" style="width: 50%">Check out</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.quantity').on('input', function() {
                var productId = $(this).data('product-id');
                var quantity = $(this).val();

                $.ajax({
                    url: '{{ route('cart.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PATCH',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            var row = $('tr[data-product-id="' + productId + '"]');
                            var subtotal = row.find('.subtotal');
                            subtotal.text('Rs. ' + response.newSubtotal.toFixed(2));
                            // Update the grand total
                            $('#grand-total strong').text('Rs. ' + response.grandTotal.toFixed(
                                2));
                        }
                        if (response.status === 100) {
                            alert('The product is out of stock.');
                            // Alert::info('Sorry');
                            $('.quantity').val(response.quantity);
                        }
                    }
                });
            });
        });
    </script>
@endsection
