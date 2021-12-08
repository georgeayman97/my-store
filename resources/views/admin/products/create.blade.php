@extends('layouts.admin')

@section('title', 'Create New Product')

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Create</li>
    </ol>

@endsection

@section('content')

<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    <!-- to use CSRF tokens to protect my_self -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @include('admin.products._form',[
        'button' => 'Create'
        ])

</form>

@endsection