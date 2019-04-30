@extends('master')

@section('title')
    Supplier
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Supplier</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Supplier
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
                            <form role="form" action="{{action('SupplierController@update', $supplier->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" name="name" required value="{{ $supplier->name }}">
                                    @if ($errors->has('name'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                           value="{{ $supplier->email }}">
                                    @if ($errors->has('email'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" rows="3">{{ $supplier->address }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image">
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
