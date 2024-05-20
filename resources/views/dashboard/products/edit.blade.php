@extends('layouts.dashboard')
@section('title')
    Store | Edit products
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Edit product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->

        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card-body"><!-- start of the div -->

                <div class="form-group">
                    <label for="">product Name</label>
                    <input type="text" class="form-control" value="{{ old('name', $product->name) }}" name="name"
                        placeholder="Enter product">
                </div>
                <div class="form-group">
                    <label for="">product Description</label>
                    <textarea class="form-control" name="description">{{ old('description', $product->description) }} </textarea>
                </div>


                <div class="form-group">
                    <label for="">product Category</label>
                    <select class="form-control form-select" name="category_id">
                        <option value="">Primary product</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category->id))>{{ $product->category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">product Store</label>
                    <select class="form-control form-select" name="store_id">
                        <option value="">Primary Store</option>
                        @foreach ($stores as $store)
                            <option value="{{ $product->store->id }}" @selected(old('store_id', $product->store_id))>
                                {{ $product->store->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">product Price</label>
                    <input type="number" value="{{ old('price', $product->price) }}" @class(['form-control', 'is-invalid' => $errors->has('price')]) name="price"
                        placeholder="Enter price">
                    @error('price')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">product Comparing price</label>
                    <input type="number" value="{{ old('compare_price', $product->compare_price) }}" @class([
                        'form-control',
                        'is-invalid' => $errors->has('compare_price'),
                    ])
                        name="compare_price" placeholder="Enter compare price">
                    @error('compare_price')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">product Status</label>

                    <div class="form-group">
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="status" value="active"
                                @checked(old('status', $product->status) == 'active')>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="archive"
                                @checked(old('status', $product->status) == 'archive')>
                            <label class="form-check-label">Archive</label>
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="exampleInputFile">product Image</label>
                    <input type="file" class="form-control" name="image">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="image" height="70">
                    @endif
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
                    <button type="submit" class="btn btn-primary">Upadate</button>
                </div>
            </div><!-- end of the div -->
        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
