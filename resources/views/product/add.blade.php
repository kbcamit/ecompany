@extends('master')

@section('title')
    Product
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Product
                    @if(Session::has('successMessage'))
                        <h4 style="color:green;">{{ Session::get('successMessage') }}</h4>
                    @endif
                    @if(Session::has('errorMessage'))
                        <h4 style="color:red;">{{ Session::get('errorMessage') }}</h4>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" action="{{action('ProductController@store')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" name="name" required value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" step="any" class="form-control" name="qty" required
                                           value="{{ old('qty') }}">
                                    @if ($errors->has('qty'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('qty') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select class="form-control" name="supplier_id" required>
                                        <option value="">--Select--</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-default btn-success">Submit Button</button>
                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
