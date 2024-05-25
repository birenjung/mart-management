@extends('layouts.main')
@section('title')
    Create product category
@endsection
@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Product Category</div>
                    <div class="card-body">


                        <form method="POST" action="{{ route('product_category.store') }}" class="mt-3">
                            @csrf

                            <div class="row mb-3">
                                <label for="category_name" class="col-md-4 col-form-label text-md-end">*Category name</label>

                                <div class="col-md-6">
                                    <input id="category_name" type="text"
                                        class="form-control @error('category_name') is-invalid @enderror" name="category_name"
                                        value="{{ old('category_name') }}" autocomplete="name" autofocus>

                                    @error('category_name')
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
