@extends('layouts.admin')

@section('title')
<div class="d-flex justify-content-between">
    <h2>{{$title}}</h2>
    <div >
        <a class="btn btn-sm btn-outline-primary" href="{{ route('products.create') }}">Create</a>
        <a class="btn btn-sm btn-outline-dark" href="{{ route('products.trash') }}">Trash</a>
    </div>
</div>
 
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

<table class="table table-bordered table-hover">
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
        <!-- // foreach($products as $product) : // : istead of '{' ?> -->
            @foreach($products as $product)
        
        <tr>
            <td><img src="{{ $product->image_url }}" width="60" alt=""></td>
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
        <!-- php// endforeach // istead of '}' ?> -->
    </tbody>
</table>


        <!-- to use pagination which in db 
        but i have to initialize it from the appServiceProvider-->
        {{ $products->links() }}
        <!--  i decided to change in pagination internal folder  -->
    



@endsection
