@extends('layouts.admin')

@section('title')
<div class="d-flex justify-content-between">
    <h2>{{$title}}</h2>
</div>
 
@endsection

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Trash</li>
    </ol>

@endsection

@section('content')

@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

<!-- <h2>php //echo $title </h2> -->
<div class="d-flex mb-4">
    <form action="{{ route('products.restore')}}" method="post" class="mr-3">
        @csrf
        @method('put')
        <button type="submit" class="btn btn-sm btn-warning">Restore All</button>
    </form>

    <form action="{{ route('products.force-delete')}}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-sm btn-danger">Delete All</button>
    </form>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>NAME</th>
            <th>CATEGORY</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>STATUS</th>
            <th>DELETED AT</th>
            <th></th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <!-- we have automatic directives istead of this way -->
        <!-- php// foreach($products as $product) : // : istead of '{' ?> -->
            @foreach($products as $product)
        
        <tr>
            <td><img src="{{ asset('uploads/'. $product->image_path) }}" width="60" alt=""></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->deleted_at }}</td>

            <td><form action="{{ route('products.restore', $product->id)}}" method="post">
                @csrf
                @method('put')
                <button type="submit" class="btn btn-sm btn-warning">Restore</button>
            </form></td>

            <td><form action="{{ route('products.force-delete', $product->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger">Delete Permenant</button>
            </form></td>
        </tr>
        @endforeach
        <!-- php// endforeach // istead of '}' ?> -->
    </tbody>
</table>


        <!-- to use pagination which in db 
        but i have to initialize it from the appServiceProvider-->
        {{ $products->links() }}
        <!--  i decided to change in pagination internal folder  -->
    



@endsection
