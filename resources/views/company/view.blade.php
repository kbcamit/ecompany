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
                    Companies
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td><img src="{{ asset($company->image) }}" border="0" width="40"
                                             class="img-circle"></td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>
                                        <a href="{{ url('/company/'.$company->id.'/edit') }}"
                                           class="btn btn-success" title="Edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="#" id="{{ $company->id }}"
                                           class="btn btn-danger"
                                           title="Delete" onclick="return myFunction(this.id);">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                        <form action="{{ action('CompanyController@destroy', $company->id) }}"
                                              method="post" style="display: none" id="delete-form{{ $company->id }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
    <!-- /.row -->
@endsection

<script>
    function myFunction(id) {
        if (confirm("Are You Sure to delete this")) {
            event.preventDefault();
            document.getElementById('delete-form' + id).submit();
        } else {
            return false;
        }
    }
</script>
