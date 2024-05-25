@extends('layouts.main')
@section('title')
    Create product category
@endsection

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card content">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Product Category</h3>
                        <a href="{{ route('product_category.create') }}" class="btn btn-primary">Add product category</a>
                    </div>

                    <div class="card-body">                       
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Category</th>
                                        <th>Status</th>                                       
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sn = 1;

                                    @endphp
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>{{ $sn++ }}</td>
                                            <td>{{ $item->category_name }}</td>
                                           <td>
                                            @php
                                                if ($item->category_status == 'active') {
                                                    @endphp
                                                    <span class="text-success">Active</span>
                                                    @php
                                                } elseif($item->category_status == 'inactive') {
                                                    @endphp
                                                    <span class="text-danger">Inactive</span>
                                                    @php
                                                }
                                            @endphp
                                           </td>
                                            <td>
                                                <a href="{{route('product_category.edit', $item->category_id)}}"  class="btn btn-secondary">Edit</a>
                                            </td>
                                            <td>                                                  
                                                <form action="{{ route('change.status.pcategory', $item->category_id) }}"
                                                    method="POST">
                                                    @csrf                                                    
                                                    <button type="submit" class="btn btn-primary">Change status</button>
                                                </form>     

                                            </td>
                                            <td>
                                                <form action="{{ route('product_category.destroy', $item->category_id) }}"
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
                                        <th>Category</th>
                                        <th>Status</th>                                       
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
