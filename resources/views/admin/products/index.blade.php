@extends('layouts.admin')

@section('title')
{{$title}} <a href="/admin/products/create">Create</a>
@endsection

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
    </ol>

@endsection

@section('content')

@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

<!-- <h2><?php //echo $title ?></h2> -->

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>NAME</th>
            <th>CATEGORY</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>STATUS</th>
            <th>CREATED AT</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <!-- we have automatic directives istead of this way -->
        <!-- <?php// foreach($products as $product) : // : istead of '{' ?> -->
            @foreach($products as $product)
        
        <tr>
            <td><img src="{{ asset('uploads/'. $product->image_path) }}" width="60" alt=""></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td><a href="{{ route('products.edit', $product->id)}}" class="btn btn-sm btn-dark">Edit</a></td>
            <td><form action="{{ route('products.destroy', $product->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form></td>
        </tr>
        @endforeach
        <!-- <?php// endforeach // istead of '}' ?> -->
    </tbody>
</table>


        <!-- to use pagination which in db 
        but i have to initialize it from the appServiceProvider-->
        {{ $products->links() }}
        <!--  i decided to change in pagination internal folder  -->
    



@endsection
