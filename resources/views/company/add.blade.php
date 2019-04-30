@extends('master')

@section('title')
    Company
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Company</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Company
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
                            <form role="form" action="{{action('CompanyController@store')}}" method="post"
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
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                           value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="" style="color: red" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" rows="3"></textarea>
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
