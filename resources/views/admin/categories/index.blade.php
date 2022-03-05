@extends('layouts.admin')

@section('title')
{{$title}} <a href="/admin/categories/create">Create</a>
@endsection

@section('breadcrumb')

    <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
    </ol>

@endsection

@section('content')

<x-alert />

<!-- <h2>php //echo $title </h2> -->

<table class="table">
    <thead>
        <tr>
            
            <th>LOOB</th>
            <th>ID</th>
            <th>NAME</th>
            <th>SLUG</th>
            <th>PARENT ID</th>
            <th>STATUS</th>
            <th>CREATED AT</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <!-- we have automatic directives istead of this way -->
        <!-- php// foreach($categories as $category) : // : istead of '{'  -->
            @foreach($categories as $category)
        
        <tr>
            
            <td>{{ $loop->first?'First':($loop->last?'Last':$loop->iteration)}}</td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->original_name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->parent_name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
            <td><a href="{{ route('categories.edit', $category->id)}}" class="btn btn-sm btn-dark">Edit</a></td>
            <td><form action="{{ route('categories.destroy', $category->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form></td>
        </tr>
        @endforeach
        <!-- php// endforeach // istead of '}'  -->
    </tbody>
</table>



@endsection
