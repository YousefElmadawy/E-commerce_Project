@extends('layouts.dashboard')
@section('title')
    Store | Categories
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Categories</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <div class="col-md-3 ">
                            <a href="{{ route('categories.create') }}">
                                <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                            </a>
                            <hr>
                            <a href="{{ route('categories.trash') }}">
                                <button type="submit" class="btn btn-dark btn-block"> Trash</button>
                            </a>
                        </div>
                        <hr>

                        <x-alert />
                        <!-- search form -->
                        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 590px;">
                                    <input type="text" name="name" class="form-control float-right mx-2 "
                                        placeholder="Name" value="{{ request('name') }}">
                                    <select name="status" class="form-control float-right mx-2" placeholder="Status">
                                        <option value="">All</option>
                                        <option value="active" @selected(request('status') == 'active')>Active</option>
                                        <option value="archived" @selected(request('status') == 'archived')>archived</option>
                                    </select>

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            Filter <i class="fas fa-filter"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end search form -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Parent</th>
                                    <th>Products #</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if (!$categories) --}}
                                <?php $i = 0; ?>
                                @forelse ($categories as $category)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a
                                                href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                                        </td>
                                        <td>{{ $category->parent->name }} </td>
                                        <td>{{ $category->products_count }} </td>
                                        {{-- <td><span class="tag tag-success">Approved</span></td> --}}
                                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="image"
                                                height="50"> </td>
                                        <td>{{ $category->status }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary">Actions</button>
                                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('categories.edit', $category->id) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"><i
                                                                class="fas fa-trash"></i> Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="alert alert-info alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true">&times;</button>
                                                <h5><i class="icon fas fa-info"></i> Alert!</h5>
                                                NO Categories Defiened ...
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse




                            </tbody>
                        </table>
                    </div>
                    {{ $categories->withQueryString()->links() }}
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
