@extends('layouts.main')
@section('title')
    Edit product
@endsection
@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Product</div>
                    <div class="card-body">


                        <form method="POST" action="{{ route('products.update', $product->product_id) }}" class="mt-3"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="product_name" class="col-md-4 col-form-label text-md-end">*Product name</label>

                                <div class="col-md-6">
                                    <input id="product_name" type="text"
                                        class="form-control @error('product_name') is-invalid @enderror" name="product_name"
                                        value="{{ $product->product_name }}" autocomplete="name" autofocus>

                                    @error('product_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="product_sku" class="col-md-4 col-form-label text-md-end">*Product SKU</label>

                                <div class="col-md-6">
                                    <input id="product_sku" type="text"
                                        class="form-control @error('product_sku') is-invalid @enderror" name="product_sku"
                                        value="{{ $product->product_sku }}" autocomplete="name" autofocus>

                                    @error('product_sku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="product_price" class="col-md-4 col-form-label text-md-end">*Product
                                    Price</label>

                                <div class="col-md-6">
                                    <input id="product_price" type="text"
                                        class="form-control @error('product_price') is-invalid @enderror"
                                        name="product_price" value="{{ $product->product_price }}" autocomplete="name"
                                        autofocus>

                                    @error('product_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="product_category" class="col-md-4 col-form-label text-md-end">*Product
                                    Category</label>

                                <div class="col-md-6">
                                    <select name="product_category" id="" class="form-select">
                                        @foreach ($categories as $item)
                                            <option value="{{$item->category_id}}" @if ($product->product_category == $item->category_id)
                                                @selected(true)
                                            @endif>{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                    

                                    @error('product_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="product_image" class="col-md-4 col-form-label text-md-end">*Product
                                    Image</label>

                                <div class="col-md-6">
                                    <input id="product_image" type="file" class="form-control" name="product_image"
                                        value="{{ $product->product_image }}">

                                    @error('product_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="product_stock" class="col-md-4 col-form-label text-md-end">*Product
                                    Stock</label>

                                <div class="col-md-6">
                                    <input id="product_stock" type="number"
                                        class="form-control @error('product_stock') is-invalid @enderror"
                                        name="product_stock" value="{{$product->product_stock}}" autocomplete="name"
                                        autofocus>

                                    @error('product_stock')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
