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

<!-- <h2><?php //echo $title ?></h2> -->

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
        </tr>
    </thead>
    <tbody>
        <!-- we have automatic directives istead of this way -->
        <!-- <?php// foreach($categories as $category) : // : istead of '{' ?> -->
            @foreach($categories as $category)
        
        <tr>
            <td>{{ $loop->first?'First':($loop->last?'Last':$loop->iteration)}}</td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->parent_name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
        </tr>
        @endforeach
        <!-- <?php// endforeach // istead of '}' ?> -->
    </tbody>
</table>

@endsection
