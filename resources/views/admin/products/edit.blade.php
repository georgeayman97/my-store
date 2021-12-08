@extends('layouts.admin')

@section('title', 'Edit Product')

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Edit</li>
    </ol>

@endsection

@section('content')

<!-- enctype="multipart/form-data" : to know the data type is image not url -->
<form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
    <!-- to use CSRF tokens to protect my_self -->
    @csrf
    <!-- form method spoofing to change the method to put 
     <input type="hidden" name="_method" value="put"> 
                            OR                         -->
    @method('put')
    
    @include('admin.products._form',[
        'button' => 'update'
        ])

</form>

@endsection