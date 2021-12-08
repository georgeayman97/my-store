@extends('layouts.admin')

@section('title', 'Edit Category')

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Categories</a></li>
            <li class="breadcrumb-item active">Edit</li>
    </ol>

@endsection

@section('content')

<!-- enctype="multipart/form-data" : to know the data typeis image not url -->
<form action="{{ route('categories.update',$category->id) }}" method="post" enctype="multipart/form-data">
    <!-- to use CSRF tokens to protect my_self -->
    @csrf
    <!-- form method spoofing to change the method to put 
     <input type="hidden" name="_method" value="put"> 
                            OR                         -->
    @method('put')
    
    @include('admin.categories._form',[
        'button' => 'update'
        ])

</form>

@endsection