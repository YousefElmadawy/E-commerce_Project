@extends('layouts.dashboard')
@section('title')
    Store | Create Categories
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Starter Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <h3>Occur Error!!</h3>
                <ul>
                    @foreach ( $errors->all() as $error )
                        <li>{{$error}}</li>
                    @endforeach
                    
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card-body"><!-- start of the div -->

                <div class="form-group">
                    <label for="">Category Name</label>
                    <input type="text" value="{{old('name')}}" @class(['form-control', 'is-invalid'=>$errors->has('name')]) name="name" placeholder="Enter Category">
                    @error('name')
                        <div class="text text-danger">
                            {{ $message}}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Category Parent</label>
                    <select class="form-control form-select" name="parent_id">
                        <option value="">Primary Category</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                     
                </div>

                <div class="form-group">
                    <label for="">Category Description</label>
                    <textarea class="form-control"   name="description"> {{old('description')}}</textarea>
                </div>

                <div class="form-group">
                    <label for="">Category Status</label>

                    <div class="form-group">
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="status" value="active" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="archive">
                            <label class="form-check-label">Archive</label>
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Category Image</label>
                    <input type="file" class="form-control" name="image">
                    {{-- <div class="input-group">
                        <div class="custom-file">
                           
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div> --}}
                </div>


                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div><!-- end of the div -->
        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
